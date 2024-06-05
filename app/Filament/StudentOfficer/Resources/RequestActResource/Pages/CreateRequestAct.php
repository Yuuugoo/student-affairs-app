<?php

namespace App\Filament\StudentOfficer\Resources\RequestActResource\Pages;

use App\Filament\StudentOfficer\Resources\RequestActResource;
use App\Livewire\BookingCalendarWidget;
use App\Livewire\CalendarWidget;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateRequestAct extends CreateRecord
{
    protected static string $resource = RequestActResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            
        ];
    }

    protected function afterCreate(): void
    {
        $admin = User::where('name', 'Admin')->first();

        if ($admin) {
            $this->sendNotification($admin);
        }
    }
    

    protected function sendNotification($recipient)
    {
        Notification::make()
            ->title('New Accreditation Request')
            ->body("<strong>" . Auth::user()->name . "</strong> submitted a <strong>Request for In-Campus Activity!</strong>")
            ->sendToDatabase($recipient)
            ->icon('heroicon-o-rectangle-stack')
            ->actions([
                Action::make('view')
                    ->icon('heroicon-o-rectangle-stack')
                    ->url('/admin/requests-accreds/index')
                    ->button('View Request')
            ]);

        event(new DatabaseNotificationsSent($recipient));
    }



}
