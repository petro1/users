<?php
namespace UsersBundle\Services;

use UsersBundle\Criteria\UsersCriteria;
/**
 *
 * @author ptanco
 */
interface UsersServiceInterface
{
    /*
     * Get users list and validate $criteria
     * @param UsersCriteria $criteria
     * @return array
     */
    public function getUsersList(UsersCriteria $criteria);

    /*
     * Get single user details and validate $userId
     * Dispatch Event UserDetailsEvent
     * @param int $userId
     * @return array
     */
    public function getUserDetails($userId);
}