<?php namespace LivestudioDev\Lscore\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use System\Classes\SettingsManager;
// LRX
use LivestudioDev\Lscore\Models\Sitemap as SitemapModel;
use LivestudioDev\Lscore\Models\Settings;
use LivestudioDev\Lscore\Classes\TagRetriever;
// SPATIE
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap as SpatieMap;
use Spatie\Sitemap\Tags\Url;

class Sitemap extends Controller
{
    protected $path;
    protected $filename;
    protected $settings;

    public function __construct()
    {
        parent::__construct();

        $this->addCss("/plugins/livestudiodev/lscore/assets/css/sitemaploader.css","1.0.0");
		$this->addCss("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css", "5.12.1");
        $this->settings = Settings::instance();
        $this->path = "ls/sitemaps/";
        $this->filename = "sitemap.xml";
        BackendMenu::setContext('October.System', 'system', 'settings');
        SettingsManager::setContext('LivestudioDev.Lscore','sitemap');
    }

    public function index()
    {
        $map = SitemapModel::latest('created_at')->first();

        $this->vars["sitemap"] = $map;
    }

    public function onGenerateSitemap()
    {
        $url = $this->settings["crawlUrl"] != null ? $this->settings["crawlUrl"] : \Url::to('/');
        $maxPage = $this->settings['maxPage'] != null ? $this->settings['maxPage'] : 99999;
        $noFiles = $this->settings['ignoreAllFiles'] != null ? $this->settings['ignoreAllFiles'] : false;
        $noImages = $this->settings['ignoreImages'] != null ? $this->settings['ignoreImages'] : true;

        $map = SitemapGenerator::create($url)
        ->hasCrawled(function(Url $url) use($noFiles,$noImages) {
            $dots = explode('.',$url->path());
            if(is_array($dots) && isset($dots[1]) && $dots[1] == "jpeg" && $noImages){
                return;
            }

            if(is_array($dots) && isset($dots[1]) && $noFiles){
                return;
            }

            return $url;

        })
        ->getSitemap();

        $tags = $this->sitemapToArray($map);

        $smap = new SitemapModel();
        $rint = random_int(0,10000);
        $smap->filename = $rint."_".$this->filename;
        $smap->tags = $tags;
        $smap->save();

        $this->sitemapToFile($map,$rint);
    }

    public function sitemapToFile(SpatieMap $sitemap,$rint)
    {
        \Storage::disk('local')->put($this->path.$rint."_".$this->filename, $sitemap->render());

        return $this;
    }

    public function sitemapToArray(SpatieMap $map)
    {
        $map = new TagRetriever($map);
        $tags = [];
        foreach ($map->getTags() as $key => $value) {
            $tag['url'] = $value->url;
            $tag['lastModificationDate'] = $value->lastModificationDate->timestamp;
            $tag['changeFrequency'] = $value->changeFrequency;
            $tag['priority'] = $value->priority;

            array_push($tags,$tag);
        }

        return $tags;
    }
}
