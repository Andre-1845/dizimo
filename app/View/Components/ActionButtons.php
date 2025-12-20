<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ActionButtons extends Component
{
    /**
     * Create a new component instance.
     */
    //
    public function __construct(
        public ?string $list = null,
        public ?string $edit = null,
        public ?string $password = null,
        public ?string $delete = null,

        // permissões (opcionais)
        public ?string $canList = null,
        public ?string $canEdit = null,
        public ?string $canPassword = null,
        public ?string $canDelete = null,

        // titulo customizavel de LIST
        public string $listLabel = 'Listar',

        public ?string $deleteConfirm = 'Tem certeza que deseja excluir este registro?'
    ) {}


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.action-buttons');
    }
}