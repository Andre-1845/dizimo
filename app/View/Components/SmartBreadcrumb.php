<?php
// app/View/Components/SmartBreadcrumb.php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;

class SmartBreadcrumb extends Component
{
    public $items = [];
    public $currentDashboard;

    /**
     * Create a new component instance.
     */
    public function __construct(array $items = [])
    {
        $this->items = $items;
        $this->currentDashboard = $this->determineDashboard();
    }

    /**
     * Determina qual dashboard o usuário deve ver baseado no perfil
     */
    private function determineDashboard(): string
    {
        $user = Auth::user();

        if (!$user) {
            return 'member'; // Fallback padrão
        }

        // 1. Se for superadmin ou admin -> dashboard.admin
        if ($user->hasRole(['superadmin', 'admin'])) {
            return 'admin';
        }

        // 2. Se for tesoureiro ou secretário -> dashboard.admin
        if ($user->hasRole(['tesoureiro', 'secretario'])) {
            return 'admin';
        }

        // 3. Se tiver acesso específico à tesouraria -> dashboard.treasury
        if ($user->hasRole('tesoureiro') || $user->can('dizimo.manage')) {
            return 'treasury';
        }

        // 4. Padrão para membros -> dashboard.member
        return 'member';
    }

    /**
     * Get the dashboard route based on user role
     */
    public function getDashboardRoute(): string
    {
        return match ($this->currentDashboard) {
            'admin' => route('dashboard.admin'),
            'treasury' => route('dashboard.treasury'),
            'member' => route('dashboard.member'),
            default => route('dashboard.member'),
        };
    }

    /**
     * Get the dashboard label for display
     */
    public function getDashboardLabel(): string
    {
        return match ($this->currentDashboard) {
            'admin' => 'Administração',
            'treasury' => 'Tesouraria',
            'member' => 'Minha Área',
            default => 'Dashboard',
        };
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.smart-breadcrumb');
    }
}
