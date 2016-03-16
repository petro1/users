<?php

namespace SearchBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use SearchBundle\Entities\User;

class SearchController extends Controller
{

    public function indexAction(Request $request)
    {
        $service = $this->get('search_cache');
        $user    = new User;
        $user->setFirstName($request->get('name'));
//        print_r($user);
        try {
            $results['search'] = $service->search($user);
        } catch (Exception $ex) {
            throw $ex->getMessage();
        }
        $response = new Response(json_encode($results));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}