<?php
/**
 * @author : Elefranc1
 */
 
 require "./src/models/ProductPicture.php";

class ProductPictureManager extends DBConnect
{
    
    // This function creates a new entry in the productPicture table and returns the id newly created
    public function createNewProductPictureMain(productPicture $productPicture) : ?int
    {
        $query = $this->db->prepare("INSERT INTO product_picture( product_id, media_id, is_main_picture) 
        VALUES (:product_id,:media_id,1)");
        $parameters = [
        'product_id' => $productPicture->getProductId(),
        'media_id' => $productPicture->getMediaId()
        ];
        $query->execute($parameters);
        
        $newProductPictureId = $this->db->lastInsertId();
        
        return $newProductPictureId;
    }
    
    // This function updates the link between a product and its main picture in the media table
    public function updateProductPictureMain(productPicture $productPicture) : void
    {
        $query = $this->db->prepare("UPDATE product_picture SET media_id=:media_id WHERE product_id=:product_id AND is_main_picture=1");
        $parameters = [
        'product_id' => $productPicture->getProductId(),
        'media_id' => $productPicture->getMediaId()
        ];
        $query->execute($parameters);
        
        return;
    }
    

    // This function creates a new entry in the productPicture table and returns the id newly created
    public function createNewProductPictureSecondary(productPicture $productPicture) : ?int
    {
        $query = $this->db->prepare("INSERT INTO product_picture( product_id, media_id, is_main_picture) 
        VALUES (:product_id,:media_id,0)");
        $parameters = [
        'product_id' => $productPicture->getProductId(),
        'media_id' => $productPicture->getMediaId()
        ];
        $query->execute($parameters);
        
        $newProductPictureId = $this->db->lastInsertId();
        
        return $newProductPictureId;
    }
    
    // This function retrieve the main image of a given product
    public function getMainMedia(int $productId) : ?array
    {
        $query = $this->db->prepare("SELECT media.* from media
        JOIN product_picture ON media.id = product_picture.media_id
        WHERE product_picture.product_id=:product_id and product_picture.is_main_picture=1");
        $parameters = [
        'product_id' => $productId
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        
        return $result;
    }
    
    

}