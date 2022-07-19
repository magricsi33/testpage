<?php namespace LivestudioDev\Lscartimpressum\Models;

use Model;

class Settings extends Model
{
    public $implement = ['System.Behaviors.SettingsModel'];

    // A unique code
    public $settingsCode = 'lscartimpressum_settings';

    // Reference to field configuration
    public $settingsFields = 'fields.yaml';
}