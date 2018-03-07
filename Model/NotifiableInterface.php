<?php
namespace SBC\NotificationsBundle\Model;
use SBC\NotificationsBundle\Builder\NotificationBuilder;


/**
 * Interface Notifiable
 * @package NotificationsBundle\Entity
 * 
 * @author: Haithem Mrad <haithem.mrad@sbc.tn>
 * @author: Slimen Arnaout <arnaout.slimen@gmail.com>
 */
interface NotifiableInterface
{

    /**
     * @param NotificationBuilder $builder
     * @return NotificationBuilder
     */
    public function buildNotifications(NotificationBuilder $builder);
}