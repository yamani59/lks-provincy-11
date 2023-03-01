<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CardBlog extends Component
{
    public String $title;
    public String $image;
    public String $variant;

    private array $variant_collection = ['default', 'large', 'big'];

    /**
     * Create a new component instance.
     */
    public function __construct(String $title, String $image, String $variant = 'default')
    {
        $this->title = $title;
        $this->image = $image;
        $this->variant = array_search($variant, $this->variant_collection);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.card-blog');
    }
}
