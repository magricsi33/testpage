<?php namespace LivestudioDev\Lscartimpressum;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'impressum' => [
                'label'       => 'Impresszum',
                'description' => 'Az oldal impresszumának beállításai.',
                'category'    => 'Webshop',
                'icon'        => 'icon-briefcase',
                'class'       => 'LivestudioDev\Lscartimpressum\Models\Settings',
                'order'       => 0,
                'keywords'    => 'options impressum aszf adatkezeles cookie'
            ],
        ];
    }
}
