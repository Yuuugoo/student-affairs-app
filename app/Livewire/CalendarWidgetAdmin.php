<?php

namespace App\Livewire;

use App\Filament\Resources\RequestsActInResource;
use App\Models\Calendar;
use App\Models\RequestsActIn;
use App\Models\RequestsActOff;
use Carbon\Carbon;
use Filament\Widgets\Widget;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidgetAdmin extends FullCalendarWidget
{
    public Model | string | null $model = Calendar::class;

    public function fetchEvents(array $fetchInfo): array
    {
        
        $events = [];

        $requestActOffEvents = RequestsActOff::where('start_date', '>=', $fetchInfo['start'])
            ->where('end_date', '<=', $fetchInfo['end'])
            ->where('status', 'Approved')
            ->get()
            ->map(function (RequestsActOff $event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => Carbon::parse($event->start_date)->toDateTimeString(),
                    'end' => Carbon::parse($event->end_date)->toDateTimeString(),
                    'org_name' => $event->accreditation->org_name ?? null,
                    'url' => '',
                    'shouldOpenUrlInNewTab' => false,
                    'prepared_by' => $event->prepared_by, 
                ];
            })->all();


            $requestActInEvents = RequestsActIn::with('accreditation')
                        ->where('start_date', '>=', $fetchInfo['start'])
                        ->where('end_date', '<=', $fetchInfo['end'])
                        ->where('status', 'Approved')
                        ->get()
                        ->map(function (RequestsActIn $event) {
                            $accreditation = $event->accreditation;
                            $startTime = Carbon::parse($event->start_date)->toTimeString();
            
                            return [
                                'id' => $event->id,
                                'title' => "{$event->title}",
                                'url' => RequestsActInResource::getUrl(name: 'view', parameters: ['record' => $event]),
                                'start' => Carbon::parse($event->start_date)->toDateTimeString(),
                                'end' => Carbon::parse($event->end_date)->toDateTimeString(),
                            ];
                        })->all();

        $events = array_merge($events, $requestActOffEvents, $requestActInEvents);

        return $events;
    }
}
