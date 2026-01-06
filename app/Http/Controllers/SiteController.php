<?php

namespace App\Http\Controllers;

use App\Models\SiteSection;
use App\Models\SiteEvent;
use App\Models\SiteImage;

class SiteController extends Controller
{
    public function home()
    {
        // dd('entrou no SiteController');
        // Seções ativas ordenadas
        $sections = SiteSection::where('is_active', true)
            ->orderBy('order')
            ->get()
            ->keyBy('key');

        // Imagens agrupadas por seção
        $images = SiteImage::orderBy('order')
            ->get()
            ->groupBy('section_key');

        // Eventos ativos (agenda)
        $events = SiteEvent::active()
            ->orderBy('event_date')
            ->get();

        return view('site.home', compact(
            'sections',
            'images',
            'events'
        ));
    }
}
