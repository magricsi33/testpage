<?php namespace LivestudioDev\Lscartborgun;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'borgunsettings' => [
                'label'       => 'Borgun beállítások',
                'description' => 'Borgun fizetőportál beállításai.',
                'category'    => 'Webshop',
                'icon'        => 'icon-cog',
                'class'       => 'LivestudioDev\Lscartborgun\Models\Settings',
                'order'       => 0,
                'keywords'    => 'borgun apikey cardpayment card payment'
            ]
        ];
    }
}
