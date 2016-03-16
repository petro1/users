<?php
namespace UsersBundle\DAO;

use UsersBundle\Entity\Users as User;

class UsersDAO
{
    public function __construct()
    {

    }

    public function createAction()
    {
        $user = new User();
        $user->setName('Jonathan H. Wage');

        $em = $this->get('doctrine')->getEntityManager();
        $em->persist($user);
        $em->flush();

        // ...
    }

    public function editAction($id)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $user = $em->find('UsersBundle:User', $id);
        $user->setBody('new body');
        $em->persist($user);
        $em->flush();

        // ...
    }

    public function deleteAction($id)
    {
        $em = $this->get('doctrine')->getEntityManager();
        $user = $em->find('UsersBundle:User', $id);
        $em->remove($user);
        $em->flush();

        // ...
    }
}
