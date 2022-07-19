<?php namespace LivestudioDev\LSSubs;

use System\Classes\PluginBase;
use Event;

class Plugin extends PluginBase
{
    public $require = ['RainLab.Blog'];

    public function registerComponents()
    {
        return [
            'LivestudioDev\LSSubs\Components\SubscriberForm' => 'subForm'
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Adatkezelés',
                'description' => 'Adatkezelési feltétel beállítások.',
                'category'    => 'Feliratkozók',
                'icon'        => 'icon-cog',
                'class'       => 'LivestudioDev\LSSubs\Models\Settings',
                'order'       => 500,
                'keywords'    => 'subscribers gdpr'
            ]
        ];
    }

    public function boot()
    {
        Event::listen('backend.page.beforeDisplay', function($controller, $action, $params) {
            $controller->addCss("/plugins/livestudiodev/lssubs/assets/css/custom.css", "1.0.0");
        });
    }
}
