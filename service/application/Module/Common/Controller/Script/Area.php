<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 16-11-24
 * Time: 下午7:54
 */

namespace Module\Common\Controller\Script;


use Application\Controller\Cli;
use Module\Common\Component\AreaCrawler;
use Module\Common\Model\AreaModel;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * 抓取地区数据CLI
 * Class Area
 * @package Module\Common\Controller\Script
 */
class Area extends Cli
{
    public function fetch()
    {
        $this->command->setCode(function (InputInterface $input, OutputInterface $output) {
            $areaModel = new AreaModel();
            $crawler = new AreaCrawler($areaModel);
            try {
                $crawler->crawl();
            } catch (\Exception $e) {
                $output->writeln($e->getMessage());
                $output->writeln(print_r($e->getTraceAsString(), true));
            }
        });
        $this->console->run();
    }
}