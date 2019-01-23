<?php

namespace SBC\NotificationsBundle\Service;


use Psr\Container\ContainerInterface;
use Pusher\Pusher;
use SBC\NotificationsBundle\DependencyInjection\Configuration;
use SBC\NotificationsBundle\Logger\PusherLogger;
use SBC\NotificationsBundle\Model\BaseNotification;

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
            'encrypted' => $parameters['encrypted']
        );

        $this->pusher = new Pusher(
            $parameters['app_key'],
            $parameters['app_secret'],
            $parameters['app_id'],
            $options
        );
    }
    
    public function trigger($data, $channel = 'notifications'){
        
        // check if we have a BaseNotification objects
        // so we can build the fullUrl attribute
        if($data instanceof BaseNotification){
            $data = $this->buildFullURL($data);
        }
        
        else if(is_array($data)){
            foreach ($data as $key => $item){
                if($data instanceof BaseNotification){
                    $data[$key] = $this->buildFullURL($item);
                }
            }
        }
        
        // broadcast data
        $this->pusher->trigger($channel, 'my-event', $data);
    }

    /**
     * @param BaseNotification $notification
     * @return BaseNotification
     */
    private function buildFullURL(BaseNotification $notification){
        if($notification->getRoute() != null && $notification->getRoute() != ''){
            if($notification->getParameters() != null){
                $fullUr = $this->container
                    ->get('router')
                    ->generate($notification->getRoute(), $notification->getParameters());
            }else{
                $fullUr = $this->container
                    ->get('router')
                    ->generate($notification->getRoute());
            }
            $notification->setFullUrl($fullUr);
        }

        return $notification;
    }
    
    public function dumpConfiguration(){
        var_dump($this->pusher->getSettings());
    }
    
    public function enableLogger(){
        $logger = new PusherLogger();
        $this->pusher->set_logger($logger);
    }
}