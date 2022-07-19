<?php namespace LivestudioDev\Lscore\Models;

use Model;

/**
 * Model
 */
class Sitemap extends Model
{
    use \October\Rain\Database\Traits\Validation;


    /**
     * @var string The database table used by the model.
     */
    public $table = 'livestudiodev_lscore_sitemaps';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $jsonable = ['tags'];

    public static function getLatestXml()
    {
        $map = self::latest('created_at')->first();
        $content = \Storage::disk('local')->get('ls/sitemaps/'.$map->filename);

        return \Response::make($content)->header('Content-Type', 'text/xml');

    }
}
