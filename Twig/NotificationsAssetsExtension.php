<?php
/**
 * Created by PhpStorm.
 * User: SlimenTN
 * Date: 3/6/18
 * Time: 1:43 PM
 */

namespace SBC\NotificationsBundle\Twig;


use SBC\NotificationsBundle\DependencyInjection\Configuration;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
        $pusherLog = '';

        if($this->container->get('kernel')->getEnvironment() == 'dev'){
            $pusherLog = 'Pusher.logToConsole = true;';
        }
        $assets = '
            <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
            <script>
                '.$pusherLog.'
            
                var pusher = new Pusher("'.$parameters['app_key'].'", {
                    cluster: "'.$parameters['cluster'].'",
                    encrypted: true
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