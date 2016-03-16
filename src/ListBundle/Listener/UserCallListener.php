<?php
namespace ListBundle\Listener;

use ListBundle\Events\UserDetailsEvent;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerAwareInterface;

/**
 * Logs a user call event
 * Example of listener call
 * @author ptanco
 */
class UserCallListener implements EventSubscriberInterface, LoggerAwareInterface
{
    private $logger;

    public function __construct() {}

    /*
     * {@inheritdoc}
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /*
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            UserDetailsEvent::USER_DETAILS_CALL => array('logEvent')
        );
    }

    /*
     * Write user id called in log profile.log
     * @param UserDetailsEvent $event
     */
    public function logEvent(UserDetailsEvent $event)
    {
        if (!is_null($this->logger)) {
            $this->logger->info(' user details called for '.$event->getUserId());
        }
    }
}