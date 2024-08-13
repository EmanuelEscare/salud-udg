<?php

namespace App\View\Components;

use Illuminate\View\Component;

class test_inventario_de_ansiedad_de_beck extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.test_inventario_de_ansiedad_de_beck');
    }
}
