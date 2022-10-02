<?php
/**
 * @author : Elefranc1
 */
class Product
{
    protected int $id;
    
    protected string $label;

    protected string $description;
    
    protected int $categoryId;

    /**
     * @param string $label
     * @param string $title
     * @param int $categoryId
     */
    public function __construct(string $label, string $description, int $categoryId)
    {
        //$this->id = $id;
        $this->label = $label;
        $this->description = $description;
        $this->categoryId = $categoryId;
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
    
    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }
    
}
?>