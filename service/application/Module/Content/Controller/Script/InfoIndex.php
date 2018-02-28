<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-7-1
 * Time: 下午5:03
 */

namespace Module\Content\Controller\Script;


use Application\Controller\Cli;
use Module\Content\IndexModel\InfoIndexModel;
use Module\Content\Model\InfoModel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use System\Component\Util\StringUtil;
use System\Loader;

/**
 * 资讯索引
 * Class InfoIndex
 * @package Module\Content\Controller\Script
 */
class InfoIndex extends Cli
{

    /**
     * 创建索引
     */
    public function createIndex()
    {
        $this->command
            ->setCode(function (InputInterface $input, OutputInterface $output) {
                $indexModel = new InfoIndexModel();
                $file = Loader::find('Module\Content\Resource\mappings\info', '.json');
                $contents = file_get_contents($file);
                $params = [
                    'index' => $indexModel->index,
                    'body' => json_decode($contents, true)
                ];
                try {
                    $response = $this->elasticsearch->indices()->create($params);
                    $output->writeln($response);
                } catch (\Exception $e) {
                    $output->writeln('<error>错误：</error>');
                    $output->writeln($e->getMessage());
                }
            });
        $this->console->run();
    }

    /**
     * 删除索引
     */
    public function dropIndex()
    {
        $this->command
            ->setCode(function (InputInterface $input, OutputInterface $output) {
                $indexModel = new InfoIndexModel();
                $params = [
                    'index' => $indexModel->index,
                ];
                try {
                    $response = $this->elasticsearch->indices()->delete($params);
                    if ($response['acknowledged']) {
                        $output->writeln('<info>索引删除成功！</info>');
                    } else {
                        $output->writeln(json_encode($response));
                    }
                } catch (\Exception $e) {
                    $output->writeln('<error>索引删除失败：</error>');
                    $output->writeln($e->getMessage());
                }
            });
        $this->console->run();
    }

    /**
     * 索引全部数据
     */
    public function indexAll()
    {
        $this->command
            // 指定索引的名称
            ->setCode(function (InputInterface $input, OutputInterface $output) {
                $id = 0;
                $limit = 1000;
                $model = new InfoModel();
                $indexModel = new InfoIndexModel();
                while (true) {
                    $output->writeln("边界ID：{$id}");
                    $sql = "SELECT * "
                        . " FROM content_info"
                        . " WHERE id > ?"
                        . " LIMIT {$limit}";
                    $result = $model->db->fetchAll($sql, [$id]);
                    $count = 0;
                    $data = [];
                    $ids = [];
                    foreach ($result as $item) {
                        $count++;
                        $ids[$item->id] = $item->id;
                        $data[] = [
                            'id' => $item->id,
                            'doc' => [
                                'id' => $item->id,
                                'category_id' => $item->category_id,
                                'title' => $item->title,
                                'source' => $item->source,
                                'keywords' => $item->keywords,
                                'summary' => $item->summary,
                                'body' => $item->body,
                                'time_created' => $item->time_created,
                                'time_updated' => $item->time_updated,
                                'time_published' => $item->time_published == '0000-00-00 00:00:00'
                                    ? null : $item->time_published,
                                'status' => $item->status,
                            ]
                        ];
                        $id = $item->id;
                    }
                    $output->writeln('处理：' . implode(', ', $ids));
                    $mem = StringUtil::formatSize(memory_get_usage(true));
                    $output->writeln("{$count} 完成 (内存: {$mem}).");
                    $result = $indexModel->indexAll($data);
                    if ($count < $limit) {
                        break;
                    }
                }
                $output->writeln('索引完毕.');
            });
        $this->console->run();
    }
}