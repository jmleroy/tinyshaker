<?php
include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Singleton.php');
include_once(__DIR__ . DIRECTORY_SEPARATOR . 'Episode.php');
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
        if (file_exists($this->path . 'episodes.json')) {
            $this->loadEpisodesFromJson();
        } else {
            $this->loadEpisodesFromScan();
        }
    }

    protected function loadEpisodesFromJson()
    {
        $json = json_decode(file_get_contents($this->path . 'episodes.json'));
        $this->episodes = [];

        foreach ($json as $k => $episode) {
            $e = new Episode($this->path, $episode->name, $k);
            $e->setTitle($episode->title);
            $this->episodes[] = $e;
        }
    }

    protected function loadEpisodesFromScan()
    {
        $dir = scandir($this->path, SCANDIR_SORT_ASCENDING);
        $this->episodes = [];
        $i = 0;

        foreach ($dir as $d) {
            if (is_dir($this->path . $d) && $d[0] != '.') {
                $e = new Episode($this->path, $d, $i);
                $e->setTitle($d);
                $this->episodes[] = $e;
                $i++;
            }
        }
    }

    protected function loadTinyBox()
    {
        $this->tinyBox = !empty($_GET['tb']);
    }
}