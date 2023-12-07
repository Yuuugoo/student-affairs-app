<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\View\View;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function showAnnouncement($id)
    {
        $announcement = Announcement::find($id);
        return View::make('filament::widgets::announcements-overview', ['announcement' => $announcement]);
    }
}