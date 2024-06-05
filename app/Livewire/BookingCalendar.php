<?php

namespace App\Livewire;

use App\Enums\Venues;
use App\Models\Accreditation;
use App\Models\RequestsActIn;
use App\Models\RequestsActOff;
use App\Models\StudAffairsAccreditations;
use App\Models\StudAffairsRequestsactins;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class BookingCalendar extends Component
{
    use WithFileUploads;

    public $currentMonth;
    public $currentYear;
    public $selectedDate;
    public $eventTitle;
    public $eventStartTime;
    public $eventEndTime;
    public $participantsNo;
    public $eventVenue;
    public $bookings = [];
    public $bookedVenues = [];
    public $showModal = false;
    public $availableVenues = [];
    public $csw;

    public function mount()
    {
        $this->currentMonth = Carbon::now()->month;
        $this->currentYear = Carbon::now()->year;
        $this->eventStartTime = '06:00';
        $this->eventEndTime = '06:00';
        $this->availableVenues = $this->getAvailableVenues();
        $this->fetchBookings();
    }

    public function fetchBookings()
    {
        $bookingsIn = StudAffairsRequestsactins::all();

        $this->bookings = $bookingsIn->map(function ($booking) {
            return [
                'title' => $booking->event_title,
                'start' => Carbon::parse($booking->start_date),
                'end' => Carbon::parse($booking->end_date),
                'participants_no' => $booking->participants_no,
                'max_capacity' => $booking->max_capacity ?? Venues::from($booking->venues)->getMaxCapacity(),
                'venue' => $booking->venues,
                'start_time' => Carbon::parse($booking->start_date)->format('H:i'),
                'end_time' => Carbon::parse($booking->end_date)->format('H:i'),
                'status' => $booking->status,
            ];
        });
    }

    public function getAvailableVenues()
    {
        if (empty($this->participantsNo)) {
            return [];
        }

        $this->validate([
            'participantsNo' => 'integer|min:1',
        ]);

        $availableVenues = array_filter(Venues::cases(), function ($venue) {
            return $venue->getMaxCapacity() >= $this->participantsNo;
        });

        return $availableVenues;
    }

    public function goToPreviousMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->subMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function goToNextMonth()
    {
        $date = Carbon::create($this->currentYear, $this->currentMonth, 1)->addMonth();
        $this->currentMonth = $date->month;
        $this->currentYear = $date->year;
    }

    public function selectDate($date)
    {
        $this->selectedDate = $date;
        $this->fetchBookedVenues($date);
        $this->showModal = true;
    }

    public function fetchBookedVenues($date)
    {
        $this->bookedVenues = StudAffairsRequestsactins::whereDate('start_date', $date)
            ->orWhereDate('end_date', $date)
            ->get();
    }

    public function bookEvent()
    {
        $this->validate([
            'eventTitle' => 'required|string|max:255',
            'eventStartTime' => 'required|date_format:H:i',
            'eventEndTime' => 'required|date_format:H:i|after:eventStartTime',
            'participantsNo' => 'required|integer|min:1',
            'eventVenue' => 'required|string|max:255',
            'csw' => 'required|file|mimes:pdf,doc,docx|max:10240',
        ]);

        $accreditation = StudAffairsAccreditations::where('prepared_by', Auth::id())->first();

        $overlappingEvents = StudAffairsRequestsactins::where('venues', $this->eventVenue)
            ->whereDate('start_date', $this->selectedDate)
            ->where(function ($query) {
                $query->whereBetween('start_date', [
                    Carbon::createFromFormat('Y-m-d H:i', $this->selectedDate . ' ' . $this->eventStartTime),
                    Carbon::createFromFormat('Y-m-d H:i', $this->selectedDate . ' ' . $this->eventEndTime),
                ])->orWhereBetween('end_date', [
                    Carbon::createFromFormat('Y-m-d H:i', $this->selectedDate . ' ' . $this->eventStartTime),
                    Carbon::createFromFormat('Y-m-d H:i', $this->selectedDate . ' ' . $this->eventEndTime),
                ])->orWhere(function ($query) {
                    $query->where('start_date', '<', Carbon::createFromFormat('Y-m-d H:i', $this->selectedDate . ' ' . $this->eventStartTime))
                        ->where('end_date', '>', Carbon::createFromFormat('Y-m-d H:i', $this->selectedDate . ' ' . $this->eventEndTime));
                });
            })
            ->exists();

        if ($overlappingEvents) {
            $this->addError('eventVenue', 'The selected venue has been booked at the chosen time.');
            return;
        }

        $cswPath = $this->csw->store('public/csw');

        StudAffairsRequestsactins::create([
            'csw' => $cswPath,
            'status' => 'pending',
            'org_name' => $accreditation ? $accreditation->org_name : 'N/A',
            'req_type' => 'event',
            'start_date' => Carbon::createFromFormat('Y-m-d H:i', $this->selectedDate . ' ' . $this->eventStartTime),
            'end_date' => Carbon::createFromFormat('Y-m-d H:i', $this->selectedDate . ' ' . $this->eventEndTime),
            'title' => $this->eventTitle,
            'participants_no' => $this->participantsNo,
            'venues' => $this->eventVenue,
            'prepared_by' => Auth::id(),
            'max_capacity' => 0,
        ]);

        $this->resetForm();
        $this->showModal = false;
    }

    private function resetForm()
    {
        $this->eventTitle = '';
        $this->eventStartTime = '';
        $this->eventEndTime = '';
        $this->participantsNo = '';
        $this->eventVenue = '';
        $this->csw = null;
    }

    public function getDatesWithAvailability()
    {
        $daysInMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->daysInMonth;
        $startOfMonth = Carbon::create($this->currentYear, $this->currentMonth, 1)->startOfWeek();
        $endOfMonth = Carbon::create($this->currentYear, $this->currentMonth, $daysInMonth)->endOfWeek();

        $dates = [];
        $currentDate = $startOfMonth->copy();

        while ($currentDate <= $endOfMonth) {
            $isOverlapping = $this->isOverlapping($currentDate->copy());

            $dates[] = [
                'date' => $currentDate->copy(),
                'isOverlapping' => $isOverlapping
            ];
            $currentDate->addDay();
        }

        return $dates;
    }

    private function isOverlapping($date)
    {
        foreach ($this->bookings as $booking) {
            if ($date->isSameDay($booking['start']) || $date->isSameDay($booking['end'])) {
                $bookingVenue = $booking['venue'];
                $eventVenue = $this->eventVenue;
                if ($bookingVenue == $eventVenue) {
                    return true;
                }
            }
        }
        return false;
    }

    public function render()
    {
        $dates = $this->getDatesWithAvailability();

        return view('livewire.booking-calendar', [
            'dates' => $dates,
            'currentMonth' => $this->currentMonth,
            'currentYear' => $this->currentYear,
            'bookings' => $this->bookings,
            'bookedVenues' => $this->bookedVenues,
        ]);
    }
}
?>
