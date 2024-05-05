<?php

namespace App\Observers;

use Filament\Notifications\Notification;
use Illuminate\Console\View\Components\Task;
use Closure;

class TaskObserver
{
    public function created(Task $task): void
    {
        Notification::make()
            ->title(title:'test notification title' . $task->admin)
            ->sendToDatabase($task->user);
    }
}

class TaskNotification extends Notification
{
    public static string $name = 'task';

    public function content(): string
    {
        return 'test notification title: ' . $task->name;
    }

    public function icon(string|Closure|null $icon): static
    {
        return 'heroicon-s-bell';
    }

    public function color(string|array|Closure|null $color): static
    {
        return 'success';
    }
}