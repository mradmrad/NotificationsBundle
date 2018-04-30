<?php
namespace SBC\NotificationsBundle\Model;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use Symfony\Component\Routing\RouterInterface;


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
     * Build notifications on entity creation
     * @param NotificationBuilder $builder
     * @return NotificationBuilder
     */
    public function notificationsOnCreate(NotificationBuilder $builder);

    /**
     * Build notifications on entity update
     * @param NotificationBuilder $builder
     * @return NotificationBuilder
     */
    public function notificationsOnUpdate(NotificationBuilder $builder);

    /**
     * Build notifications on entity delete
     * @param NotificationBuilder $builder
     * @return NotificationBuilder
     */
    public function notificationsOnDelete(NotificationBuilder $builder);

}