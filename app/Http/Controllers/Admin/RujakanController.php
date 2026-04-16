<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

class RujakanController extends Controller
{
    /**
     * Display rujukan and support resources
     */
    public function index(Request $request)
    {
        $userCount = User::count();
        $activeTab = $request->query('tab', 'bantuan');
        $systemLogs = AuditLog::with('user')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.rujukan.index', compact('userCount', 'systemLogs', 'activeTab'));
    }

    /**
     * Show help and documentation
     */
    public function bantuan()
    {
        return redirect()->route('admin.rujukan.index', ['tab' => 'bantuan']);
    }

    /**
     * Display system settings
     */
    public function pengaturanSistem()
    {
        return redirect()->route('admin.rujukan.index', ['tab' => 'pengaturan']);
    }

    /**
     * Display system logs
     */
    public function log(Request $request)
    {
        return redirect()->route('admin.rujukan.index', array_filter([
            'tab' => 'log',
            'page' => $request->query('page'),
        ]));
    }
}
