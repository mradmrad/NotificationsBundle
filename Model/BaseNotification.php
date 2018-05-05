<?php
namespace SBC\NotificationsBundle\Model;
use Doctrine\ORM\Mapping as ORM;

/**
 * Extend from this class to build a base notification entity
 *
 * Class BaseNotification
 * @package SBC\NotificationsBundle\Model
 *
 * @author: Haithem Mrad <haithem.mrad@sbc.tn>
 * @author: Slimen Arnaout <arnaout.slimen@gmail.com>
 */
abstract class BaseNotification
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(name="icon", type="string", length=255, nullable=true)
     */
    protected $icon;

    /**
     * @var string
     *
     * @ORM\Column(name="route", type="string", length=255, nullable=true)
     */
    protected $route;

    /**
     * @var array
     *
     * @ORM\Column(name="route_parameters", type="array", nullable=true)
     */
    protected $parameters;

    /**
     * @var \DateTime
     * 
     * @ORM\Column(name="notification_date", type="datetime")
     */
    protected $date;

    /**
     * @var bool
     * 
     * @ORM\Column(name="seen", type="boolean")
     */
    protected $seen;

    /**
     * @var string
     *
     * This attribute will be filled automatically when we broadcast the notification
     * (exactly when we call the trigger() function of the notification service 'mrad.pusher.notifications')
     * if the route parameter is not empty the bundle will generate a full url out of it
     * so we can use it in javascript
     */
    protected $fullUrl;

    public function __construct()
    {
        $this->date = new \DateTime('now', new \DateTimeZone('Etc/GMT'));
        $this->seen = false;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return BaseNotification
     */
    public function setTitle($title)
    {
        $this->title = $title;
        
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return BaseNotification
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getIcon()
    {
        return $this->icon;
    }

    /**
     * @param string $icon
     * @return BaseNotification
     */
    public function setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }

    /**
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * @param string $route
     * @return BaseNotification
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * @param array $parameters
     * @return BaseNotification
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return BaseNotification
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullUrl()
    {
        return $this->fullUrl;
    }

    /**
     * @param string $fullUrl
     * @return BaseNotification
     */
    public function setFullUrl($fullUrl)
    {
        $this->fullUrl = $fullUrl;

        return $this;
    }

    /**
     * @return boolean
     */
    public function isSeen()
    {
        return $this->seen;
    }

    /**
     * @param boolean $seen
     * @return BaseNotification
     */
    public function setSeen($seen)
    {
        $this->seen = $seen;
        
        return $this;
    }
}