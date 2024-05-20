<?php

namespace App\Filament\StudentOfficer\Resources\ReaccreditationResource\Pages;

use App\Filament\StudentOfficer\Resources\ReaccreditationResource;
use App\Models\User;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Events\DatabaseNotificationsSent;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;

class EditReaccreditation extends EditRecord
{
    protected static string $resource = ReaccreditationResource::class;

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
            ->body("<strong>" . Auth::user()->name . "</strong> updated their <strong>Re-Accreditation Request!</strong>")
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
