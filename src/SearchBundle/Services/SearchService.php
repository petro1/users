<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace SearchBundle\Services;

use SearchBundle\DAO\SearchDAO;
use SearchBundle\Entities\User;

use Symfony\Component\Validator\ValidatorInterface;

/**
 * Description of SearchService
 *
 * @author ptanco
 */
class SearchService implements SearchInterface
{
    private $dao;
    private $validator;

    public function __construct(SearchDAO $dao, ValidatorInterface $validator)
    {
        $this->dao = $dao;
        $this->validator = $validator;
    }

    /*
     * {@inheritdoc}
     */
    public function search(User $user)
    {
        $errors = $this->validator->validate($user);
        if (count($errors) > 0){
            $result['errors'] = array();
            foreach($errors as $error) {
                array_push($result['errors'], $error->getMessage());
            }
            return $result;
        }
        
        return $this->dao->search($user);
    }
}