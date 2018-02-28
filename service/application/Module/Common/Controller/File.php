<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-7-5
 * Time: 上午10:24
 */

namespace Module\Common\Controller;


use Application\Component\Io\Oss;
use Application\Controller\Api;
use Module\Common\Model\TempFileModel;

/**
 * 文件操作
 * Class File
 * @package Module\Common\Controller
 */
class File extends Api
{

    /**
     * 上传
     * @return mixed
     */
    public function upload()
    {
        $field = $this->input->getString('field');
        $isTemp = $this->input->getInt('is_temp', 1);
        if (empty($_FILES)) {
            return $this->export([
                'code' => $this->code('INVALID_FILE_LIST'),
                'message' => '无效的文件列表'
            ]);
        }
        $file = empty($field) ? current($_FILES) : $_FILES[$field];
        if (!empty($file) && !$file['error']) {
            /* @var Oss $oss */
            $oss = $this->di->get('oss.main');
            $contents = file_get_contents($file['tmp_name']);
            $fileInfo = $oss->getFileInfo($file['name'], $contents);
            $result = $oss->putStreamFile($file['name'], $contents);
            if ($result) {
                $baseUrl = preg_match('#^image/#i', $fileInfo['mime'])
                    ? $this->config['common']['imageBaseUrl']
                    : $this->config['common']['fileBaseUrl'];
                $result['url'] = $baseUrl . $result['key'];
                $tempFileModel = new TempFileModel();
                try {
                    if ($isTemp) {
                        // 待回收
                        $tempFileModel->add([
                            'file_key' => $result['key'],
                            'time_created' => date('Y-m-d H:i:s')
                        ]);
                    }
                    return $this->export([
                        'data' => $result
                    ]);
                } catch (\Exception $e) {
                    $oss->deleteObject($result['key']);
                    return $this->export([
                        'code' => $this->code('FAILED_TO_SAVE_FILE'),
                        'message' => '存储文件失败'
                    ]);
                }
            } else {
                return $this->export([
                    'code' => $this->code('FAILED_TO_SAVE_FILE'),
                    'message' => '存储文件失败'
                ]);
            }
        } else {
            return $this->export([
                'code' => $this->code('INVALID_FILE'),
                'message' => '无效的文件'
            ]);
        }
    }
}