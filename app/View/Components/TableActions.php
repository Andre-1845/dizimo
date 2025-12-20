<?php

namespace App\View\Components;

use Illuminate\View\Component;

class TableActions extends Component
{
    public ?string $show;
    public ?string $edit;
    public ?string $delete;
    public ?string $confirm;

    public ?string $canShow;
    public ?string $canEdit;
    public ?string $canDelete;

    public function __construct(string $show = null, string $edit = null, string $delete = null, string $confirm = 'Deseja realmente excluir este registro?', string $canShow = null, string $canEdit = null, string $canDelete = null)
    {
        $this->show = $show;
        $this->edit = $edit;
        $this->delete = $delete;
        $this->confirm = $confirm;

        $this->canShow = $canShow;
        $this->canEdit = $canEdit;
        $this->canDelete = $canDelete;
    }

    public function render()
    {
        return view('components.table-actions');
    }
}
