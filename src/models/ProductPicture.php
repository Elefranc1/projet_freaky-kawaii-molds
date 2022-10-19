<?php
/**
 * @author : Elefranc1
 */
class ProductPicture
{
    protected int $id;
    
    protected int $productId;

    protected int $mediaId;
    
    protected bool $isMainPicture;

    /**
     * @param int $id
     * @param int $productId
     * @param int $mediaId
     * @param bool $isMainPicture
     */
    public function __construct(int $productId, int $mediaId, bool $isMainPicture)
    {
        //$this->id = $id;
        $this->productId = $productId;
        $this->mediaId = $mediaId;
        $this->isMainPicture = $isMainPicture;
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
    public function getMediaId(): int
    {
        return $this->mediaId;
    }

    /**
     * @param int $mediaId
     */
    public function setMediaId(int $mediaId): void
    {
        $this->mediaId = $mediaId;
    }

    /**
     * @return bool
     */
    public function getIsMainPicture(): bool
    {
        return $this->isMainPicture;
    }

    /**
     * @param int $isMainPicture
     */
    public function setIsMainPicture(int $isMainPicture): void
    {
        $this->isMainPicture = $isMainPicture;
    }
    
    
}
?>