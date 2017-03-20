<?php

//namespace Tinyshaker;

class EpisodeFile
{
    public $path;
    public $name;
    public $baseName;
    public $type;
    public $time;
    protected $flagNew;

    public function __construct($filePath, $fileName)
    {
        $this->path = $filePath;
        $this->name = $fileName;
        $this->type = strrchr($fileName, '.');
        $this->baseName = preg_replace('/\.' . $this->type . '$/', '', $this->name);
        $this->time = filemtime($this->path . $this->name);
        $this->flagNew = (strpos($this->baseName, '_new') !== false);
    }

    public function isFlaggedNew()
    {
        return $this->flagNew;
    }

    public function isType($typeToCompare)
    {
        return $this->type == $typeToCompare;
    }

    public function getPathAndName()
    {
        return $this->path . $this->name;
    }
}
