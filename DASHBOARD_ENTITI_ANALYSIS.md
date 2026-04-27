# Dashboard Implementation for "Entiti" User Type - Analysis

## Overview
The dashboard system uses role-based filtering to display different content for different user types. For "Entiti (Agensi)" users, the dashboard shows risk metrics specific to their agency.

---

## 1. DASHBOARD CONTROLLER - Data Retrieval
**File:** [app/Http/Controllers/DashboardController.php](app/Http/Controllers/DashboardController.php)

### Role Detection and User Filtering
```php
$user = Auth::user();
$jenisPengguna = $user->jenisPengguna?->jenis_pengguna;
$currentRole = $user->role_type ?? $jenisPengguna ?? 'Unknown';

// For "Entiti" users, filter risks to their agency only
if ($currentRole === 'entiti') {
    // Entiti hanya lihat risiko agensi mereka sendiri
    $riskQuery->where('pemilik_risiko', $user->agensi?->nama_agensi ?? $user->agensi_id);
}
```

### Key Data Retrieved for Entiti Users:

#### 1. Total Risk Count
```php
$totalRisiko = (clone $riskQuery)->count();
```
Counts all risks registered for the user's agency.

#### 2. Risk Level Breakdown
```php
$allRisks = (clone $riskQuery)->with('tahapRisiko')->get();
$jumlahRisikoTinggi = $allRisks->filter(fn($r) => $r->tahapRisiko?->tahap_risiko === 'Tinggi')->count();
$jumlahRisikoSederhana = $allRisks->filter(fn($r) => $r->tahapRisiko?->tahap_risiko === 'Sederhana')->count();
$jumlahRisikoRendah = $allRisks->filter(fn($r) => $r->tahapRisiko?->tahap_risiko === 'Rendah')->count();

// Group by risk level
$riskLevels = $allRisks
    ->groupBy(fn($r) => $r->tahapRisiko?->tahap_risiko ?? 'Unknown')
    ->map(fn($items) => (object)['tahap_risiko' => $items[0]->tahapRisiko?->tahap_risiko ?? 'Unknown', 'total' => $items->count()])
    ->values();
```

#### 3. Top 5 Risks by Frequency
```php
$topRisks = (clone $riskQuery)
    ->with('risiko')
    ->select('risiko_id', DB::raw('count(*) as total'))
    ->groupBy('risiko_id')
    ->orderByDesc('total')
    ->take(5)
    ->get();
```
Returns the 5 most frequently registered risks with their count.

#### 4. Assets Requiring Immediate Attention (Top 3)
```php
$topAttention = (clone $riskQuery)
    ->with('risiko', 'puncaRisiko')
    ->orderByDesc('skor_risiko')
    ->take(3)
    ->get();
```
Returns the 3 risks with the highest scores.

#### 5. Latest Risk Entries
```php
$latestRisks = (clone $riskQuery)
    ->with('risiko', 'puncaRisiko')
    ->orderBy('created_at', 'desc')
    ->take(5)
    ->get();
```
Returns the 5 most recently added risks.

#### 6. Entity Risk Summary
```php
$entitiRisikoDirect = (clone $riskQuery)
    ->select('pemilik_risiko', 'tahap_risiko_id', 
             DB::raw('avg(skor_risiko) as purata_skor'), 
             DB::raw('max(skor_risiko) as max_skor'), 
             DB::raw('max(created_at) as last_review'))
    ->with('tahapRisiko')
    ->groupBy('pemilik_risiko', 'tahap_risiko_id')
    ->orderByDesc('purata_skor')
    ->take(10)
    ->get();
```

### Final Data Compact
```php
return view('dashboard', compact(
    'currentRole',
    'displayName',
    'totalRisiko',
    'totalAset',
    'jumlahRisikoTinggi',
    'jumlahRisikoSederhana',
    'jumlahRisikoRendah',
    'riskLevels',           // Used in charts
    'topRisks',             // Used in charts
    'topAttention',
    'latestRisks',
    'entitiRisiko',
    'entitiHighestRiskLevel',
    'entitiName',
    'userSectorName'
));
```

---

## 2. USER ROLE TYPE DETERMINATION
**File:** [app/Models/User.php](app/Models/User.php)

```php
public function getRoleTypeAttribute(): string
{
    $jenisPengguna = $this->jenisPengguna?->jenis_pengguna ?? '';

    return match ($jenisPengguna) {
        'Sistem Admin' => 'admin',
        'Ketua Sektor' => 'ketua_sektor',
        'Pengurusan' => 'pengurusan',
        'Entiti (Agensi)' => 'entiti',
        default => 'entiti',
    };
}
```

