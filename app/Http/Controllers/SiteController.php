<?php

namespace App\Http\Controllers;

use App\Models\SiteActivity;
use App\Models\SiteSection;
use App\Models\SiteEvent;
use App\Models\SiteImage;
use App\Models\SiteNotice;

class SiteController extends Controller
{
    public function home()
    {
        // dd('entrou no SiteController');
        // Seções ativas ordenadas
        $sections = SiteSection::with('images')
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->keyBy('key');

        // Imagens agrupadas por seção
        $images = SiteImage::orderBy('order')
            ->get()
            ->groupBy('section_key');

        // Eventos ativos e atuais (agenda)

        $events = SiteEvent::where('is_active', true)
            ->whereDate('event_date', '>=', now())
            ->orderBy('event_date')
            ->get();

        $activities = SiteActivity::where('active', true)
            ->orderBy('order')
            ->get();

        $notices = SiteNotice::visible()
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();


        return view('site.home', compact(
            'sections',
            'images',
            'events',
            'activities',
            'notices',
        ));
    }
}
