<?php namespace LivestudioDev\Allegro\Controllers;

use Backend\Classes\Controller;
use BackendMenu;
use LivestudioDev\Allegro\Models\Question;
use Renatio\DynamicPDF\Classes\PDF;

class Kerdesek extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController',        'Backend\Behaviors\FormController'    ];
    
    public $listConfig = 'config_list.yaml';
    public $formConfig = 'config_form.yaml';

    public function __construct()
    {
        parent::__construct();
        BackendMenu::setContext('LivestudioDev.Allegro', 'main-menu-item', 'side-menu-item4');
    }

    public function pdf($id)
    {
        $data["question"] = Question::where('id',$id)->with('product')->first()->toArray();
        return PDF::loadTemplate('livestudiodev.allegro::pdf.question', $data)->download("kerdes_".$data["question"]["id"].'.pdf');
    }
}
