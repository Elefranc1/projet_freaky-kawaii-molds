<?php
/**
 * @author : Elefranc1
 */
 
 require "./src/models/Review.php";

class ReviewManager extends DBConnect
{
    public function getReviewById(int $id) : ?Review
    {
        $query = $this->db->prepare('SELECT * FROM reviews WHERE id=:id');
        $parameters = [
        'id' => $id
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        $review = new Review($result['product_id'],$result['author_id'],$result['score'],$result['text']);
        $review->setId($result['id']);
        var_dump($review);
        return $review;
    }
    
    public function getAllReviewsByProductId(int $productId) : ?array
    {
        $query = $this->db->prepare('SELECT * FROM reviews_with_usernames WHERE product_id=:product_id order by id DESC');
        $parameters = [
        'product_id' => $productId
        ];
        $query->execute($parameters);
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    
    public function getReviewByAuthorIdAndProductId(int $authorId, int $productId) : ?array
    {
        $query = $this->db->prepare('SELECT * FROM reviews_with_usernames WHERE author_id=:author_id and product_id=:product_id order by id DESC');
        $parameters = [
        'author_id' => $authorId,
        'product_id' => $productId
        ];
        $query->execute($parameters);
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if(!$result)
        {
        $result=[];
        }
        return $result;
    }

    public function createReview(Review $review) :  void
    {
        // variables initialization
        $productId=$review->getProductId();
        $authorId=$review->getAuthorId();
        $score=$review->getScore();
        $text=$review->getText();
        date_default_timezone_set('CET');
        $submission_date = date('Y-m-d G:i:s');
        
        $query = $this->db->prepare('INSERT INTO reviews (product_id, author_id, score, text, submission_date)
        VALUES (:product_id, :author_id, :score, :text, :submission_date);');
        $parameters = [
        'product_id' => $productId,
        'author_id' => $authorId,
        'score' => $score,
        'text' => $text,
        'submission_date' => $submission_date
        ];
        
        $query->execute($parameters);
    }
    
    // This function updates a review
    public function updateReview(Review $review) : void
    {
        // variables initialization
        $productId=$review->getProductId();
        $authorId=$review->getAuthorId();
        $score=$review->getScore();
        $text=$review->getText();
        date_default_timezone_set('CET');
        $submissionDate = date('Y-m-d G:i:s');
        $id=$review->getId();
        $query = $this->db->prepare('UPDATE reviews SET
        product_id=:product_id, author_id=:author_id, score=:score, text=:text,  submission_date=:submission_date
        WHERE id=:id');
        $parameters = [
        'product_id' => $productId,
        'author_id' => $authorId,
        'score' => $score,
        'text' => $text,
        'submission_date' => $submissionDate,
        'id' =>$id
        ];
        $query->execute($parameters);
        
    }
    
    
    public function deleteReviewById(int $reviewId) :  void
    {
        $query = $this->db->prepare('DELETE FROM reviews WHERE id=:id');
        $parameters = [
        'id' => $reviewId
        ];
        $query->execute($parameters);
        echo 'évaluation effacée !';
    }
    
    

}