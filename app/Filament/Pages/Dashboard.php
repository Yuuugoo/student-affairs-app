<?php
 
namespace App\Filament\Pages;
use Illuminate\Contracts\View\View;

 
class Dashboard extends \Filament\Pages\Dashboard
{

    protected static ?string $navigationLabel = 'Home';
 
    public function getHeader(): ?View
    {
        return view('filament.settings.custom-header');
    }
    
    
    
}

