<?php
namespace ListBundle\Entities;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Description of User
 *
 * @author ptanco
 */
class User
{
    /**
     * @Assert\Type(
     *     type="integer",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $id;
    /**
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     message="The value {{ value }} is not a valid first name."
     * )
     */
    private $first_name;
    
    /**
     * @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     message="The value {{ value }} is not a valid last name."
     * )
     */
    private $last_name;
    
    /**
     * @Assert\Date(
     *     message="The value {{ value }} is not a valid birthdate."
     * )
     */
    private $birthdate;
    
    /**
     * @Assert\Regex(
     *     pattern     = "/(m|f)/i",
     *     message="The value {{ value }} is not a valid first name."
     * )
     */
    private $sex;

    public function getFirstName()
    {
        return $this->first_name;
    }
    public function getLastName()
    {
        return $this->last_name;
    }
    public function getBirthdate()
    {
        return $this->birthdate;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getSex()
    {
        return $this->sex;
    }
    public function setFirstName($firstName)
    {
        $this->first_name = $firstName;
    }
    public function setLastName($lastName)
    {
        $this->last_name = $lastName;
    }
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }
    public function setSex($sex)
    {
        $this->sex = $sex;
    }
    public function setId($id)
    {
        $this->id = $id;
    }

}