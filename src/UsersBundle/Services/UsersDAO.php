<?php
namespace UsersBundle\Services;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use UsersBundle\Criteria\UsersCriteria;
use UsersBundle\Entities\User;
/**
 * Description of UsersDAO
 *
 * @author ptanco
 */
class UsersDAO
{
    private $connection;

    public function __construct(Connection $dbaccess)
    {
        $this->connection = $dbaccess;
    }

    /*
     * Get all users paginated
     * @param UsersCriteria $criteria
     * $return array
     */
    public function getUsersList(UsersCriteria $criteria)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->from('users', 'u')
                ->select('u.*');
        $name = $criteria->getFirstName();
        if (isset($name)) 
        {
            $queryBuilder->where('lower(u.first_name) LIKE :first_name')
                    ->setParameter('first_name', '%'.strtolower($name).'%');
        }
        $gender = $criteria->getSex();
        if (isset($gender))
        {
            $queryBuilder->where('u.sex = :sex')
                    ->setParameter('sex', $gender);
        }
        $queryBuilder->setFirstResult($criteria->getPage())
                ->setMaxResults($criteria->getPerPage());

        $results = $queryBuilder->execute()->fetchAll();

        return $results;
    }

    /*
     * Get user details
     * @param int $userId
     * @return array
     */
    public function getUserDetails($userId)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->from('users', 'u')
                ->select('u.*')
                ->where('u.id = :id')
                ->setParameter('id', $userId);
        $results = $queryBuilder->execute()->fetch();

        return $results;
    }
    
    public function updateUser(User $user)
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->update('users', 'u')
                ->set('u.first_name', ':first_name')
                ->set('u.last_name', ':last_name')
                ->where('u.id = :id')
                ->setParameter('first_name', $user->getFirstName())
                ->setParameter('last_name', $user->getLastName())
                ->setParameter('id', $user->getId());
        
        return $queryBuilder->execute();
    }
}