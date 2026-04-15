<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RujakanController extends Controller
{
    /**
     * Display rujukan and support resources
     */
    public function index()
    {
        // Get system statistics
        $userCount = User::count();
        $systemLogs = collect([]); // Placeholder - would fetch from activity_logs table

        return view('admin.rujukan.index', compact('userCount', 'systemLogs'));
    }

    /**
     * Show help and documentation
     */
    public function bantuan()
    {
        return view('admin.rujukan.index');
    }

    /**
     * Display system settings
     */
    public function pengaturanSistem()
    {
        return view('admin.rujukan.index');
    }

    /**
     * Display system logs
     */
    public function log()
    {
        // TODO: Fetch system logs from activity/audit logs table
        // For now, return empty collection
        $systemLogs = collect([]);

        return redirect()->route('admin.rujukan.index');
    }
}
