<?php namespace LivestudioDev\Allegro\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

class Varosok extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController'    ];
    
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LivestudioDev.Allegro', 'main-menu-item', 'side-menu-item3');
    }
}
