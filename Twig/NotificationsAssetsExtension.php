<?php
/**
 * Created by PhpStorm.
 * User: SlimenTN
 * Date: 3/6/18
 * Time: 1:43 PM
 */

namespace SBC\NotificationsBundle\Twig;


use Psr\Container\ContainerInterface;
use SBC\NotificationsBundle\DependencyInjection\Configuration;

/**
 * Render needed assets for pusher to work
 * 
 * Class NotificationsAssetsExtension
 * @package SBC\NotificationsBundle\Twig
 * 
 * @author: Slimen Arnaout <arnaout.slimen@gmail.com>
 */
class NotificationsAssetsExtension extends \Twig_Extension
{
    /**
     * @var ContainerInterface
     */
    private $container;

    function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function getFunctions(){
        return array(
            new \Twig_SimpleFunction('notifications_assets', array($this, 'renderAssets')),
        );
    }

    public function renderAssets(){
        $parameters = $this->container->getParameter(Configuration::CONFIGURATION_NAME);
        $assets = '
            <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
            <script>
            // Enable pusher logging - don\'t include this in production
                Pusher.logToConsole = true;
            
                var pusher = new Pusher("'.$parameters['app_key'].'", {
                    cluster: "'.$parameters['cluster'].'",
                    encrypted: true
                });
                
                var channel = pusher.subscribe("my-channel");
                channel.bind("my-event", function(data) {
                    onNotificationsPushed(data);
                });
            </script>
        ';

        echo $assets;
    }

    public function getName()
    {
        return 'notifications.assets.extension';
    }

}