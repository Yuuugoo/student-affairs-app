<x-filament-panels::page>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>

    <style>
        .swiper {
            width: 100%;
            height: 300px; /* Adjust height as needed */
            margin: 0 auto;
        }

        .swiper-slide {
            text-align: center;
            font-size: 18px;
            background: #fff;

            /* Center slide text vertically */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .swiper-slide img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .swiper-button-prev, .swiper-button-next {
            color: #007bff; /* Change color if needed */
        }
    </style>

    <div class="swiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide"><img src="https://via.placeholder.com/800x300?text=Slide+1" alt="Slide 1"></div>
            <div class="swiper-slide"><img src="https://via.placeholder.com/800x300?text=Slide+2" alt="Slide 2"></div>
            <div class="swiper-slide"><img src="https://via.placeholder.com/800x300?text=Slide+3" alt="Slide 3"></div>
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-scrollbar"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const swiper = new Swiper('.swiper', {
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                scrollbar: {
                    el: '.swiper-scrollbar',
                },
            });
        });
    </script>
</x-filament-panels::page>
