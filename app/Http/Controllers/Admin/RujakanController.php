<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $systemSettings = $this->getSystemSettings();

        return view('admin.rujukan.index', compact('userCount', 'systemLogs', 'activeTab', 'systemSettings'));
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

    protected function getSystemSettings(): array
    {
        $databaseStatus = 'Tidak Tersedia';
        $databaseBadge = 'bg-danger';

        try {
            DB::connection()->getPdo();
            $databaseStatus = 'Aktif';
            $databaseBadge = 'bg-success';
        } catch (\Throwable) {
            $databaseStatus = 'Gagal Dihubungi';
        }

        return [
            'nama_sistem' => config('app.name'),
            'versi_sistem' => '1.0.0',
            'persekitaran' => app()->environment(),
            'mod_debug' => config('app.debug') ? 'Aktif' : 'Tidak Aktif',
            'url_aplikasi' => config('app.url'),
            'zon_masa' => config('app.timezone'),
            'bahasa' => config('app.locale'),
            'versi_php' => PHP_VERSION,
            'pemacu_sesi' => config('session.driver'),
            'sambungan_pangkalan_data' => config('database.default'),
            'pemacu_cache' => config('cache.default'),
            'pemacu_queue' => config('queue.default'),
            'status_pangkalan_data' => $databaseStatus,
            'status_pangkalan_data_badge' => $databaseBadge,
            'jumlah_pengguna' => User::count(),
            'jumlah_log_audit' => AuditLog::count(),
        ];
    }
}
