<?php
include_once('Singleton.php');
//namespace Tinyshaker;

class Shaker
{
    use Singleton;

    protected $path;
    protected $episode;
    protected $currentEpisodeKey;
    protected $tinyBox;

    public function init($lang)
    {
        $this->path = 'episodes/' . $lang . '/';
        $this->loadEpisode();
        $this->loadCurrentEpisodeKey();
        $this->loadTinyBox();
    }

    public function getEpisode()
    {
        return $this->episode;
    }

    public function getCurrentEpisodeKey()
    {
        return $this->currentEpisodeKey;
    }

    public function isTinyBox()
    {
        return $this->tinyBox;
    }

    public function getCurrentEpisodeFileName()
    {
        return $this->episode[$this->currentEpisodeKey];
    }

    public function getCurrentEpisodeName()
    {
        return $this->getCurrentEpisodeFileName();
    }

    public function getCurrentEpisodePath()
    {
        return $this->path . '/' . $this->getCurrentEpisodeFileName() . '/';
    }

    protected function loadCurrentEpisodeKey()
    {
        $this->currentEpisodeKey = 0;

        if (!empty($_GET['ep']) && !empty($this->episode[$_GET['ep']])) {
            $this->currentEpisodeKey = $_GET['ep'] - 1;
        }
    }

    protected function loadEpisode()
    {
        $dir = scandir($this->path, SCANDIR_SORT_ASCENDING);
        $episode = array();
        foreach ($dir as $d) {
            if (!is_dir($d)) {
                $episode[] = $d;
            }
        }
        $this->episode = $episode;
    }

    protected function loadTinyBox()
    {
        $this->tinyBox = !empty($_GET['tb']);
    }
}