The role type is determined by the `jenisPengguna` relationship which maps to the `jenis_pengguna` field.

---

## 3. DASHBOARD VIEW - BLADE TEMPLATE
**File:** [resources/views/dashboard.blade.php](resources/views/dashboard.blade.php)

The main dashboard view uses a switch statement to include role-specific templates:

```blade
@php
    $currentRole = auth()->user()->role_type ?? 'entiti';
@endphp

@switch($currentRole)
    @case('admin')
        @include('dashboard.admin')
        @break
    @case('ketua_sektor')
        @include('dashboard.ketua-sektor')
        @break
    @case('pengurusan')
        @include('dashboard.pengurusan')
        @break
    @default
        @include('dashboard.entiti')
@endswitch
```

---

## 4. ENTITI DASHBOARD VIEW
**File:** [resources/views/dashboard/entiti.blade.php](resources/views/dashboard/entiti.blade.php)

### Dashboard Header
```blade
<div class="dashboard-header d-flex align-items-center justify-content-between">
    <div>
        <h2>Papan Pemuka Entiti ({{ $entitiName }})</h2>
        <p>Selamat datang, {{ $displayName }}. Uruskan dan pantau risiko dalam agensi anda.</p>
    </div>
    <div>
        <span class="badge dashboard-badge bg-info">Entiti</span>
    </div>
</div>
```

### Key Metric Cards
```blade
<div class="row g-4">
    <!-- Total Risks Registered -->
    <div class="col-lg-3">
        <div class="card-box stat-card">
            <h6>Jumlah Risiko Didaftarkan</h6>
            <p class="fs-2 fw-bold">{{ number_format($totalRisiko) }}</p>
            <p class="text-muted mb-0">Rekod risiko dalam agensi anda.</p>
        </div>
    </div>
    
    <!-- Highest Risk Status -->
    <div class="col-lg-3">
        <div class="card-box stat-card">
            <h6>Status Risiko</h6>
            <p class="fs-2 fw-bold">{{ $entitiHighestRiskLevel?->tahap_risiko ?? 'Tiada' }}</p>
            <p class="text-muted mb-0">Tahap risiko tertinggi yang dikesan.</p>
        </div>
    </div>
    
    <!-- Total Assets Evaluated -->
    <div class="col-lg-3">
        <div class="card-box stat-card">
            <h6>Bilangan Aset</h6>
            <p class="fs-2 fw-bold">{{ number_format($totalAset) }}</p>
            <p class="text-muted mb-0">Aset yang telah melalui penilaian risiko.</p>
        </div>
    </div>
    
    <!-- High Risk Count -->
    <div class="col-lg-3">
        <div class="card-box stat-card">
            <h6>Tahap Risiko</h6>
            <p class="fs-2 fw-bold">{{ number_format($jumlahRisikoTinggi) }}</p>
            <p class="text-muted mb-0">Bilangan entri pada tahap tinggi.</p>
        </div>
    </div>
</div>
```

### Charts Section
```blade
<div class="row g-4 mt-3">
    <!-- Risk Level Distribution (Donut Chart) -->
    <div class="col-lg-6">
        <div class="card-box">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Pecahan Penarafan Risiko</h5>
                <span class="text-secondary">Donut chart</span>
            </div>
            @if($riskLevels->isEmpty())
                <p class="text-muted">Tiada data tahap risiko.</p>
            @else
                <canvas id="riskLevelChart" height="300"></canvas>
            @endif
        </div>
    </div>

    <!-- Top 5 Risks (Bar Chart) -->
    <div class="col-lg-6">
        <div class="card-box">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>5 Risiko Tertinggi dalam Entiti</h5>
                <span class="text-secondary">Graf bar</span>
            </div>
            @if($topRisks->isEmpty())
                <p class="text-muted">Tiada data risiko tertinggi.</p>
            @else
                <canvas id="topRiskChart" height="300"></canvas>
            @endif
        </div>
    </div>
</div>
```

