<?php
namespace SBC\NotificationsBundle\Builder;
use SBC\NotificationsBundle\Model\BaseNotification;

/**
 * Class NotificationBuilder
 * 
 * @package SBC\NotificationsBundle\Builder
 * @author Slimen Arnaout <arnaout.slimen@gmail.com>
 */
class NotificationBuilder
{
    /**
     * @var array
     */
    private $notifications = array();

    /**
     * Add notification to the builder
     * @param $notification
     * @return NotificationBuilder
     */
    function addNotification(BaseNotification $notification){
        $this->notifications[] = $notification;
        
        return $this;
    }

    /**
     * Return built notifications
     * @return array
     */
    function getNotifications(){
        return $this->notifications;
    }

    /**
     * Check if builder has notifications
     * @return bool
     */
    function isEmpty(){
        return empty($this->notifications);
    }
}