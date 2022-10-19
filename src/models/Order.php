<?php
/**
 * @author : Elefranc1
 */
class Order
{
    protected int $id;
    
    protected int $userId;

    protected int $totalPrice;
    
    protected DateTime $orderDate;

    /**
     * @param int $id
     * @param int $userId
     * @param int $totalPrice
     * @param DateTime $orderDate
     */
    public function __construct(int $userId, int $totalPrice)
    {
        $this->userId = $userId;
        $this->totalPrice = $totalPrice;
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
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }
    
    /**
     * @return int
     */
    public function getTotalPrice(): int
    {
        return $this->totalPrice;
    }

    /**
     * @param int $totalPrice
     */
    public function setTotalPrice(int $totalPrice): void
    {
        $this->totalPrice = $totalPrice;
    }

    /**
     * @return DateTime
     */
    public function getOrderDate(): DateTime
    {
        return $this->orderDate;
    }

    /**
     * @param DateTime $orderDate
     */
    public function setOrderDate(DateTime $orderDate): void
    {
        $this->orderDate = $orderDate;
    }
    
}
?>