<?php

namespace App\Filament\StudentOfficer\Resources\AccreditationResource\Pages;

use App\Filament\StudentOfficer\Resources\AccreditationResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Events\DatabaseNotificationsSent as EventsDatabaseNotificationsSent;

class CreateAccreditation extends CreateRecord
{
    protected static string $resource = AccreditationResource::class;

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
            ->body("<strong>" . Auth::user()->name . "</strong> submitted a new Accreditation Request!")
            ->sendToDatabase($recipient);

        event(new EventsDatabaseNotificationsSent($recipient));
    }
}

