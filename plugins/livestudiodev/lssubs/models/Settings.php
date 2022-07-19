<?php namespace LivestudioDev\LSSubs\Models;

use Model;
use RainLab\Blog\Models\Post as BlogPost;

/**
 * Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'livestudiodev_lssubs_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';

    public function getBlogpostOptions() {
        return BlogPost::all()->pluck('title','id');
    }
}
