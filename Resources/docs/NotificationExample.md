# Create and persist notifications
Now let's say you have an entity called `Comment` and you want to trigger notification
each time an entity of `Comment` type is created, then you need to do the following things:<br>

### Step 1
Create a Notification entity that extends from `BaseNotification`:<br>

```php
<?php

namespace YourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Model\BaseNotification;

/**
 * Notification
 *
 * @ORM\Table(name="notification")
 * @ORM\Entity(repositoryClass="YourBundle\Repository\NotificationRepository")
 */
class Notification extends BaseNotification implements \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

    function jsonSerialize()
    {
        return get_object_vars($this);
    }


}


```
Make sure your entity implements `\JsonSerializable` so it can be converted to `json` object and fetch it with javascript.<br>

### Step 2
Now create your `Comment` entity:<br>
```php
<?php

namespace YourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use SBC\NotificationsBundle\Builder\NotificationBuilder;
use SBC\NotificationsBundle\Model\NotifiableInterface;

/**
 * Comment
 *
 * @ORM\Table(name="comment")
 * @ORM\Entity(repositoryClass="YourBundle\Repository\CommentRepository")
 */
class Comment implements NotifiableInterface, \JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;


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
     * Set content
     *
     * @param string $content
     *
     * @return Comment
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

     public function notificationsOnCreate(NotificationBuilder $builder)
    {
        $notification = new Notification();
        $notification
            ->setTitle('New comment')
            ->setDescription('New comment has been added "'.$this->content.'"')
            ->setRoute('comment_show')// I suppose you have a show route for your entity
            ->setParameters(array('id' => $this->id))
        ;
        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnUpdate(NotificationBuilder $builder)
    {
        $notification = new Notification();
        $notification
            ->setTitle('Comment updated')
            ->setDescription('"'.$this->content.'" has been updated')
            ->setRoute('comment_show')
            ->setParameters(array('id' => $this->id))
        ;
        $builder->addNotification($notification);

        return $builder;
    }

    public function notificationsOnDelete(NotificationBuilder $builder)
    {
        // in case you don't want any notification for a special event
        // you can simply return an empty $builder
        return $builder;
    }

    function jsonSerialize()
    {
        return get_object_vars($this);
    }


}


```
As you can see your entity must implements `NotificableInterface` interface that will provides 3 methods :
* `notificationsOnCreate(NotificationBuilder $builder)` will be triggered when the entity has been created.
* `notificationsOnUpdate(NotificationBuilder $builder)` will be triggered when the entity has been updated.
* `notificationsOnDelete(NotificationBuilder $builder)` will be triggered when the entity has been deleted.

In each function you can create a `Notification` object (or many) and give it to the `NotificationBuilder` object<br>
In case you do not want a notification for a specific event you can just return an empty $builder (as mentioned in the `notificationsOnDelete` function)

### Step 3
Make sure to update your database schema by calling:<br>
`php bin/console doctrine:schema:update --force`

### That's it
Now when your `Comment` entity will be persisted, updated or deleted a Listener will be triggered and broadcast your notifications to the client
where you can catch it in the `onNotificationsPushed(data)` function in your view.