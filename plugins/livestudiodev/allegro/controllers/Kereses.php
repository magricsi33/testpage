<?php namespace LivestudioDev\Allegro\Controllers;

use Backend\Classes\Controller;
use LivestudioDev\Allegro\Models\SearchLog;
use BackendMenu;

class Kereses extends Controller
{
    public $implement = [        'Backend\Behaviors\ListController'    ];
    
    public $listConfig = 'config_list.yaml';

    public $requiredPermissions = [
        'isDeveloperAllegro' 
    ];

    public function __construct()
    {        
        parent::__construct();
        BackendMenu::setContext('LivestudioDev.Allegro', 'main-menu-item', 'side-menu-item5');
        $this->vars["allcount"] = SearchLog::all()->count();
        $this->vars['thisweekcount'] = SearchLog::where('created_at','>=',\Carbon\Carbon::now()->startOfWeek())->count();
        $this->vars['searches_product'] = SearchLog::whereNull('searchword')->count();
        $this->vars['searches_word'] = SearchLog::whereNull('product_id')->count();

        $this->vars['colors'] = [
            '#95b753',
            '#e5a91a',
            '#cc3300'
        ];

        $msp = SearchLog::select('searchword', \DB::raw('count(*) as total'))->whereNull('product_id')->groupBy('searchword')->orderBy('total', 'DESC')->limit(3)->get();
        $msw = SearchLog::select('product_id', \DB::raw('count(*) as total'))->whereNull('searchword')->groupBy('product_id')->orderBy('total', 'DESC')->limit(3)->get();

        $this->vars['most_searched_product'] = $msw;
        $this->vars['most_searched_word'] = $msp;
    }
}
