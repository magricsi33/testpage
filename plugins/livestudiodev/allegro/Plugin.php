<?php namespace LivestudioDev\Allegro;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
    }

    public function registerPDFTemplates()
    {
        return [
            'livestudiodev.allegro::pdf.order',
            'livestudiodev.allegro::pdf.question',
        ];
    }

    public function registerPDFLayouts()
    {
        return [
            'livestudiodev.allegro::pdf.layouts.default'
        ];
    }
}
