<?php namespace LivestudioDev\Allegro\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Partnerek extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LivestudioDev.Allegro', 'main-menu-item', 'side-menu-item');
    }
}
