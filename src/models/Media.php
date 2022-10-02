<?php

/**
 * Media class used for media upload
 * @author Mari Doucet
 * @author Elefranc1
*/

class Media
{
    private string $originalName;
    private string $fileName;
    private string $fileType;
    private string $url;
    
    function __construct(string $originalName, string $fileName, string $fileType, string $url)
    {
        $this->originalName = $originalName;
        $this->fileName = $fileName;
        $this->fileType = $fileType;
        $this->url = $url;
    }
    
    public function getOriginalName() : string
    {
        return $this->originalName;
    }
    
    public function getFileName() : string
    {
        return $this->fileName;
    }
    
    public function setFileName(string $fileName) : self
    {
        $this->fileName = $fileName;
        return $this;
    }
    
    public function getFileType() : string
    {
        return $this->fileType;
    }
    
    public function setFileType(string $fileType) : self
    {
        $this->fileType = $fileType;
        return $this;
    }
    
    public function getUrl() : string
    {
        return $this->url;
    }
    
    public function setUrl(string $url) : self
    {
        $this->url = $url;
        return $this;
    }
}