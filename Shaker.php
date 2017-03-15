<?php
include_once('Singleton.php');
include_once('Episode.php');
//namespace Tinyshaker;

class Shaker
{
    use Singleton;

    /**
     * @var string
     */
    protected $path;
    /**
     * @var Episode[]
     */
    protected $episodes;
    /**
     * @var int
     */
    protected $currentEpisodeKey;
    /**
     * @var bool
     */
    protected $tinyBox;

    /**
     * @param string $lang
     */
    public function init($lang)
    {
        $this->path = 'episodes/' . $lang . '/';
        $this->loadCurrentEpisodeKey();
        $this->loadEpisodes();
        $this->loadTinyBox();
    }

    /**
     * @return Episode[]
     */
    public function getEpisodes()
    {
        return $this->episodes;
    }

    /**
     * @return Episode|null
     */
    public function getCurrentEpisode()
    {
        if(array_key_exists($this->getCurrentEpisodeKey(), $this->episodes)) {
            return $this->episodes[$this->getCurrentEpisodeKey()];
        }
    }

    /**
     * @return int
     */
    public function getCurrentEpisodeKey()
    {
        return $this->currentEpisodeKey;
    }

    /**
     * @return bool
     */
    public function isTinyBox()
    {
        return $this->tinyBox;
    }

    protected function loadCurrentEpisodeKey()
    {
        $this->currentEpisodeKey = 0;

        if (!empty($_GET['ep']) && !empty($this->episodes[$_GET['ep']])) {
            $this->currentEpisodeKey = $_GET['ep'] - 1;
        }
    }

    protected function loadEpisodes()
    {
        $dir = scandir($this->path, SCANDIR_SORT_ASCENDING);
        $episodes = array();
        $i = 0;

        foreach ($dir as $d) {
            if (is_dir($this->path . $d) && $d[0] != '.') {
                $e = new Episode($this->path, $d, $i);
                $episodes[] = $e;
                $i++;
            }
        }

        $this->episodes = $episodes;
    }

    protected function loadTinyBox()
    {
        $this->tinyBox = !empty($_GET['tb']);
    }
}