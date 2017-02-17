<?php

namespace TrenkwalderBundle\Entity;

use CoreBundle\Entity\AbstractEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="TrenkwalderBundle\Repository\UserRepository")
 */
class User extends AbstractEntity implements UserInterface {

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=200, nullable=true)
     */
    private $firstName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=200,nullable=true)
     */
    private $lastName = '';

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=200)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="email_verified", type="boolean")
     */
    private $emailVerified;

    /**
     * @var string
     *
     * @ORM\Column(name="auth0_id", type="string", length=500)
     */
    private $auth0Id;

    /**
     * @var string
     *
     * @ORM\Column(name="picture", type="string", length=1000, nullable=true)
     */
    private $picture = '';

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=5, nullable=true)
     */
    private $locale = 'en';

    /**
     * ISO_5218 $sex
     * @var integer
     *
     * @ORM\Column(name="sex", type="smallint", options={"default" : 0})
     */
    private $sex = 0;

    /**
     * @var integer
     *
     * @ORM\Column(name="relationship_status", type="smallint", options={"default" : 0})
     */
    private $relationshipStatus = 0;

    public function __construct($auth0Id = '') {
        $this->auth0Id = $auth0Id;
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set locale
     *
     * @param string $locale
     *
     * @return User
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set sex
     *
     * @param integer $sex
     *
     * @return User
     */
    public function setSex($sex)
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Get sex
     *
     * @return integer
     */
    public function getSex()
    {
        return $this->sex;
    }

    /**
     * Set relationshipStatus
     *
     * @param integer $relationshipStatus
     *
     * @return User
     */
    public function setRelationshipStatus($relationshipStatus)
    {
        $this->relationshipStatus = $relationshipStatus;

        return $this;
    }

    /**
     * Get relationshipStatus
     *
     * @return integer
     */
    public function getRelationshipStatus()
    {
        return $this->relationshipStatus;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    /**
     * Set picture
     *
     * @param string $picture
     *
     * @return User
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set emailVerified
     *
     * @param boolean $emailVerified
     *
     * @return User
     */
    public function setEmailVerified($emailVerified)
    {
        $this->emailVerified = $emailVerified;

        return $this;
    }

    /**
     * Get emailVerified
     *
     * @return boolean
     */
    public function getEmailVerified()
    {
        return $this->emailVerified;
    }

    /**
     * Get auth0Id
     *
     * @return string
     */
    public function getAuth0Id()
    {
        return $this->auth0Id;
    }

    /**
     * {@inheritDoc}
     */
    public function getRoles()
    {
        return array('ROLE_USER');
    }

    /**
     * {@inheritDoc}
     */
    public function getPassword()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function getUsername()
    {
        return $this->getFirstName().' '.$this->getLastName();
    }

    /**
     * {@inheritDoc}
     */
    public function eraseCredentials()
    {
        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function equals(UserInterface $user)
    {
        return $user->getUsername() === $this->id;
    }
}

