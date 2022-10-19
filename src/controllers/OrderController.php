<?php
/**
 * @author : Elefranc1
 */


class OrderController
{
    // function index() : void that will display the shopping Cart
    public function index(int $userId)
    {
        $orderManager = new OrderManager();
        
        // if the correct user tries to open this page
        if(isset($_SESSION['user']) 
        && $_SESSION['user']['id']==$userId )
        {
            //if an order has been sent
            if( isset($_POST['totalPrice'])
             && isset($_POST['productsId'])
             && !empty($_POST['productsLabel'])
             && !empty($_POST['variantsPrice'])
             && !empty($_POST['variantsLabel'])
             && !empty($_POST['quantitiesSelected'])
            )
            {
                // We create an order and insert it in the DB
 
                $order = new Order($userId, $_POST['totalPrice']);
                $orderId=$orderManager->createOrder($order);
                echo 'test ';
                // Then we create a ProductOrder for each selected article and insert them in the DB
                for($i=0,$max=count($_POST['productsId']);$i<$max;$i++)
                {
                    echo $max;

                    $productOrder = new ProductOrder($orderId,$_POST['productsId'][$i],$_POST['variantsLabel'][$i],$_POST['variantsPrice'][$i],$_POST['quantitiesSelected'][$i]);
                    var_dump($productOrder);
                    $orderManager->createProductOrder($productOrder);
                    echo '<br>jai inséré le produit '.$_POST['productsLabel'][$i];
                }
                
                // we delete the cart in $_SESSION once the operations are complete
                unset($_SESSION['cart']);
            
            }
            
            $userOrders=$orderManager->getAllOrdersByUserId($userId);
            
            //loading the page
            require "./src/templates/ordersHistory.phtml";
        }
        
        
        
        else
        {
            header('location:/ProjetFinal/projet_freaky-kawaii-molds/'); 
        }
        
    }
    
    // function detail() : void that will display the detail of an order
    public function orderDetails(int $orderId)
    {
        $orderManager = new OrderManager();
        $productManager = new ProductManager();
        $userId = $orderManager->getOrderById($orderId)['user_id'];
        // if the correct user tries to open this page
        if(isset($_SESSION['user']) 
        && ($_SESSION['user']['id']==$userId ||  $_SESSION['user']['is_admin'] == 1 )
        )
        {
            $orderDetails=$orderManager->getAllProductOrderByOrderId($orderId);
            //loading the page
            require "./src/templates/orderDetails.phtml";
        }
        else
        {
            header('location:/ProjetFinal/projet_freaky-kawaii-molds/'); 
        }
        
    }
    
}
