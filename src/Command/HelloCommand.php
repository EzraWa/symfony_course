<?php
/**
 * Created by PhpStorm.
 * User: ezrawaalboer
 * Date: 12/02/2019
 * Time: 22:40
 */

namespace App\Command;

use App\Service\Greeting;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HelloCommand extends Command
{

    /**
     * @var Greeting
     */
    private $greeting;

    /**
     * HelloCommand constructor.
     * @param Greeting $greeting
     */
    public function __construct(Greeting $greeting)
    {
        parent::__construct();
        $this->greeting = $greeting;
    }

    protected function configure()
    {
        $this->setName('app:say-hello')
            ->setDescription('Says hello to the user')
            ->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $output->writeln([
            'Hello from the app',
            '==================',
            ''
        ]);
        $output->writeln($this->greeting->greet($name));
    }

}