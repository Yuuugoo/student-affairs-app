<?php

namespace App\Filament\StudentOfficer\Resources\AccreditationResource\Pages;

use App\Filament\StudentOfficer\Resources\AccreditationResource;
use App\Models\User;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
use Filament\Notifications\Events\DatabaseNotificationsSent as EventsDatabaseNotificationsSent;

class EditAccreditation extends EditRecord
{
    protected static string $resource = AccreditationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    

    protected function afterSave(): void
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
            ->body("<strong>" . Auth::user()->name . "</strong> updated their <strong>Accreditation Request!</strong>")
            ->sendToDatabase($recipient)
            ->icon('heroicon-o-rectangle-stack')
            ->actions([
                Action::make('view')
                    ->icon('heroicon-o-rectangle-stack')
                    ->url('/admin/requests-accreds/index')
                    ->button('View Request')
            ]);

        event(new EventsDatabaseNotificationsSent($recipient));
    }
}
