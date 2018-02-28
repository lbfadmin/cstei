<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-7-1
 * Time: 下午5:03
 */

namespace Module\Content\Controller\Script;


use Application\Controller\Cli;
use Module\Content\IndexModel\GoodsIndexModel;
use Module\Content\Model\GoodsModel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use System\Component\Util\StringUtil;
use System\Loader;

/**
 * 商品索引
 * Class GoodsIndex
 * @package Module\Content\Controller\Script
 */
class GoodsIndex extends Cli
{

    /**
     * 创建索引
     */
    public function createIndex()
    {
        $this->command
            ->setCode(function (InputInterface $input, OutputInterface $output) {
                $indexModel = new GoodsIndexModel();
                $file = Loader::find('Module\Content\Resource\mappings\goods', '.json');
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
     * 索引全部数据
     */
    public function indexAll()
    {
        $this->command
            // 指定索引的名称
            ->setCode(function (InputInterface $input, OutputInterface $output) {
                $id = 0;
                $limit = 1000;
                $model = new GoodsModel();
                $indexModel = new GoodsIndexModel();
                while (true) {
                    $output->writeln("边界ID：{$id}");
                    $sql = "SELECT * "
                        . " FROM content_goods"
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
                                'name' => $item->name,
                                'time_created' => $item->time_created,
                                'time_updated' => $item->time_updated,
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