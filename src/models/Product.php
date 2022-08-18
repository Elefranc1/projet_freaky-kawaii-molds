<?php
/**
 * @author : Elefranc1
 */
abstract class User
{
    protected int $id;
    
    protected string $label;

    protected string $description;

    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(string $label, string $description, int $variantId)
    {
        //$this->id = $id;
        $this->label = $label;
        $this->description = $description;
        $this->variantId = $variantId;
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
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    
}
?>