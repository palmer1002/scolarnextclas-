@extends('layouts.app')

@section('title', 'Tableau de bord - ScolarNextClas')

@section('content')
@php
    use Illuminate\Support\Str;
@endphp

<div class="container-fluid animate__animated animate__fadeIn">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">
                <i class="fa-solid fa-gauge-high text-primary me-2"></i>Tableau de Bord
            </h1>
            <p class="mb-0 text-muted">Aperçu global de votre établissement</p>
        </div>

        <div class="d-none d-sm-inline-block">
            <div class="btn-group shadow-sm">
                <span class="btn btn-white border border-end-0 bg-white pe-none">
                    <i class="fa-regular fa-calendar-days text-primary me-1"></i>
                    {{ now()->translatedFormat('d F Y') }}
                </span>
                <button class="btn btn-primary" onclick="window.location.reload()"><i class="fa-solid fa-rotate"></i></button>
            </div>
        </div>
    </div>

    <!-- Statistiques Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Élèves -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-15 stat-card h-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Élèves</div>
                            <div class="h3 mb-0 fw-bold counter">{{ $stats['eleves_count'] ?? 0 }}</div>
                            <div class="small text-muted mt-1"><i class="fa-solid fa-arrow-up text-success"></i> Inscrits</div>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-4 rounded-circle text-primary">
                            <i class="fa-solid fa-users-viewfinder fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="progress rounded-0" style="height: 4px;">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Enseignants -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-15 stat-card h-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Enseignants</div>
                            <div class="h3 mb-0 fw-bold counter">{{ $stats['profs_count'] ?? 0 }}</div>
                            <div class="small text-muted mt-1">Actifs ce mois</div>
                        </div>
                        <div class="bg-success bg-opacity-10 p-4 rounded-circle text-success">
                            <i class="fa-solid fa-chalkboard-user fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="progress rounded-0" style="height: 4px;">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Revenus -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-15 stat-card h-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Revenus (CFA)</div>
                            <div class="h3 mb-0 fw-bold counter">{{ $stats['paiements_total_formatted'] ?? 0 }}</div>
                            <div class="small text-muted mt-1">Total encaissé</div>
                        </div>
                        <div class="bg-info bg-opacity-10 p-4 rounded-circle text-info">
                            <i class="fa-solid fa-sack-dollar fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="progress rounded-0" style="height: 4px;">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>

        <!-- Alertes -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-0 shadow-sm radius-15 stat-card h-100 overflow-hidden">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Alertes</div>
                            <div class="h3 mb-0 fw-bold text-danger counter">{{ isset($alerts) ? count($alerts) : 0 }}</div>
                            <div class="small text-muted mt-1">Nécessitent attention</div>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-4 rounded-circle text-danger">
                            <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                        </div>
                    </div>
                </div>
                <div class="progress rounded-0" style="height: 4px;">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 100%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique Répartition -->
    <div class="row g-4 mb-4">
        <div class="col-lg-12">
            <div class="card border-0 shadow-sm radius-15">
                <div class="card-header bg-transparent border-0 py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="fa-solid fa-chart-pie me-2 text-primary"></i>Répartition des Élèves</h5>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6 d-flex justify-content-center">
                            <canvas id="genderChart" style="max-height: 250px;"></canvas>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4">
                                <div class="d-flex justify-content-between mb-3 p-3 bg-light rounded-3 transition-hover">
                                    <span class="h6 mb-0 align-self-center"><i class="fa-solid fa-mars text-primary me-2 fa-lg"></i>Garçons</span>
                                    <span class="h5 mb-0 fw-bold text-primary">{{ $stats['garcons_count'] ?? 0 }}</span>
                                </div>
                                <div class="d-flex justify-content-between p-3 bg-light rounded-3 transition-hover">
                                    <span class="h6 mb-0 align-self-center"><i class="fa-solid fa-venus text-danger me-2 fa-lg"></i>Filles</span>
                                    <span class="h5 mb-0 fw-bold text-danger">{{ $stats['filles_count'] ?? 0 }}</span>
                                </div>
                                <div class="mt-4 pt-3 border-top">
                                    <div class="d-flex justify-content-between small text-muted">
                                        <span>Total des élèves</span>
                                        <span>{{ ($stats['garcons_count'] ?? 0) + ($stats['filles_count'] ?? 0) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertes et Élèves -->
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm radius-15 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fa-solid fa-robot me-2 text-primary"></i>Analyses IA
                    </h5>
                    <span class="badge bg-light text-primary border px-3">En direct</span>
                </div>
                <div class="card-body">
                    @forelse($alerts ?? [] as $alert)
                        <div class="alert bg-{{ $alert['type'] }} bg-opacity-10 border-0 border-start border-4 border-{{ $alert['type'] }} mb-3 p-3 position-relative alert-animated">
                            <div class="d-flex align-items-center mb-2">
                                <strong class="text-{{ $alert['type'] }}">{{ $alert['title'] }}</strong>
                            </div>
                            <p class="mb-2 small">{{ $alert['message'] }}</p>
                            <a href="{{ $alert['action_url'] ?? '#' }}" class="stretched-link text-decoration-none small text-{{ $alert['type'] }} fw-bold">Prendre action <i class="fa-solid fa-arrow-right-long ms-1"></i></a>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="fa-solid fa-circle-check fa-4x text-success mb-3 opacity-25"></i>
                            <p class="text-muted mb-0">Tout semble correct aujourd'hui.</p>
                            <small class="text-xs text-muted">Aucune alerte détectée par l'IA</small>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card border-0 shadow-sm radius-15 h-100">
                <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>Inscriptions Récentes
                    </h5>
                    <a href="{{ route('eleves.index') }}" class="btn btn-sm btn-outline-primary radius-10">Voir tout</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($recent_students ?? [] as $student)
                            <div class="list-group-item bg-transparent border-0 px-4 py-3 d-flex align-items-center border-bottom-light hover-list">
                                <div class="avatar-md me-3 bg-gradient-{{ ($student->genre ?? '') == 'Féminin' ? 'danger' : 'primary' }} text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm fw-bold">
                                    {{ strtoupper(substr($student->nom ?? '?', 0, 1)) }}
                                </div>
                                <div class="flex-grow-1">
                                    <div class="fw-bold mb-0 text-dark">{{ $student->nom ?? 'Élève' }} {{ $student->prenom ?? '' }}</div>
                                    <small class="text-muted">{{ $student->matricule ?? 'N/A' }} • {{ $student->classe->nom ?? ($student->classe?->nom ?? 'N/A') }}</small>
                                </div>
                                <div class="text-end">
                                    <div class="small fw-bold text-dark">{{ isset($student->created_at) ? $student->created_at->format('d/m/Y') : '' }}</div>
                                    <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 0.65rem;">NOUVEAU</span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-5">
                                <p class="text-muted mb-0 italic">Aucun nouvel élève.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<script>
    // Config Chart.js
    Chart.defaults.font.family = 'Outfit, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
    Chart.defaults.color = '#858796';



    // Gender Chart
    const ctxGender = document.getElementById('genderChart').getContext('2d');
    new Chart(ctxGender, {
        type: 'doughnut',
        data: {
            labels: @json($stats['gender_distribution']['labels'] ?? []),
            datasets: [{
                data: @json($stats['gender_distribution']['data'] ?? []),
                backgroundColor: ['#4e73df', '#e74a3b'],
                hoverBackgroundColor: ['#2e59d9', '#be2617'],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            }]
        },
        options: {
            maintainAspectRatio: false,
            cutout: '80%',
            plugins: { legend: { display: false } }
        }
    });

    // Count-up animation
    document.querySelectorAll('.counter').forEach(counter => {
        const target = +counter.innerText.replace(/\s/g, '');
        let count = 0;
        const speed = 2000 / target;
        
        const updateCount = () => {
            const increment = target / 50;
            if (count < target) {
                count += increment;
                counter.innerText = Math.ceil(count).toLocaleString('fr-FR');
                setTimeout(updateCount, 1);
            } else {
                counter.innerText = target.toLocaleString('fr-FR');
            }
        };
        if(target > 0) updateCount();
    });
</script>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap');
    
    body { font-family: 'Outfit', sans-serif !important; background-color: #f8f9fc; }
    .radius-15 { border-radius: 15px; }
    .radius-10 { border-radius: 10px; }
    .stat-card { transition: transform 0.3s ease, shadow 0.3s ease; }
    .stat-card:hover { transform: translateY(-5px); box-shadow: 0 .5rem 2rem rgba(0,0,0,.15)!important; }
    .hover-list { transition: background 0.2s ease; cursor: pointer; }
    .hover-list:hover { background-color: rgba(78, 115, 223, 0.03) !important; }
    .transition-hover { transition: all 0.2s ease; }
    .transition-hover:hover { transform: scale(1.02); background-color: #f1f3f9 !important; }
    .bg-gradient-primary { background: linear-gradient(135deg, #4e73df 0%, #224abe 100%); }
    .bg-gradient-danger { background: linear-gradient(135deg, #e74a3b 0%, #be2617 100%); }
    .avatar-md { width: 45px; height: 45px; font-size: 1.2rem; }
    .border-bottom-light { border-bottom: 1px solid #f1f3f9; }
    .alert-animated { animation: slideIn 0.5s ease-out; }
    @keyframes slideIn { from { opacity: 0; transform: translateX(20px); } to { opacity: 1; transform: translateX(0); } }
</style>
@endpush
@endsection

