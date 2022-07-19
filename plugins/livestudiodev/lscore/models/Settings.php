<?php namespace LivestudioDev\Lscore\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'livestudiodev_lscore_settings';

    public $settingsFields = 'fields.yaml';
}

?>
