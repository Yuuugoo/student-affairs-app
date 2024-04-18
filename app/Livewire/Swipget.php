<?php

namespace App\Livewire;

use Rupadana\FilamentSwiper\Widgets\SwiperWidget;
use Filament\Infolists\Infolist;
use Rupadana\FilamentSwiper\Infolists\Components\Swiper;
use Rupadana\FilamentSwiper\Infolists\Components\SwiperImageEntry;

class Swipget extends SwiperWidget
{
    
    public function getComponents(): array
    {
        $data = [
            [
                'url' => 'public/images/plmlogo.svg',
                'alt' => 'Image 1 description',
            ],
            [
                'url' => 'path/to/image2.png',
                'alt' => 'Image 2 description',
            ],
        ];

        return [
            Infolist::make()
                ->schema([
                    SwiperImageEntry::make('attachment')
                        ->navigation(false)
                        ->pagination()
                        ->paginationType(SwiperImageEntry::BULLETS)
                        ->paginationClickable()
                        ->paginationDynamicBullets()
                        ->paginationHideOnClick()
                        ->paginationDynamicMainBullets(2)
                        ->scrollbar()
                        ->scrollbarDragSize(100)
                        ->scrollbarDraggable()
                        ->scrollbarSnapOnRelease()
                        ->scrollbarHide(false)
                        ->height(300)
                        ->autoplay()
                        ->effect(SwiperImageEntry::CARDS_EFFECT)
                        ->cardsPerSlideOffset(2)
                        ->autoplayDelay(500)
                        ->centeredSlides()
                        ->slidesPerView(2)
                        ->data($data),
                ]),
        ];
    }
}
