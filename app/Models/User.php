<?php

namespace App\Models;

use App\Models\Expense;
use App\Models\Revenue;
use App\Models\Ticket;
use App\Models\TicketResponse;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

/**
 * The attributes that are mass assignable.
 *
 * @var array<int, string>
 */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'type',
        'address',
        'd_o_b',
        'status',
        'gender',
        'phone',
        'state_id',
        'city_id',
        'photo',
    ];

/**
 * The attributes that should be hidden for serialization.
 *
 * @var array<int, string>
 */
    protected $hidden = [
        'password',
        'remember_token',
    ];

/**
 * The attributes that should be cast.
 *
 * @var array<string, string>
 */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function client()
    {
        return $this->hasOne(Client::class);
    }
    public function seller()
    {
        return $this->hasOne(Seller::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function vouchers()
    {
        return $this->morphMany(Voucher::class, 'user');
    }
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
    public function getStateCityAttribute()
    {
        return $this->city->state->name . ' - ' . $this->city->name;
    }
    public function isAdmin()
    {
        return $this->type == 'Admin';
    }
    public function isSeller()
    {
        return $this->type == 'Seller';
    }
    public function isClient()
    {
        return $this->type == 'Client';
    }

// Tickets
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function ticketsCount()
    {
        return $this->tickets()->count();
    }
    public function responses()
    {
        return $this->hasMany(TicketResponse::class);
    }
// Revenues
    public function revenues()
    {
        return $this->hasMany(Revenue::class);
    }
    public function hasRevenues()
    {
        return $this->revenues()->exists();
    }
// Expenses
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function hasExpenses()
    {
        return $this->expenses()->exists();
    }

    public function getExpenseStatistics()
    {

        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();
        $yesterdayStart = Carbon::yesterday()->startOfDay();
        $yesterdayEnd = Carbon::yesterday()->endOfDay();
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();
        $previousWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $previousWeekEnd = Carbon::now()->subWeek()->endOfWeek();
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $currentYearStart = Carbon::now()->startOfYear();
        $currentYearEnd = Carbon::now()->endOfYear();
        $previousYearStart = Carbon::now()->subYear()->startOfYear();
        $previousYearEnd = Carbon::now()->subYear()->endOfYear();

        // Get the counts for each status in all time
        $currentPeriod = [
            'total' => $this->expenses()->sum('amount'),
            'day' => $this->expenses()->whereBetween('created_at', [$todayStart, $todayEnd])
                ->sum('amount'),
            'week' => $this->expenses()->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])
                ->sum('amount'),
            'month' => $this->expenses()->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                ->sum('amount'),
            'year' => $this->expenses()->whereBetween('created_at', [$currentYearStart, $currentYearEnd])
                ->sum('amount'),

        ];
        $previousPeriod = [
            'day' => $this->expenses()->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
                ->sum('amount'),
            'week' => $this->expenses()->whereBetween('created_at', [$previousWeekStart, $previousWeekEnd])
                ->sum('amount'),
            'month' => $this->expenses()->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                ->sum('amount'),
            'year' => $this->expenses()->whereBetween('created_at', [$previousYearStart, $previousYearEnd])
                ->sum('amount'),
        ];

        // Calculate the difference for each status
        $difference = [
            'day' => $currentPeriod['day'] - $previousPeriod['day'],
            'week' => $currentPeriod['week'] - $previousPeriod['week'],
            'month' => $currentPeriod['month'] - $previousPeriod['month'],
            'year' => $currentPeriod['year'] - $previousPeriod['year'],
        ];

        return compact('currentPeriod', 'difference', 'previousPeriod');
    }
    public function getRevenueStatistics()
    {

        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();
        $yesterdayStart = Carbon::yesterday()->startOfDay();
        $yesterdayEnd = Carbon::yesterday()->endOfDay();
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();
        $previousWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $previousWeekEnd = Carbon::now()->subWeek()->endOfWeek();
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $currentYearStart = Carbon::now()->startOfYear();
        $currentYearEnd = Carbon::now()->endOfYear();
        $previousYearStart = Carbon::now()->subYear()->startOfYear();
        $previousYearEnd = Carbon::now()->subYear()->endOfYear();

        // Get the counts for each status in all time
        $currentPeriod = [
            'total' => $this->revenues()->sum('amount'),
            'day' => $this->revenues()->whereBetween('created_at', [$todayStart, $todayEnd])
                ->sum('amount'),
            'week' => $this->revenues()->whereBetween('created_at', [$currentWeekStart, $currentWeekEnd])
                ->sum('amount'),
            'month' => $this->revenues()->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd])
                ->sum('amount'),
            'year' => $this->revenues()->whereBetween('created_at', [$currentYearStart, $currentYearEnd])
                ->sum('amount'),

        ];
        $previousPeriod = [
            'day' => $this->revenues()->whereBetween('created_at', [$yesterdayStart, $yesterdayEnd])
                ->sum('amount'),
            'week' => $this->revenues()->whereBetween('created_at', [$previousWeekStart, $previousWeekEnd])
                ->sum('amount'),
            'month' => $this->revenues()->whereBetween('created_at', [$previousMonthStart, $previousMonthEnd])
                ->sum('amount'),
            'year' => $this->revenues()->whereBetween('created_at', [$previousYearStart, $previousYearEnd])
                ->sum('amount'),
        ];

        // Calculate the difference for each status
        $difference = [
            'day' => $currentPeriod['day'] - $previousPeriod['day'],
            'week' => $currentPeriod['week'] - $previousPeriod['week'],
            'month' => $currentPeriod['month'] - $previousPeriod['month'],
            'year' => $currentPeriod['year'] - $previousPeriod['year'],
        ];

        return compact('currentPeriod', 'difference', 'previousPeriod');
    }
    public function getEarningStatistics()
    {

        $todayStart = Carbon::today()->startOfDay();
        $todayEnd = Carbon::today()->endOfDay();
        $yesterdayStart = Carbon::yesterday()->startOfDay();
        $yesterdayEnd = Carbon::yesterday()->endOfDay();
        $currentWeekStart = Carbon::now()->startOfWeek();
        $currentWeekEnd = Carbon::now()->endOfWeek();
        $previousWeekStart = Carbon::now()->subWeek()->startOfWeek();
        $previousWeekEnd = Carbon::now()->subWeek()->endOfWeek();
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();
        $previousMonthStart = Carbon::now()->subMonth()->startOfMonth();
        $previousMonthEnd = Carbon::now()->subMonth()->endOfMonth();
        $currentYearStart = Carbon::now()->startOfYear();
        $currentYearEnd = Carbon::now()->endOfYear();
        $previousYearStart = Carbon::now()->subYear()->startOfYear();
        $previousYearEnd = Carbon::now()->subYear()->endOfYear();

        // Get the counts for each status in all time
        $currentPeriod = [
            'total' => $this->getRevenueStatistics()['currentPeriod']['total'] - $this->getExpenseStatistics()['currentPeriod']['total'],
            'day' => $this->getRevenueStatistics()['currentPeriod']['day'] - $this->getExpenseStatistics()['currentPeriod']['day'],
            'week' => $this->getRevenueStatistics()['currentPeriod']['week'] - $this->getExpenseStatistics()['currentPeriod']['week'],
            'month' => $this->getRevenueStatistics()['currentPeriod']['month'] - $this->getExpenseStatistics()['currentPeriod']['month'],
            'year' => $this->getRevenueStatistics()['currentPeriod']['year'] - $this->getExpenseStatistics()['currentPeriod']['year'],

        ];
        $previousPeriod = [
            'day' => $this->getRevenueStatistics()['previousPeriod']['day'] - $this->getExpenseStatistics()['previousPeriod']['day'],
            'week' => $this->getRevenueStatistics()['previousPeriod']['week'] - $this->getExpenseStatistics()['previousPeriod']['week'],
            'month' => $this->getRevenueStatistics()['previousPeriod']['month'] - $this->getExpenseStatistics()['previousPeriod']['month'],
            'year' => $this->getRevenueStatistics()['previousPeriod']['year'] - $this->getExpenseStatistics()['previousPeriod']['year'],
        ];

        // Calculate the difference for each status
        $difference = [
            'day' => $currentPeriod['day'] - $previousPeriod['day'],
            'week' => $currentPeriod['week'] - $previousPeriod['week'],
            'month' => $currentPeriod['month'] - $previousPeriod['month'],
            'year' => $currentPeriod['year'] - $previousPeriod['year'],
        ];

        return compact('currentPeriod', 'difference', 'previousPeriod');
    }
}
