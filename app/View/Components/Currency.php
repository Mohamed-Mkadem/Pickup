<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\App;
use Illuminate\View\Component;
use NumberFormatter;

class Currency extends Component
{
    public $amount;
    /**
     * Create a new component instance.
     */
    public function __construct($amount)
    {

        $formatter = new NumberFormatter(App::currentLocale(), NumberFormatter::CURRENCY);
        $this->amount = str_replace('TND ', '', $formatter->formatCurrency($amount, 'TND'));
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View | Closure | string
    {
        return view('components.currency');
    }
}
