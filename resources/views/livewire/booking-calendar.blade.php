<div x-data="{ showModal: @entangle('showModal'), showCalendar: false }" class="calendar-container flex flex-col">
    <!-- Form Section -->
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-lg font-bold mb-4">Book an Event</h2>
        <form wire:submit.prevent="bookEvent">
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Event Title</label>
                <input type="text" id="title" wire:model="eventTitle" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                @error('eventTitle') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="participants_no" class="block text-sm font-medium text-gray-700">Number of Participants</label>
                <input type="number" id="participants_no" wire:model.lazy="participantsNo" wire:change="getAvailableVenues" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                @error('participantsNo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="start_date" class="block text-sm font-medium text-gray-700">Event Start Time</label>
                <select id="start_date" wire:model.lazy="eventStartTime" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @for ($hour = 6; $hour <= 22; $hour++)
                        @php
                            $displayHour = ($hour > 12) ? $hour - 12 : $hour;
                            $amPm = ($hour >= 12) ? 'PM' : 'AM';
                            $timeValue = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                        @endphp
                        <option value="{{ $timeValue }}">{{ $displayHour }}:00 {{ $amPm }}</option>
                    @endfor 
                </select>
                @error('eventStartTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="end_date" class="block text-sm font-medium text-gray-700">Event End Time</label>
                <select id="end_date" wire:model.lazy="eventEndTime" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @for ($hour = 6; $hour <= 22; $hour++)
                        @php
                            $displayHour = ($hour > 12) ? $hour - 12 : $hour;
                            $amPm = ($hour >= 12) ? 'PM' : 'AM';
                            $timeValue = str_pad($hour, 2, '0', STR_PAD_LEFT) . ':00';
                        @endphp
                        <option value="{{ $timeValue }}">{{ $displayHour }}:00 {{ $amPm }}</option>
                    @endfor
                </select>
                @error('eventEndTime') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="venue" class="block text-sm font-medium text-gray-700">Venue</label>
                <select id="venue" wire:model="eventVenue" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    <option>Select a venue</option>
                    @foreach ($this->getAvailableVenues() as $venue)
                        <option value="{{ $venue->value }}">{{ $venue->getLabel() }}</option>
                    @endforeach
                </select>
                @error('eventVenue') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>
            <div class="mb-4">
                <label for="csw" class="block text-sm font-medium text-gray-700">CSW File</label>
                <input type="file" id="csw" wire:model="csw" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                @error('csw') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="flex justify-end">
                <button type="button" class="mr-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded" @click="showCalendar = true">Check Availability</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Book Event</button>
            </div>
        </form>
    </div>

    <div x-show="showCalendar" class="calendar mt-6">
        <div class="month">
            <span class="prev" wire:click="goToPreviousMonth">&lt;</span>
            <span class="month-name">{{ \Carbon\Carbon::create($currentYear, $currentMonth, 1)->format('F Y') }}</span>
            <span class="next" wire:click="goToNextMonth">&gt;</span>
        </div>
        <div class="weekdays">
            @foreach(['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'] as $day)
            <div>{{ $day }}</div>
            @endforeach
        </div>
        <div class="days">
            @foreach ($dates as $dateData)
            <?php
                $date = $dateData['date'];
                $isOverlapping = $dateData['isOverlapping'];
                $availabilityClass = $isOverlapping ? 'bg-red-200' : 'bg-green-200';
                $selectedClass = ($date->toDateString() === $selectedDate) ? 'selected' : '';
            ?>
            <div 
                class="day {{ $date->month != $currentMonth ? 'text-gray-400' : '' }} {{ $availabilityClass }} {{ $selectedClass }}"
                @click="showModal = true; $wire.selectDate('{{ $date->toDateString() }}')">
                {{ $date->day }}
            </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('livewire:load', function () {
            Livewire.on('selectDate', (date) => {
                document.querySelector('.selected-date').textContent = date;
                document.querySelectorAll('.day').forEach(dayElement => {
                    dayElement.classList.remove('selected');
                    if (dayElement.textContent.trim() === date) {
                    dayElement.classList.add('selected');
                    }
                });
            });

            Livewire.on('showCalendar', () => {
            document.querySelector('[x-data]').__x.$data.showCalendar = true;
            });
        });
    </script>

    <style>
        .calendar-container {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }

        .calendar {
            margin-left: 25%;
            width: 50%;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        .calendar .days .day.selected {
            color: gray;
            font-weight: bold;
            border: 3px solid #000;
        }


        .calendar .month {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 1.5em;
        }

        .calendar .prev, .calendar .next {
            cursor: pointer;
            user-select: none;
            font-size: 1.5em;
            padding: 0 10px;
            transition: color 0.3s;
        }
       
        .calendar .weekdays, .calendar .days {
            display: flex;
            flex-wrap: wrap;
        }

        .calendar .weekdays div, .calendar .days .day {
            width: calc(100% / 7);
            text-align: center;
            padding: 15px;
            box-sizing: border-box;
            border-radius: 10px;
            transition: background-color 0.3s;
        }

        .calendar .weekdays div {
            font-weight: bold;
            background-color: #f8f8f8;
        }

        .calendar .days .day {
            border: 1px solid #eee;
            margin: -1px -1px 0 0;
            background-color: #fafafa;
            cursor: pointer;
            user-select: none;
        }


    </style>
</div>
