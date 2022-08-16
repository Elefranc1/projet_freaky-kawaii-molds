<?php

 class User
{
    protected int $id;
    
    protected string $username;

    protected string $password;
    
    protected string $email;

    protected int $mediaId;
    
    protected string $about;
    
    protected DateTime $birthdate;

    protected bool $isAmdin;

    /**
     * @param string $username
     * @param string $password
     * @param string email
     */
    public function __construct(string $username, string $password, string $email=null)
    {
        //$this->id = $id;
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->isAdmin = 0; // We cannot create admins form the website
    }
    
    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }
    

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassWord(string $password): void
    {
        $this->password = $password;
    }
    
    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    /**
     * @return int
     */
    public function getMediaId(): int
    {
        return $this->mediaId;
    }

    /**
     * @param int $mediaId
     */
    public function setMediaId(int $mediaId): void
    {
        $this->mediaId = $mediaId;
    }
    
    /**
     * @return string
     */
    public function getAbout(): string
    {
        return $this->about;
    }

    /**
     * @param string $about
     */
    public function setAbout(string $about): void
    {
        $this->about = $about;
    }
    
    /**
     * @return DateTime
     */
    public function getBirthdate(): string
    {
        return $this->birthdate;
    }

    /**
     * @param DateTime $birthdate
     */
    public function setBirthdate(string $birthdate): void
    {
        $this->birthdate = $birthdate;
    }
    
    /**
     * @return bool
     */
    public function getIsAdmin(): bool
    {
        return $this->isAmdin;
    }

    /**
     * @param bool $password
     */
    public function setIsAdmin(bool $password): void
    {
        $this->isAmdin = $isAmdin;
    }
        
}
?>