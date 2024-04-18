<?php 

namespace App\Livewire;

use App\Filament\StudentOfficer\Resources\RequestActOffResource;
use App\Filament\StudentOfficer\Resources\RequestActResource;
use App\Models\Calendar;
use App\Models\RequestsActIn;
use App\Models\RequestsActOff;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Saade\FilamentFullCalendar\Widgets\FullCalendarWidget;

class CalendarWidget extends FullCalendarWidget
{
    public Model | string | null $model = Calendar::class;

    protected function headerActions(): array
    {
        return [];
    }

    public function fetchEvents(array $fetchInfo): array
    {
        


        $events = [];

        $requestActOffEvents = RequestsActOff::with('accreditation')
                        ->where('start_date', '>=', $fetchInfo['start'])
                        ->where('end_date', '<=', $fetchInfo['end'])
                        ->where('status', 'Approved')
                        ->get()
                        ->map(function (RequestsActOff $event) {
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
                                'title' => "{$startTime} - {$accreditation->org_name} - {$event->title}",
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
