<?php

namespace App\Filament\Widgets;

use Filament\Infolists\Infolist;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Widgets\Widget;
use Filament\Widgets\WidgetServiceProvider;
use App\Livewire\Components\Feature;
use App\Models\Announcement;

class AnnouncementsOverview extends Widget
{
    protected static string $view = 'filament.widgets.announcements-overview';
    protected int | string | array $columnSpan = [
        'md' => 2,
        'xl' => 3,
    ];
    


    
    
    
}