### High Priority Risks Section
```blade
<div class="row g-4 mt-3">
    <div class="col-lg-6">
        <div class="card-box">
            <h5>Paparan Ringkas - 3 Aset Memerlukan Perhatian</h5>
            @if($topAttention->isEmpty())
                <p class="text-muted">Tiada aset yang memerlukan perhatian segera.</p>
            @else
                <div class="list-group">
                    @foreach($topAttention as $item)
                        <div class="list-group-item border-0 p-3 mb-2 shadow-sm rounded-3">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong>{{ optional($item->risiko)->nama_risiko ?? 'Risiko Tidak Diketahui' }}</strong>
                                    <p class="mb-1 text-muted">Aset: {{ $item->pemilik_risiko }}</p>
                                </div>
                                <div class="text-end">
                                    <span class="badge bg-danger">Skor {{ $item->skor_risiko }}</span>
                                    <p class="mb-0 text-muted">{{ $item->tahap_risiko }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <!-- Asset Evaluation Percentage -->
    <div class="col-lg-6">
        <div class="card-box">
            <h5>Peratusan Aset yang Dinilai</h5>
            @if($totalAset > 0)
                <div class="text-center mb-3">
                    <h2 class="display-4 fw-bold text-primary">100%</h2>
                    <p class="text-muted">{{ $totalAset }} daripada {{ $totalAset }} aset telah dinilai</p>
                </div>
                <div class="progress" style="height: 25px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                </div>
            @else
                <p class="text-muted">Tiada aset untuk dinilai.</p>
            @endif
        </div>
    </div>
</div>
```

### Latest Risks Table
```blade
<div class="card-box mt-3">
    <h5>Entri Risiko Terkini</h5>
    @if($latestRisks->isEmpty())
        <p class="text-muted">Tiada entri risiko terkini.</p>
    @else
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Risiko</th>
                        <th>Aset / Pemilik</th>
                        <th>Skor Risiko</th>
                        <th>Tahap Risiko</th>
                        <th>Tarikh</th>
                        <th>Tindakan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($latestRisks as $item)
                        <tr>
                            <td>{{ optional($item->risiko)->nama_risiko ?? 'Tidak Diketahui' }}</td>
                            <td>{{ $item->pemilik_risiko }}</td>
                            <td>{{ $item->skor_risiko }}</td>
                            <td>{{ $item->tahap_risiko }}</td>
                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                            <td><a href="#" class="btn btn-sm btn-grey">Semak</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
```

---

## 5. GRAPH RENDERING - JavaScript (Chart.js)
**File:** [resources/views/dashboard/entiti.blade.php](resources/views/dashboard/entiti.blade.php) (Lines 151-201)

### Chart.js Library Import
```html
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
```

### Data Preparation for Charts
```javascript
const riskLevelData = @json($riskLevels->pluck('total'));
const riskLevelLabels = @json($riskLevels->pluck('tahap_risiko'));
const topRiskData = @json($topRisks->map(fn($item) => $item->total));
const topRiskLabels = @json($topRisks->map(fn($item) => optional($item->risiko)->nama_risiko ?? 'Tidak Diketahui'));
```

### Risk Level Distribution Chart (Donut)
```javascript
if (document.getElementById('riskLevelChart')) {
    new Chart(document.getElementById('riskLevelChart'), {
        type: 'doughnut',
        data: {
            labels: riskLevelLabels,  // ['Tinggi', 'Sederhana', 'Rendah']
            datasets: [{
                data: riskLevelData,   // [5, 8, 3]
                backgroundColor: ['#1f3c88', '#f58220', '#ec4899', '#22c55e', '#6366f1'],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
}
```

### Top 5 Risks Chart (Bar)
```javascript
if (document.getElementById('topRiskChart')) {
    new Chart(document.getElementById('topRiskChart'), {
        type: 'bar',
        data: {
            labels: topRiskLabels,    // Risk names
            datasets: [{
                label: 'Bilangan Aset Terjejas',
                data: topRiskData,     // Count for each risk
                backgroundColor: '#1f3c88'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
}
```

---

## 6. RISK REGISTER MODEL
**File:** [app/Models/RegisterRisk.php](app/Models/RegisterRisk.php)

```php
class RegisterRisk extends Model
{
    protected $table = 'risk_register';
    protected $fillable = [
        'cbom_id',
        'risiko_id',
        'pemilik_risiko',           // The agency name or ID
        'punca_risiko_id',          // Risk source
        'impak_id',                 // Impact
        'kebarangkalian_id',        // Probability
        'skor_risiko',              // Risk score
        'tahap_risiko_id',          // Risk level (High/Medium/Low)
        'kawalan_sedia_ada',        // Existing controls
        'pelan_mitigasi'            // Mitigation plan
    ];

    public function tahapRisiko()
    {
        return $this->belongsTo(TahapRisiko::class, 'tahap_risiko_id');
    }

    public function risiko()
    {
        return $this->belongsTo(Risiko::class, 'risiko_id');
    }

    public function puncaRisiko()
    {
        return $this->belongsTo(PuncaRisiko::class, 'punca_risiko_id');
    }
}
```

---

