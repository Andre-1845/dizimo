<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Helpers\StringHelper;
use App\Models\Traits\BelongsToChurch;
use App\Services\TitheService;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory;
    use BelongsToChurch;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'active',
        'church_id',
        'monthly_tithe', // valor previsto
        'inactivated_at'
    ];

    protected $casts = [
        'inactivated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }


    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeExistingUntil($query, $date)
    {
        return $query->where('created_at', '<=', $date);
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = preg_replace('/\D/', '', $value);
    }

    public function getPhoneFormattedAttribute(): ?string
    {
        return format_phone($this->phone);
    }

    protected static function booted()
    {
        static::saving(function ($member) {
            if ($member->name) {
                $member->name = StringHelper::formatName($member->name);
            }

            if (!$member->active && !$member->inactivated_at) {
                $member->inactivated_at = now();
            }

            if ($member->active) {
                $member->inactivated_at = null;
            }
        });
    }

    public function getHasAllDonationsConfirmedAttribute(): bool
    {
        return $this->donations->isNotEmpty()
            && $this->donations->every(fn($d) => $d->is_confirmed);
    }

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function scopeEligibleForTithe($query, $date)
    {
        $date = Carbon::parse($date)->endOfDay();

        return $query
            ->where('created_at', '<=', $date)
            ->where(function ($q) use ($date) {
                $q->whereNull('inactivated_at')
                    ->orWhere('inactivated_at', '>', $date);
            });
    }

    // public function pendingTithes()
    // {
    //     $start = $this->created_at->copy()->startOfMonth();

    //     $end = $this->inactivated_at
    //         ? Carbon::parse($this->inactivated_at)->startOfMonth()
    //         : now()->startOfMonth();

    //     $expectedMonths = [];

    //     $current = $start->copy();

    //     while ($current <= $end) {
    //         $expectedMonths[] = $current->format('Y-m');
    //         $current->addMonth();
    //     }

    //     $dizimoCategory = Category::dizimo();

    //     $paidMonths = $this->donations()
    //         ->where('is_confirmed', true)
    //         ->where('category_id', $dizimoCategory->id)
    //         ->selectRaw("DATE_FORMAT(donation_date,'%Y-%m') as ym")
    //         ->pluck('ym')
    //         ->toArray();

    //     $missing = array_diff($expectedMonths, $paidMonths);

    //     return collect($missing)->map(function ($ym) {

    //         [$year, $month] = explode('-', $ym);

    //         $expected = app(TitheService::class)
    //             ->getTitheForDate($this->id, "$year-$month-01");

    //         return [
    //             'year' => (int) $year,
    //             'month' => (int) $month,
    //             'month_name' => Carbon::create($year, $month, 1)->translatedFormat('F'),
    //             'expected' => $expected,
    //         ];
    //     })->values();
    // }

    // public function pendingTithes()
    // {
    //     $start = $this->created_at->copy()->startOfMonth();

    //     $end = $this->inactivated_at
    //         ? Carbon::parse($this->inactivated_at)->startOfMonth()
    //         : now()->startOfMonth();

    //     $expectedMonths = [];

    //     $current = $start->copy();

    //     while ($current <= $end) {
    //         $expectedMonths[] = $current->format('Y-m');
    //         $current->addMonth();
    //     }

    //     $dizimoCategory = Category::dizimo();

    //     $paidMonths = $this->donations()
    //         ->where('is_confirmed', true)
    //         ->where('category_id', $dizimoCategory->id)
    //         ->selectRaw("DATE_FORMAT(donation_date,'%Y-%m') as ym, SUM(amount) as total")
    //         ->groupBy('ym')
    //         ->pluck('total', 'ym')
    //         ->toArray();

    //     $missing = array_diff($expectedMonths, $paidMonths);

    //     // 🔑 Busca histórico de dízimos apenas uma vez
    //     $tithes = $this->titheValues()
    //         ->orderBy('start_date')
    //         ->get()
    //         ->keyBy(function ($t) {
    //             return Carbon::parse($t->start_date)->format('Y-m');
    //         });

    //     return collect($expectedMonths)->map(function ($ym) use ($paidMonths, $tithes) {

    //         [$year, $month] = explode('-', $ym);

    //         $date = Carbon::create($year, $month, 1);

    //         $expected = $tithes
    //             ->filter(fn($t) => Carbon::parse($t->start_date) <= $date)
    //             ->last()?->value ?? 0;

    //         $paid = $paidMonths[$ym] ?? 0;

    //         if ($paid >= $expected) {
    //             return null; // mês quitado
    //         }

    //         return [
    //             'year' => (int) $year,
    //             'month' => (int) $month,
    //             'month_name' => $date->translatedFormat('F'),
    //             'expected' => $expected,
    //             'paid' => $paid,
    //             'missing' => $expected - $paid
    //         ];
    //     })->filter()->values();
    // }

    public function pendingTithes()
    {
        $start = $this->created_at->copy()->startOfMonth();

        $end = $this->inactivated_at
            ? Carbon::parse($this->inactivated_at)->startOfMonth()
            : now()->startOfMonth();

        $expectedMonths = [];

        $current = $start->copy();

        while ($current <= $end) {
            $expectedMonths[] = $current->format('Y-m');
            $current->addMonth();
        }

        $dizimoCategory = Category::dizimo();

        // total pago por mês
        $paidMonths = $this->donations()
            ->where('is_confirmed', true)
            ->where('category_id', $dizimoCategory->id)
            ->selectRaw("DATE_FORMAT(donation_date,'%Y-%m') as ym, SUM(amount) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym')
            ->toArray();

        // histórico de dízimos
        $tithes = $this->titheValues()
            ->orderBy('start_date')
            ->get();

        return collect($expectedMonths)->map(function ($ym) use ($paidMonths, $tithes) {

            [$year, $month] = explode('-', $ym);

            $date = Carbon::create($year, $month, 1);

            $expected = $tithes
                ->filter(fn($t) => Carbon::parse($t->start_date) <= $date)
                ->last()?->value ?? 0;

            $paid = $paidMonths[$ym] ?? 0;

            $missing = max($expected - $paid, 0);

            if ($missing == 0) {
                return null;
            }

            return [
                'year' => (int) $year,
                'month' => (int) $month,
                'month_name' => $date->translatedFormat('F'),
                'expected' => $expected,
                'paid' => $paid,
                'missing' => $missing
            ];
        })->filter()->values();
    }


    public function pendingTithesCount()
    {
        return $this->pendingTithes()->count();
    }

    public function titheValues()
    {
        return $this->hasMany(MemberTitheValue::class);
    }
}
