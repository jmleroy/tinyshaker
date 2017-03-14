<?php
include_once('Singleton.php');
//namespace Tinyshaker;

class Shaker
{
    use Singleton;

    protected $path;
    protected $episode;
    protected $episodeFiles;
    protected $currentEpisodeKey;
    protected $tinyBox;

    public function init($lang)
    {
        $this->path = 'episodes/' . $lang . '/';
        $this->loadCurrentEpisodeKey();
        $this->loadEpisode();
        $this->loadEpisodeFiles();
        $this->loadTinyBox();
    }

    public function getEpisode()
    {
        return $this->episode;
    }

    public function getEpisodeFiles()
    {
        return $this->episodeFiles;
    }

    public function getCurrentEpisodeKey()
    {
        return $this->currentEpisodeKey;
    }

    public function isTinyBox()
    {
        return $this->tinyBox;
    }

    public function getCurrentEpisodeName()
    {
        return $this->episode[$this->currentEpisodeKey];
    }

    public function getCurrentEpisodePath()
    {
        return $this->path . $this->getCurrentEpisodeName() . '/';
    }

    public function getCurrentEpisodeTitle()
    {
        return $this->getCurrentEpisodeName();
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
            if (is_dir($this->path . $d) && $d[0] != '.') {
                $episode[] = $d;
            }
        }
        $this->episode = $episode;
    }

    protected function loadTinyBox()
    {
        $this->tinyBox = !empty($_GET['tb']);
    }

    protected function loadEpisodeFiles()
    {
        $files = [];
        $directory = scandir($this->getCurrentEpisodePath(), SCANDIR_SORT_ASCENDING);
        foreach ($directory as $file) {
            if (!is_dir($this->getCurrentEpisodePath() . $file)) {
                $files[] = $this->getCurrentEpisodePath() . $file;
            }
        }

        $this->episodeFiles = $files;
    }
}