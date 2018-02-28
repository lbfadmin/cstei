<?php
/**
 * Created by PhpStorm.
 * User: kevin
 * Date: 15-11-2
 * Time: 下午6:10
 */

namespace Application\Controller;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

/**
 * 命令行控制器基类
 * Class Cli
 * @package Controller
 */
class Cli extends Api
{

    /**
     * @var Application
     */
    protected $console = null;

    /**
     * @var Command
     */
    protected $command = null;

    public function __construct($args = [])
    {
        $this->options['export'] = 'raw';
        parent::__construct();

        $this->console = new Application();
        $this->command = $this->console->register($this->thread->getPath());
    }

}