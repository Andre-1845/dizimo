<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\SitePerson;
use App\Models\SiteSection;

class TeamController extends Controller
{
    public function index()
    {
        // Pessoas ativas, ordenadas
        $people = SitePerson::where('is_active', true)
            ->orderBy('order')
            ->get();

        // Seção (para título/subtítulo da página)
        $section = SiteSection::where('key', 'team')
            ->where('is_active', true)
            ->first();

        return view('site.team.index', compact('people', 'section'));
    }
}
