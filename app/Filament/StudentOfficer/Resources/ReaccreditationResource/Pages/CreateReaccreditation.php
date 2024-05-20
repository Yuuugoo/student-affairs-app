<?php

namespace App\Filament\StudentOfficer\Resources\ReaccreditationResource\Pages;

use App\Filament\StudentOfficer\Resources\ReaccreditationResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateReaccreditation extends CreateRecord
{
    protected static string $resource = ReaccreditationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
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
            ->body("<strong>" . Auth::user()->name . "</strong> submitted a new Re-Accreditation Request!")
            ->sendToDatabase($recipient);

        event(new DatabaseNotificationsSent($recipient));
    }
}
