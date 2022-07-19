<?php namespace LivestudioDev\LSSubs\Components;

use LivestudioDev\LSSubs\Models\Subscriber;
use LivestudioDev\LSSubs\Models\Theme;
use LivestudioDev\LSSubs\Models\Settings;
use Cms\Classes\Page;
use RainLab\Blog\Models\Post;

class SubscriberForm extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'livestudiodev.lssubs::lang.component.name',
            'description' => 'livestudiodev.lssubs::lang.component.description'
        ];
    }

    // This array becomes available on the page as {{ component.count }}
    public function count()
    {
        return Subscriber::all()->count();
    }

    public function themes()
    {
        return Theme::all();
    }

    public function defineProperties()
    {
        return [
            'gdprType' => [
                'title'             => 'livestudiodev.lssubs::lang.component.options.gdprType.title',
                'description'       => 'livestudiodev.lssubs::lang.component.options.gdprType.description',
                'type'              => 'dropdown',
                'default'           => 0,
            ],
            'aszfPage' => [
                'title'             => 'livestudiodev.lssubs::lang.component.options.aszfPage.title',
                'description'       => 'livestudiodev.lssubs::lang.component.options.aszfPage.description',
                'type'              => 'dropdown',
                'default'           => 'livestudiodev.lssubs::lang.component.options.aszfPage.default'
            ],
            'themeType' => [
                'title'             => 'livestudiodev.lssubs::lang.component.options.themeType.title',
                'description'       => 'livestudiodev.lssubs::lang.component.options.themeType.description',
                'type'              => 'dropdown',
                'default'           => 0
            ],
            'infoTheme' => [
                'title'             => 'livestudiodev.lssubs::lang.component.options.infoTheme.title',
                'type'              => 'string',
                'default'           => 'livestudiodev.lssubs::lang.component.options.infoTheme.default',
                'group'             => 'livestudiodev.lssubs::lang.component.groups.texts.name'
            ],
            'infoMore' => [
                'title'             => 'livestudiodev.lssubs::lang.component.options.infoMore.title',
                'type'              => 'string',
                'default'           => 'livestudiodev.lssubs::lang.component.options.infoMore.default',
                'group'             => 'livestudiodev.lssubs::lang.component.groups.texts.name'
            ],
            'infoButton' => [
                'title'             => 'livestudiodev.lssubs::lang.component.options.infoButton.title',
                'type'              => 'string',
                'default'           => 'livestudiodev.lssubs::lang.component.options.infoButton.default',
                'group'             => 'livestudiodev.lssubs::lang.component.groups.texts.name'
            ]
        ];
    }

    public function getThemeTypeOptions()
    {
        $options = [];
        $options = Theme::all()->sortBy('name')->lists('name','id');
        $options[0] = "Mind";
        return $options;
    }

    public function getGdprTypeOptions()
    {
        return [
            0 => 'Blog bejegyzés',
            1 => 'Szöveg'
        ];
    }

    public function getAszfPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function getBlogPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    public function onRun()
    {
        $this->properties['gdprInfo'] = Settings::get('checktext', '');
        $this->properties['blogPost'] = Post::find(Settings::get('blogpost', ''));
        $this->properties['aszfContent'] = Settings::get('content', '');
    }

    public function onSubscriberFormSubmit()
    {
        $accept = \Input::get('accept');
        $name = \Input::get('name');
        $email = \Input::get('email');
        $themeid = \Input::get('theme',1);

        $theme = Theme::find($themeid);

        if($accept){
            $sub = new Subscriber();
            $sub->name = $name;
            $sub->email = $email;
            $sub->save();
            if($theme){
                $sub->themes()->save($theme);
            }

            return true;
        }

        return false;
    }

}
