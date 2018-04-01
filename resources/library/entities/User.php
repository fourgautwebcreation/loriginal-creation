<?php

namespace entities;

use Doctrine\ORM\Mapping as ORM;

/** 
 * @Entity(repositoryClass="repositories\UserRepository") 
 * @Table(name="users")
 * 
*/
class User
{
    /** 
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /** @Column(type="text", length=255, name="pseudo") */
    private $pseudo;

    /** @Column(type="text",length=255, name="pass") */
    private $pass;

    /** @Column(type="text",length=255, name="mail", nullable=true) */
    private $mail = null;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pseudo.
     *
     * @param string $pseudo
     *
     * @return User
     */
    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    /**
     * Get pseudo.
     *
     * @return string
     */
    public function getPseudo()
    {
        return $this->pseudo;
    }

    /**
     * Set pass.
     *
     * @param string $pass
     *
     * @return User
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass.
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set mail.
     *
     * @param string|null $mail
     *
     * @return User
     */
    public function setMail($mail = null)
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * Get mail.
     *
     * @return string|null
     */
    public function getMail()
    {
        return $this->mail;
    }
}
