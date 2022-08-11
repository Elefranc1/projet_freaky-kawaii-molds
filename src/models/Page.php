<?php

class Page
{
    private int $id;
    
    private string $title;

    private string $route;


    /**
     * @param int $id
     * @param string $title
     * @param string $route
     */
    public function __construct(int $id, string $title, string $route)
    {
        $this->id = $id;
        $this->title = $title;
        $this->route = $route;
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
    public function setId(string $id): void
    {
        $this->id = $id;
    }
    

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoutE(string $route): void
    {
        $this->route = $route;
    }
    
}