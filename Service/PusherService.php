<?php

namespace SBC\NotificationsBundle\Service;


use Psr\Container\ContainerInterface;
use Pusher\Pusher;
use SBC\NotificationsBundle\DependencyInjection\Configuration;
use SBC\NotificationsBundle\Logger\PusherLogger;

/**
 * Class PusherService
 * Create an instance of Pusher with the given configuration
 * @package SBC\NotificationsBundle\Service
 *
 * @author: Slimen Arnaout <arnaout.slimen@gmail.com>
 */
class PusherService
{
    /**
     * @var Pusher
     */
    private $pusher;

    /**
     * @var ContainerInterface
     */
    private $container;
    
    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->initPusher();
        
    }

    /**
     * Init Pusher instance
     */
    private function initPusher(){
        $parameters = $this->container->getParameter(Configuration::CONFIGURATION_NAME);
        $options = array(
            'cluster' => $parameters['cluster'],
            'encrypted' => true
        );

        $this->pusher = new Pusher(
            $parameters['app_key'],
            $parameters['app_secret'],
            $parameters['app_id'],
            $options
        );
    }
    
    public function trigger($data){
        $this->pusher->trigger('my-channel', 'my-event', $data);
    }
    
    public function dumpConfiguration(){
        var_dump($this->pusher->getSettings());
    }
    
    public function enableLogger(){
        $logger = new PusherLogger();
        $this->pusher->set_logger($logger);
    }
}