<?php namespace LivestudioDev\Lscore\Classes;

use Spatie\Sitemap\Sitemap;

class TagRetriever extends Sitemap
{
    public $tags;

    public function __construct(Sitemap $map = null) {
        $this->tags = $map->tags;
    }

    public function getTags()
    {
        return $this->tags;
    }
}

?>
