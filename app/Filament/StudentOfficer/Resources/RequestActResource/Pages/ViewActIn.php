<?php

namespace App\Filament\StudentOfficer\Resources\RequestActResource\Pages;

use App\Filament\StudentOfficer\Resources\RequestActResource;
use App\Models\RequestsActIn;
use Carbon\Carbon;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Fieldset;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Pages\Page;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Facades\Storage;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Split;

class ViewActIn extends ViewRecord
{
    
    protected static string $resource = RequestActResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
        ->schema([

                Section::make([
                Fieldset::make('Activity Details')
                ->schema([
                    TextEntry::make('title')
                    ->label('Event Name:'),
                    TextEntry::make('venues')
                        ->label('Event Venue'),
                    TextEntry::make('start_date')
                        ->label('Start Date:'),
                    TextEntry::make('end_date')
                        ->label('End Date:'),

                    
                    ]),
                ]),

                Section::make([
                Fieldset::make('Extra details')
                    ->schema([
                    TextEntry::make('org_name_no')
                        ->label('Organization Name:')
                        ->getStateUsing(function (RequestsActIn $record) {
                            $org = $record-> accreditation;

                            return [
                                'org_name_no' => $org -> org_name ?? null,
                            ];
                        }),
                    TextEntry::make('prepared_by')
                        ->label('Submitted By:')
                        ->getStateUsing(function (RequestsActIn $record) {
                            $user = $record->user;
                            return [
                                'prepared_by' => $user->name ?? null,
                            ];
                        }),
                    TextEntry::make('created_at')
                        ->date()
                        ->label('Date Submitted:'),
                ]),
            ])
                





            ]);




            
            
            
        }
}
