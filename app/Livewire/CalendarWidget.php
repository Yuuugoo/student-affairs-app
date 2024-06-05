<?php 

namespace App\Livewire;

use App\Filament\StudentOfficer\Resources\RequestActOffResource;
use App\Filament\StudentOfficer\Resources\RequestActResource;
use App\Models\Calendar;
use App\Models\RequestsActIn;
use App\Models\RequestsActOff;
use App\Models\StudAffairsCalendar;
use App\Models\StudAffairsRequestsactins;
use App\Models\StudAffairsRequestsactoffs;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = StudAffairsCalendar::class;

    protected function headerActions(): array
    {
        return [];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        


        $events = [];

        $requestActOffEvents = StudAffairsRequestsactoffs::with('accreditation')
                        ->where('start_date', '>=', $fetchInfo['start'])
                        ->where('end_date', '<=', $fetchInfo['end'])
                        ->where('status', 'Approved')
                        ->get()
                        ->map(function (StudAffairsRequestsactoffs $event) {
                            $accreditation = $event->accreditation;
                            $startTime = Carbon::parse($event->start_date)->toTimeString();
            
                            return [
                                'id' => $event->id,
                                'title' => "{$startTime} - {$accreditation->org_name} - {$event->title}",
                                'url' => RequestActOffResource::getUrl(name: 'view', parameters: ['record' => $event]),
                                'start' => Carbon::parse($event->start_date)->toDateTimeString(),
                                'end' => Carbon::parse($event->end_date)->toDateTimeString(),
                            ];
                        })->all();


            $requestActInEvents = StudAffairsRequestsactins::with('accreditation')
                        ->where('start_date', '>=', $fetchInfo['start'])
                        ->where('end_date', '<=', $fetchInfo['end'])
                        ->where('status', 'Approved')
                        ->get()
                        ->map(function (StudAffairsRequestsactins $event) {
                            $accreditation = $event->accreditation;
                            $startTime = Carbon::parse($event->start_date)->toTimeString();
            
                            return [
                                'id' => $event->id,
                                'title' => "{$event->title}",
                                'url' => RequestActResource::getUrl(name: 'view', parameters: ['record' => $event]),
                                'start' => Carbon::parse($event->start_date)->toDateTimeString(),
                                'end' => Carbon::parse($event->end_date)->toDateTimeString(),
                            ];
                        })->all();

        $events = array_merge($events, $requestActOffEvents, $requestActInEvents);

        return $events;
    }
    public function getEventClickScript(): array
    {
      return [
        'eventClick' => 'showEventDetails', 
      ];
    }

}
