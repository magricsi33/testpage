<?php namespace LivestudioDev\SlickSlider;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{

    public function registerComponents()
    {
        return [
            'LivestudioDev\SlickSlider\Components\Slider' => 'slider'
        ];
    }
    public function registerPageSnippets()
    {
        return [
            'LivestudioDev\SlickSlider\Components\Slider' => 'slider'
        ];        
    }   

    public function registerMarkupTags()
    {
        return [
            'functions' => [
                // Using an inline closure
                'numberToBoolean' => [$this, 'numberToBoolean']
            ]
        ];
    }

    public function numberToBoolean($number)
    {
        
        if ($number == 1) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function registerPermissions()
    {
        return [
            'livestudiodev.slickslider.manage_slide_shows' => [
                'label' => 'livestudiodev.slickslider::lang.slickslider.manage_slide_shows',
                'tab' => 'livestudiodev.slickslider::lang.plugin.name'
            ],
            'livestudiodev.slickslider.manage_slides' => [
                'label' => 'livestudiodev.slickslider::lang.slickslider.manage_slides',
                'tab' => 'livestudiodev.slickslider::lang.plugin.name'
            ],
            'livestudiodev.slickslider.create_slide_shows' => [
                'tab' => 'livestudiodev.slickslider::lang.plugin.name',
                'label' => 'livestudiodev.slickslider::lang.slickslider.create_slide_shows_label'
            ]
        ];
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Slide Show Settings',
                'description' => 'Manage default slide show settings. These settings will only be used when a user that doesn\'t have access to the settings page creates a slide show',
                'category'    => 'Slide Shows',
                'icon'        => 'icon-cog',
                'class'       => 'livestudiodev\slickslider\Models\Settings',
                'order'       => 500,
                'keywords'    => 'slide show settings',
                'permissions' => ['livestudiodev.slickslider.manage_slide_shows']
            ]
        ];
    }
}
