<?php
/**
 * @author : Elefranc1
 */
class Variant
{
    protected int $id;
    
    protected Product $product;
    
    protected string $label;

    protected float $price;
    


    /**
     * @param int $productId
     * @param string $label
     * @param float $price
     */
    public function __construct(product $product, string $label, float $price)
    {
        //$this->id = $id;
        $this->product = $product;
        $this->label = $label;
        $this->price = $price;
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
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(int $product): void
    {
        $this->product = $product;
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
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
    
}
?>