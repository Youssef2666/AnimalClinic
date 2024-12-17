<?php

namespace App\Filament\Resources\AdminPanelResource\Widgets;

use App\Models\Animal;
use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        if(Auth::user()->isAdmin()){
            return [
                Stat::make('المستخدمين', User::count())
                    ->description('العدد الكلي للمستخدمين')
                    ->chart($this->getMonthlyCounts(User::class))
                    ->chartColor('primary'),
    
                Stat::make('الأطباء', Doctor::count())
                    ->description('العدد الكلي للاطباء')
                    ->chart($this->getMonthlyCounts(Doctor::class))
                    ->chartColor('secondary'),
    
                Stat::make('الطلبات', Order::count())
                    ->description('العدد الكلي للطلبات')
                    ->chart($this->getMonthlyCounts(Order::class))
                    ->chartColor('success'),
            ];
        }
        return [
            Stat::make('عدد الحيوانات', Animal::where('user_id', Auth::user()->id)->count())
                ->description('العدد الكلي للحيوانات الخاصة بك'),
            Stat::make('عدد المواعيد', Appointment::withoutGlobalScope('user_appointments')->where('doctor_id', Auth::user()->id)->count())
                ->description('العدد الكلي للمواعيد الخاصة بك'),
        ];
    }

    private function getMonthlyCounts(string $model): array
    {
        $data = [];
        $year = Carbon::now()->year;

        for ($month = 1; $month <= 12; $month++) {
            $data[] = $model::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();
        }

        return $data;
    }
}
