<?php

namespace SBC\NotificationsBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * This command push message from server with debug mode to check if the bundle 
 *  is working correctly
 * Class PusherTestCommand
 * 
 * @package SBC\NotificationsBundle\Command
 * @author: Slimen Arnaout <arnaout.slimen@gmail.com>
 */
class PusherTestCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('notifications:trigger')
            ->setDescription('Test Notifications Bundle with a simple message and display debug message')
            ->addArgument('message', InputArgument::OPTIONAL, 'Your message that you want to push to client (optional)')
            ->addArgument('channel', InputArgument::OPTIONAL, 'Channel where you want to push this message (optional)')
            ->addOption('option', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Pushing message ...');
        $message = $input->getArgument('message');
        $channel = $input->getArgument('channel');
        if ($input->getOption('option')) {
            // ...
        }

        $data = array(
            'test-message' => ($message != '') ? $message : 'Hello from server',
        );
        $pusher = $this->getContainer()->get('mrad.pusher.notificaitons');
        $pusher->enableLogger();
        if($channel != '')
            $pusher->trigger($data, $channel);
        else
            $pusher->trigger($data);

        $output->writeln('Complete.');
    }

}
