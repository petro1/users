<?php
namespace UsersBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use UsersBundle\Criteria\UsersCriteria;
use UsersBundle\Entities\User;

class UsersController extends Controller
{
    /*
     * Home page
     * @param Request
     * @param String $name
     * @param int $page
     * @param int $per_page
     * @return view
     */
    public function indexAction(Request $request)
    {
        $service = $this->get('users.users_list_service');
        $criteria = new UsersCriteria;
        $criteria->setFirstName($request->get('name'));
        $criteria->setPerPage($request->get('perPage'));
        $criteria->setPage($request->get('page'));
        $criteria->setSex($request->get('gender'));        

        try {
            $users = $service->getUsersList($criteria);
        } catch (\Exception $ex) {
            throw $ex;
        }

        return $this->render('UsersBundle:Users:index.html.twig', 
            array('users' => $users, 'currentPage' => $criteria->getPage()));
    }

     /*
     * Users details get cache data or query db
     * @param int $userId
     * @return view
     */
    public function getUserDetailsAction($userId)
    {        
        $service = $this->get('users.users_service_cache');
        try {
            $userDetails = $service->getUserDetails($userId);
        } catch (\Exception $ex) {
            throw $ex;
        }

        return $this->render('UsersBundle:Users:details.html.twig',
            array('userDetails' => $userDetails));
    }

    /*
     * Users details get cache data or query db
     * @param int $userId
     * @return view
     */
    public function editAction($userId)
    {
        $request = $this->get('request');
        $service = $this->get('users.users_list_service');

        try {
            $userDetails = $service->getUserDetails($userId);
        } catch (\Exception $ex) {
            throw $ex;
        }
        
        $user = new User();
        $user->setFirstName($userDetails['first_name']);
        $user->setLastName($userDetails['last_name']);

        $form = $this->createFormBuilder($user)
            ->add('first_name', 'text')
            ->add('last_name', 'text')
            ->add('save', 'submit', array('label' => 'Update'))
            ->getForm();
        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $user = new User;
                    $user->setId($userId);
                    $user->setFirstName($form["first_name"]->getData());
                    $user->setLastName($form["last_name"]->getData());
                    $service->updateUser($user);

             return $this->redirectToRoute('users_homepage');
            }
        }

        return $this->render('UsersBundle:Users:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
