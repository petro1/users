<?php
namespace UsersBundle\Services;

use UsersBundle\Services\UsersDAO;
use UsersBundle\Criteria\UsersCriteria;
use UsersBundle\Entities\User;
use UsersBundle\Events\UserDetailsEvent;

use Symfony\Component\Validator\ValidatorInterface;
use Symfony\Component\Validator\Constraints\Type as TypeConstraint;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
//use Guzzle\Http\Client as GuzzleClient;
//use Guzzle\Http\Exception\RequestException;

/**
 * Description of UsersService
 *
 * @author ptanco
 */
class UsersService implements UsersServiceInterface
{
    private $DAO;

    private $validator;

    private $dispatcher;

    public function __construct(
        UsersDAO $DAO,
        ValidatorInterface $validator
    ) {
        $this->DAO = $DAO;
        $this->validator = $validator;
    }

    /*
     * Inject EventDispatcherInterface
     */
    public function setEventDispatcher(EventDispatcherInterface $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /*
     * {@inheritdoc}
     */
    public function getUsersList(UsersCriteria $criteria)
    {
        $errors = $this->validator->validate($criteria);

        if (count($errors) > 0){
            $result['errors'] = array();
            foreach($errors as $error) {
                array_push($result['errors'], $error->getMessage());
            }
            return $result;
        }
        
        $result = $this->DAO->getUsersList($criteria);
        
        return $result;
    }

    /*
     * {@inheritdoc}
     */
    public function getUserDetails($userId)
    {
        $c1 = array("type" => "digit", "message" => "User id must contain only digits");
        $userIdConstraint = new TypeConstraint($c1);
        $errors = $this->validator->validateValue($userId, $userIdConstraint);

        if (count($errors) > 0){
            $result['errors'] = array();
            foreach($errors as $error) {
                array_push($result['errors'],$error->getMessage());
            }
            return $result;
        }

        $result = $this->DAO->getUserDetails($userId);

        if (!is_null($this->dispatcher)) {
            $this->dispatcher->dispatch(
                UserDetailsEvent::USER_DETAILS_CALL,
                new UserDetailsEvent($userId)
            );
        }

        return $result;
    }
    
    /*
     * Update User details
     */
    public function updateUser(User $user)
    {
        $errors = $this->validator->validate($user);
        if (count($errors) > 0){
            $result['errors'] = array();
            foreach($errors as $error) {
                array_push($result['errors'], $error->getMessage());
            }
            return $result;
        }
        
        $updated = $this->DAO->updateUser($user);
        //to do refresh user cache if updated using event dispatcher

//    $request = $this->httpClient->post(
//            self::POST_MESSAGE_ROUTE,
//            array('Accept' => 'application/json'),
//            $body,
//            array()
//        );
//        try {
//            $request->send();
//        } catch (RequestException $e) {
//            throw $e;
//        }
    }

}