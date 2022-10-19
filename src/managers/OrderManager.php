<?php
/**
 * @author : Elefranc1
 */
 
 require "./src/models/Order.php";
  require "./src/models/ProductOrder.php";

class OrderManager extends DBConnect
{
    public function getAllOrders() : ?array
    {
        $query = $this->db->prepare('SELECT * FROM orders');
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }
    
    public function getOrderById(int $id) : ?array
    {
        $query = $this->db->prepare('SELECT * FROM orders WHERE id=:id');
        $parameters = [
        'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getAllOrdersByUserId(int $userId) : ?array
    {
        $query = $this->db->prepare('SELECT * FROM orders WHERE user_id=:user_id order by order_date DESC');
        $parameters = [
        'user_id' => $userId
        ];
        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

    public function createOrder(Order $order) :  ?int
    {
        // variables initialization
        $userId=$order->getUserId();
        $totalPrice=$order->getTotalPrice();
        date_default_timezone_set('CET');
        $orderDate = date('Y-m-d G:i:s');
        
        $query = $this->db->prepare('INSERT INTO orders (user_id, total_price, order_date)
        VALUES (:user_id, :total_price, :order_date)');
        $parameters = [
        'user_id' => $userId,
        'total_price' => $totalPrice,
        'order_date' => $orderDate
        ];
        
        $query->execute($parameters);
        
        // we retrieve the new id 
        $id = $this->db->lastInsertId();
        return $id;
    }
    
    public function createProductOrder(ProductOrder $productOrder) :  void
    {
        // variables initialization
        $orderId=$productOrder->getOrderId();
        $productId=$productOrder->getProductId();
        $variantLabel=$productOrder->getVariantLabel();
        $quantity=$productOrder->getQuantity();
        $price=$productOrder->getVariantPrice();
        
        $query = $this->db->prepare('INSERT INTO product_order (order_id, product_id, variant_label, quantity, price)
        VALUES (:order_id, :product_id, :variant_label, :quantity, :price)');
        $parameters = [
        'order_id' => $orderId,
        'product_id' => $productId,
        'variant_label' => $variantLabel,
        'quantity' => $quantity,
        'price' => $price
        ];
        $query->execute($parameters);
        return;
    }
    
    public function getAllProductOrderByOrderId(int $orderId) :  ?array
    {
        $query = $this->db->prepare('SELECT * FROM product_order WHERE order_id=:order_id order by id DESC');
        $parameters = [
        'order_id' => $orderId
        ];
        $query->execute($parameters);
        $results = $query->fetchAll(PDO::FETCH_ASSOC);
        return $results;
    }

}