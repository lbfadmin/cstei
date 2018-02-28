<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-4-22
 * Time: 下午2:36
 */

namespace Application\Component\Io;


use OSS\Core\MimeTypes;
use OSS\Core\OssException;
use OSS\OssClient;
use System\Component\Crypt\Hash;

class Oss
{

    private $config = [];

    private $client = null;

    private $bucket = '';

    public function __construct($config)
    {
        $this->config = $config;
        $this->client = new OssClient(
            $config['accessKeyId'],
            $config['accessKeySecret'],
            $config['endpoint']
        );
        $this->bucket = $config['bucket'];
    }

    /**
     * 删除对象
     * @param string $key
     * @return mixed
     */
    public function deleteObject(string $object)
    {
        $this->client->deleteObject(
            $this->bucket,
            $object
        );
    }

    /**
     * 保存远程文件
     *
     * @api
     *
     * @param array $args
     * @return mixed
     */
    public function putRemoteFile($url)
    {
        $content = file_get_contents($url);
        return $this->putObject($url, $content);
    }

    /**
     * 上传本地文件
     * @param array $file
     * @return array
     */
    public function putLocalFile($file)
    {
        return $this->putObject($file['name'], file_get_contents($file['tmp_name']));
    }

    public function putStreamFile($name, $content)
    {
        return $this->putObject($name, $content);
    }

    /**
     * 提取文件信息
     * @param string $name
     * @param string $content
     * @return mixed
     */
    public function getFileInfo($name, $content)
    {
        $info = pathinfo(urlencode($name));
        $key = $this->generateFilename();
        $data = array(
            'key' => '',
            'ext' => isset($info['extension']) ? $info['extension'] : '',
            'name' => urldecode($info['basename']),
            'meta' => array(
                'size' => strlen($content)
            )
        );
        // 获取MIME类型
        $fileInfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime = $fileInfo->buffer($content);
        if ($mime === 'application/octet-stream') {
            $mime = MimeTypes::getMimetype('.' . $data['ext']);
        }
        $data['mime'] = $mime;
        // 尝试解析图片
        if (preg_match('#^image/#i', $mime)) {
            $im = new \Imagick();
            $im->readImageBlob($content);
            // 获取图片信息
            if ($im->valid()) {
                $size = $im->getImageGeometry();
                $data['meta']['width'] = $size['width'];
                $data['meta']['height'] = $size['height'];
                $ext = strtolower($im->getImageFormat());
                $data['ext'] = $ext === 'jpeg' ? 'jpg' : $ext;
            }
        }
        $data['key'] = "{$key}.{$data['ext']}";
        return $data;
    }

    /**
     * 保存对象
     * @param $name
     * @param $content
     * @param array $options
     * @return mixed
     */
    private function putObject($name, $content, $options = [])
    {
        $fileInfo = $this->getFileInfo($name, $content);
        $options = array_merge([
            OssClient::OSS_CONTENT_TYPE => $fileInfo['mime'],
            OssClient::OSS_CONTENT_LENGTH => $fileInfo['meta']['size']
        ], $options);
        // 上传到oss
        try {
            $this->client->putObject(
                $this->bucket,
                $fileInfo['key'],
                $content,
                $options
            );
        } catch (OssException $e) {
            return false;
        }
        return $fileInfo;
    }

    /**
     * 生成一个唯一的文件名
     */
    protected function generateFilename()
    {
        $hash = new Hash();
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return
            $hash->encrypt(
                time() . '-' . uniqid() . '-' . $hash->randomString(4, $chars),
                $this->config['salt'], $chars
            );
    }
}