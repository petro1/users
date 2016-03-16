<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SearchBundle\DAO;

use Doctrine\DBAL\Connection;

use SearchBundle\Entities\User;
/**
 * Description of SearchDAO
 *
 * @author ptanco
 */
class SearchDAO
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function search(User $user)
    {
        $qb = $this->connection->createQueryBuilder();
        $qb->select('u.*')
            ->from('users', 'u');

        $first_name = $user->getFirstName();
        if (isset($first_name)) {
            $qb->where('lower(u.first_name) LIKE :first_name')
               ->setParameter('first_name', '%'.strtolower($first_name).'%');
        }
        $qb->setFirstResult(0)
            ->setMaxResults(10);
        
        return $qb->execute()->fetchAll();
    }
    
}