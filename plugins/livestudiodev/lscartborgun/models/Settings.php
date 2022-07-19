<?php namespace LivestudioDev\Lscartborgun\Models;

use Model;

/**
 * Model
 */
class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    public $settingsCode = 'livestudiodev_lscartborgun_settings';

    public $settingsFields = 'fields.yaml';
}
