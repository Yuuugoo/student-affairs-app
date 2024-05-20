<x-filament-panels::page>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <style>
    .swiper {
      width: 100%;
      height: auto;
      padding: 20px;
      background-color: #f8f8f8;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      border-radius: 10px;
    }

    .swiper-slide {
      text-align: left;
      padding: 20px;
      background: #fff;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      display: flex;
      flex-direction: row;
      align-items: center;
      justify-content: flex-start;
    }

    .text-content {
      width: 50%;
      display: flex;
      flex-direction: column;
      margin-left: 100px;
    }

    .swiper-slide img {
      display: block;
      width: 100%;
      height: auto;
      max-height: 300px;
      object-fit: contain;
      border-radius: 50px;
    }

    .swiper-slide h3 {
      font-size: 24px;
      margin-bottom: 5px;
      font-weight: bold; 
    }

    .swiper-slide p {
      font-size: 16px;
      color: #555;
      margin-bottom: 10px;
    }

    .swiper-button-prev,
    .swiper-button-next {
      color: #333; 
    }

    .swiper-pagination-bullet {
      background-color: #888;
      opacity: 1;
    }

    .swiper-pagination-bullet-active {
      background-color: #b89735;
    }

    .swiper-button-prev,
    .swiper-button-next {
      top: 50%;
      transform: translateY(-50%);
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background-color: rgba(0, 0, 0, 0.1);
      display: flex;
      justify-content: center;
      align-items: center;
      transition: background-color 0.3s;
    }

    .swiper-button-prev:hover,
    .swiper-button-next:hover {
      background-color: rgba(0, 0, 0, 0.3);
    }

    .swiper-button-prev:after,
    .swiper-button-next:after {
      font-size: 20px;
      color: #333;
    }

    .btn-primary {
      color: #fff;
      background-color: #b89735;
      border-color: gold;
      width: fit-content;
      padding: 10px 20px;
      margin-top: 10px;
      border-radius: 5px;
    }

    .featured-announcements-title {
      font-weight: bold;
      font-size: 24px;
      margin-top: 20px;
    }
  </style>

  @php
    $announcements = \App\Models\Announcement::where('publish', true)->get();
  @endphp
  <div class="featured-announcements-title">FEATURED ANNOUNCEMENTS:</div>
  <div class="swiper">
    <div class="swiper-wrapper">
      @foreach ($announcements as $announcement)
        <div class="swiper-slide">
          <div class="text-content">
            <h3>{{ $announcement->title }}</h3>
            <p>{{ $announcement->description }}</p>
            <a href="{{ $announcement->content }}" class="btn btn-primary" target="_blank">Learn More</a>
          </div>
          <img src="{{ asset('storage/' . $announcement->image_preview) }}" alt="{{ $announcement->title }}">
        </div>
      @endforeach
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-button-next"></div>
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
      });
    });
  </script>
</x-filament-panels::page>
