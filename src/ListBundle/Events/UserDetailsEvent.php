<?php
namespace ListBundle\Events;

use Symfony\Component\EventDispatcher\Event;
/**
 * Description of UserDetailsEvent
 *
 * @author ptanco
 */
class UserDetailsEvent extends Event
{
    const USER_DETAILS_CALL = 'user.details';

    private $userId;

    public function __construct($userId)
    {
        $this->userId = $userId;
    }

    public function getUserId()
    {
        return $this->userId;
    }
}