<?php
/**
 * @author : Elefranc1
 */
class ProductOrder
{
    protected int $id;
    
    protected int $orderId;

    protected int $productId;

    protected string $variantLabel;
 
    protected int $variantPrice;   
 
    protected int $quantity;

    /**
     * @param int $id
     * @param int $orderId
     * @param int $productId
     * @param string $variantLabel
     * @param int $variantPrice
     * @param int $quantity
     */
    public function __construct(int $orderId, int $productId, string $variantLabel, int $variantPrice, int $quantity)
    {
        $this->orderId = $orderId;
        $this->productId = $productId;
        $this->variantLabel = $variantLabel;
        $this->variantPrice = $variantPrice;
        $this->quantity = $quantity;
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
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }
    

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;
    }
    
    /**
     * @return string
     */
    public function getVariantLabel(): string
    {
        return $this->variantLabel;
    }

    /**
     * @param string $variantLabel
     */
    public function setVariantLabel(string $variantLabel): void
    {
        $this->variantLabel = $variantLabel;
    }

    /**
     * @return int
     */
    public function getVariantPrice(): int
    {
        return $this->variantPrice;
    }

    /**
     * @param int $variantPrice
     */
    public function setVariantPrice(int $variantPrice): void
    {
        $this->variantPrice = $variantPrice;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
    
}
?>