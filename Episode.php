<?php
include_once('Element.php');
include_once('EpisodeFile.php');

//namespace Tinyshaker;

class Episode
{
    /**
     * @var EpisodeFile[]
     */
    protected $files;
    /**
     * @var int
     */
    protected $countFiles;
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $path;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var int
     */
    protected $key;

    /**
     * Episode constructor.
     * @param string $path
     * @param string $name
     * @param int $key
     */
    public function __construct($path, $name, $key)
    {
        $this->path = $path;
        $this->name = $name;
        $this->title = $name;
        $this->key = $key;

        $this->loadFiles();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPath()
    {
        return $this->path . $this->name . '/';
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return array|EpisodeFile[]
     */
    public function getFiles()
    {
        return $this->files;
    }

    public function countFiles()
    {
        return $this->countFiles;
    }

    /**
     * @var int
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string[]
     */
    public function getImageList()
    {
        $imageList = [];

        foreach ($this->files as $file) {
            if ($file->isType('txt')) {
                $imageList[] = 'design/pixel.png';
            } else {
                $imageList[] = $file->getPathAndName();
            }
        }

        return $imageList;
    }

    public function setTitle($t)
    {
        $this->title = $t;
    }

    protected function loadFiles()
    {
        $files = [];
        $directory = scandir($this->getPath(), SCANDIR_SORT_ASCENDING);
        foreach ($directory as $file) {
            if (!is_dir($this->getPath() . $file)) {
                $files[] = new EpisodeFile($this->getPath(), $file);
            }
        }

        $this->files = $files;
        $this->countFiles = count($this->files);
    }
}