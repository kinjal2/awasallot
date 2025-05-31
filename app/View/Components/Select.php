<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     */

    public string $name;
    public array $options;
    public mixed $selected;
    public string $class;
   public ?string $placeholder;
    public $multiple;
    public $id;
    public ?string $style;
    public ?string $onchange;

    public function __construct(
        string $name,
        array $options = [],
        mixed $selected = null,
        string $class = 'form-control',
        ?string $placeholder = null,
         ?string $id = null,
        bool $multiple = false,
        ?string $style = null,
         ?string $onchange = null
    ){
    $this->name = $name;
    $this->options = $options;
    $this->selected = old($name, $selected);
    $this->class = $class;
    $this->placeholder = $placeholder;
    $this->id = $id;
    $this->multiple = $multiple;
    $this->style = $style;
    $this->onchange = $onchange;
}


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.select');
    }
}
