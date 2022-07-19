<?php namespace LivestudioDev\Lscore;

use App;
use Config;
use Illuminate\Foundation\AliasLoader;
use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
    }

    public function registerSettings()
    {
        return [
            'settings' => [
                'label'       => 'Beállítások',
                'description' => 'A webshop alapértelmezett és egyéb beállításai.',
                'category'    => 'LS-SEO',
                'icon'        => 'icon-cog',
                'class'       => 'LivestudioDev\Lscore\Models\Settings',
                'order'       => 0,
                'keywords'    => 'default options seo',
                'permissions' => ['lscore.canEditSitemapConfig']
            ],
            'sitemap' => [
                'label'       => 'Sitemap',
                'description' => 'Sitemap/ok generálása és áttekintése.',
                'category'    => 'LS-SEO',
                'icon'        => 'icon-globe',
                'url'         => \Backend::url('livestudiodev/lscore/sitemap'),
                'order'       => 0,
                'keywords'    => 'seo',
                'permissions' => ['lscore.canViewSitemapResult']
            ]
        ];
    }

    public function boot()
    {
        $this->bootPackages();
    }

    public function bootPackages()
    {
        // Get the namespace of the current plugin to use in accessing the Config of the plugin
        $pluginNamespace = str_replace('\\', '.', strtolower(__NAMESPACE__));

        // Instantiate the AliasLoader for any aliases that will be loaded
        $aliasLoader = AliasLoader::getInstance();

        // Get the packages to boot
        $packages = Config::get($pluginNamespace . '::packages');

        // Boot each package
        foreach ($packages as $name => $options) {
            // Setup the configuration for the package, pulling from this plugin's config
            if (!empty($options['config']) && !empty($options['config_namespace'])) {
                Config::set($options['config_namespace'], $options['config']);
            }

            // Register any Service Providers for the package
            if (!empty($options['providers'])) {
                foreach ($options['providers'] as $provider) {
                    App::register($provider);
                }
            }

            // Register any Aliases for the package
            if (!empty($options['aliases'])) {
                foreach ($options['aliases'] as $alias => $path) {
                    $aliasLoader->alias($alias, $path);
                }
            }
        }
    }
}
