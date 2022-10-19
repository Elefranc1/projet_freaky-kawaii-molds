<?php
/**
 * @author : Elefranc1
 */
class Review
{
    protected int $id;
    
    protected int $productId;

    protected int $authorId;
    
    protected int $score;
    
    protected string $text;
    
    protected DateTime $submissionDate;

    /**
     * @param string $label
     */
    public function __construct(int $productId, int $authorId, int $score, string $text)
    {
        $this->productId = $productId;
        $this->authorId = $authorId;
        $this->score = $score;       
        $this->text = $text;
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
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }
    
    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param int $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }
    
    

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }
    
}
?>