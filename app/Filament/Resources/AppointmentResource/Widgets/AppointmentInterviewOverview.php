<?php

namespace App\Filament\Resources\AppointmentResource\Widgets;

use Carbon\Carbon;
use App\Models\Appointment;
use Filament\Support\Colors\Color;
use App\Enums\AppointmentInterviewStatus;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class AppointmentInterviewOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('مواعيد الأونلاين', Appointment::where('interview', AppointmentInterviewStatus::ONLINE->value)->count())
                ->description('مواعيد الأونلاين خلال الأسبوع')
                ->chart($this->getOnlineAppointmentsCountForLast7Days())
                ->chartColor(Color::Amber),

            Stat::make('مواعيد الأوفلاين', Appointment::where('interview', AppointmentInterviewStatus::OFFLINE->value)->count())
                ->description('مواعيد الأوفلاين خلال الأسبوع')
                ->chart($this->getOfflineAppointmentsCountForLast7Days())
                ->chartColor(Color::Green),
        ];
    }

    protected function getColumns(): int
    {
        return 2;
    }

    private function getOnlineAppointmentsCountForLast7Days(): array
    {
        return $this->getAppointmentCountsByStatus(AppointmentInterviewStatus::ONLINE->value);
    }

    private function getOfflineAppointmentsCountForLast7Days(): array
    {
        return $this->getAppointmentCountsByStatus(AppointmentInterviewStatus::OFFLINE->value);
    }

    private function getAppointmentCountsByStatus($status): array
    {
        $appointmentCounts = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $appointmentCounts[] = Appointment::where('status', $status)->whereDate('created_at', $date)->count();
        }

        return $appointmentCounts;
    }
}
