<x-filament-widgets::widget>
    <x-filament::section>
        <div class="announcement-banner">

            <x-filament::button wire:click="AnnouncementResource">
                LEARN MORE
            </x-filament::button>

            <x-slot name="heading"> 
                Title
            </x-slot>

            <x-slot name="description">
                Description
            </x-slot>
        </div>

        
    </x-filament::section>
</x-filament-widgets::widget>
