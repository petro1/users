<?php
namespace UsersBundle\Criteria;

use Symfony\Component\Validator\Constraints as Assert;
use UsersBundle\Entities\User;
/**
 * Description of Criteria
 *
 * @author ptanco
 */
class UsersCriteria extends User
{
    const PAGE = 1;
    const PERPAGE = 10;

    /**
     * @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     message="The value {{ value }} is not a valid page."
     * )
     */
    private $page;

    /**
     * @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     message="The value {{ value }} is not a valid per page."
     * )
     */
    private $perPage;
   
    public function setPage($page)
    {
        $this->page = $page;
    }

    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }   

    public function getPage()
    {
        return isset($this->page) ? $this->page : self::PAGE;
    }

    public function getPerPage()
    {
        return isset($this->perPage) ? $this->perPage : self::PERPAGE;
    }
}