## 7. ENTITI-SPECIFIC RISK CONTROLLER
**File:** [app/Http/Controllers/Entiti/PengurusanRisikoController.php](app/Http/Controllers/Entiti/PengurusanRisikoController.php)

### Risk List Index (Entity-Filtered)
```php
public function index(Request $request)
{
    $user = auth()->user();

    // Build query for risks owned by user's entity
    $query = RegisterRisk::query()
        ->where('pemilik_risiko', $user->agensi?->nama_agensi)
        ->with(['risiko', 'risiko.subKategoriRisiko', 
                'risiko.subKategoriRisiko.kategoriRisiko', 'tahapRisiko']);

    // Search by risk name
    if ($request->filled('search')) {
        $query->whereHas('risiko', function ($q) use ($request) {
            $q->where('nama_risiko', 'like', '%' . $request->search . '%');
        });
    }

    // Filter by approval status
    if ($request->filled('status')) {
        if ($request->status === 'menunggu') {
            $query->whereNull('status_persetujuan');
        } else {
            $query->where('status_persetujuan', $request->status);
        }
    }

    $risks = $query->paginate(10);

    return view('entiti.pengurusan_risiko.index', compact('risks'));
}
```

### Authorization Check
```php
public function show($id)
{
    $risk = RegisterRisk::with([
        'risiko',
        'puncaRisiko',
        'tahapRisiko'
    ])->findOrFail($id);

    // Check authorization - only view own agency's risks
    if ($risk->pemilik_risiko !== auth()->user()->agensi?->nama_agensi) {
        abort(403, 'Unauthorized access');
    }

    return view('entiti.pengurusan_risiko.show', compact('risk'));
}
```

---

## 8. DATA FILTERING SUMMARY

### How "Entiti" User Access is Controlled:

1. **In DashboardController:**
   - Risk data is filtered by `pemilik_risiko = $user->agensi->nama_agensi`
   - Only risks belonging to the user's agency are retrieved

2. **In PengurusanRisikoController:**
   - Same filtering applied in the `index()` method
   - Authorization checks in `show()`, `edit()`, `update()`, `destroy()` methods

3. **In View:**
   - Charts and tables are only populated with filtered data
   - The dashboard title shows the agency name: `Papan Pemuka Entiti ({{ $entitiName }})`

---

## 9. KEY METRICS DISPLAYED FOR ENTITI USERS

| Metric | Source | Purpose |
|--------|--------|---------|
| Jumlah Risiko Didaftarkan | `RegisterRisk::where('pemilik_risiko', ...)` count | Total risks for agency |
| Status Risiko | Highest `tahap_risiko` from filtered risks | Current highest risk level |
| Bilangan Aset | Distinct `pemilik_risiko` count | Assets in assessment |
| Tahap Risiko Tinggi | Filter where `tahap_risiko = 'Tinggi'` | High-level risk count |
| Risk Level Distribution | Group by `tahap_risiko`, count per level | Donut chart data |
| Top 5 Risks | Group by `risiko_id`, count occurrences | Bar chart data |
| 3 Highest Priority Risks | Order by `skor_risiko` DESC, take 3 | Attention needed |
| Latest Risks | Order by `created_at` DESC, take 5 | Recent activity |

---

## 10. QUERY FLOW DIAGRAM

```
User Login
    ↓
Auth::user() retrieves User with jenisPengguna relationship
    ↓
User Model getRoleTypeAttribute() returns 'entiti'
    ↓
DashboardController::index() called
    ↓
Build RegisterRisk query filtered by pemilik_risiko = user.agensi.nama_agensi
    ↓
Execute queries for:
  - Total risks count
  - Risk level breakdown (Tinggi/Sederhana/Rendah)
  - Top 5 risks by frequency
  - Top 3 risks by score
  - Latest 5 risks
    ↓
Return to dashboard.blade.php with $currentRole = 'entiti'
    ↓
Include dashboard/entiti.blade.php
    ↓
Render HTML and pass data to Chart.js scripts
    ↓
JavaScript renders Doughnut and Bar charts with filtered data
```

---

## Summary

- **Dashboard Controller** (`DashboardController.php`): Handles all role-based data retrieval with a centralized approach
- **Role Type**: Determined by User model's `getRoleTypeAttribute()` method mapping to `jenisPengguna`
- **Data Filtering**: Entiti users can only see risks where `pemilik_risiko` matches their agency name
- **Charts Library**: Chart.js 4.4.0 renders two interactive charts (Doughnut and Bar)
- **Key Query Parameters**: 
  - `$user->agensi?->nama_agensi` - Agency name filter
  - `tahap_risiko_id` relationship - Risk level classification
  - `skor_risiko` - Risk scoring for priority determination
