<?php

namespace App\View\Components\Dashboard;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class Card extends Component
{
    public string $title;
    public string $value;

    public function __construct(string $title, string $value)
    {
        $this->title = $title;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.dashboard.card');
    }
}