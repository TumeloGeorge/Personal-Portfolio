<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Experience;
use App\Models\Certification;
use App\Models\ContactMessage;
use App\Models\Skill;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'projects'        => Project::count(),
            'experiences'     => Experience::count(),
            'certifications'  => Certification::count(),
            'skills'          => Skill::count(),
            'unread_messages' => ContactMessage::whereNull('read_at')->count(),
            'total_messages'  => ContactMessage::count(),
        ];

        $recentMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', [
            'stats'          => $stats,
            'recentMessages' => $recentMessages,
        ]);
    }
}