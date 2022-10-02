<?php
/**
 * @author : Elefranc1
 */

class MediaManager extends DBConnect
{
    
    public function getUrlByMediaId(int $mediaId) : ?string
    {
        $query = $this->db->prepare('SELECT * FROM media WHERE id=:id');
        $parameters = [
        'id' => $mediaId
        ];
        $query->execute($parameters);
        $resultArray = $query->fetch(PDO::FETCH_ASSOC);
        $result=$resultArray['url'];
        return $result;
    }
    
    // This function creates a new entry in the media table and returns the id newly created
    public function createNewMedia(media $media) : ?int
    {
        $query = $this->db->prepare("INSERT INTO media( originalName, fileName, fileType, url) 
        VALUES (:originalName,:fileName,:fileType,:url)");
        $parameters = [
        'originalName' => $media->getOriginalName(),
        'fileName' => $media->getFileName(),
        'fileType' => $media->getFileType(),
        'url' => $media->getUrl()
        ];
        $query->execute($parameters);
        
        $newMediaId = $this->db->lastInsertId();
        
        return $newMediaId;
    }
    

}