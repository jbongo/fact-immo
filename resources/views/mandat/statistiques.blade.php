@extends('layouts.app')
@section('content')
@section('page_title')
    <a href="{{ route('mandat.index') }}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5">
        <i class="ti-angle-double-left"></i>@lang('Retour')
    </a>
    Statistiques des mandats
@endsection

<div class="row">
    <!-- Cartes de statistiques globales -->
    <div class="col-lg-3 col-md-6">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 text-primary">{{ $stats['total_mandats'] }}</h2>
                        <p class="mb-0">Total Mandats</p>
                    </div>
                    <i class="ti-files fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 text-success">{{ $stats['mandats_mois'] }}</h2>
                        <p class="mb-0">Mandats ce mois</p>
                    </div>
                    <i class="ti-calendar fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 text-warning">{{ $stats['reservations_actives'] }}</h2>
                        <p class="mb-0">Réservations actives</p>
                    </div>
                    <i class="ti-bookmark fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="mb-0 text-danger">{{ $stats['non_retournes'] }}</h2>
                        <p class="mb-0">Non retournés</p>
                    </div>
                    <i class="ti-alert fa-2x opacity-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="col-lg-8 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Évolution des mandats</h4>
                <canvas id="mandatsChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-lg-4 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Répartition par type</h4>
                <canvas id="typesPieChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tableau des mandats non retournés -->
    <div class="col-lg-12 mt-4">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Mandats non retournés par mandataire</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mandataire</th>
                                <th>Nombre de mandats</th>
                                <th>Quota</th>
                                <th>Progression</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stats['non_retournes_par_mandataire'] as $mandataire)
                            <tr>
                                <td>{{ $mandataire['nom'] }}</td>
                                <td>{{ $mandataire['count'] }}</td>
                                <td>{{ $mandataire['quota'] }}</td>
                                <td>
                                    <div class="progress" style="height: 15px;">
                                        <div class="progress-bar {{ $mandataire['count'] >= $mandataire['quota'] ? 'bg-danger' : 'bg-success' }}" 
                                             role="progressbar" 
                                             style="width: {{ ($mandataire['count'] / $mandataire['quota']) * 100 }}%">
                                            {{ round(($mandataire['count'] / $mandataire['quota']) * 100) }}%
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Graphique d'évolution
    new Chart(document.getElementById('mandatsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($stats['evolution']['labels']) !!},
            datasets: [{
                label: 'Mandats',
                data: {!! json_encode($stats['evolution']['mandats']) !!},
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }, {
                label: 'Réservations',
                data: {!! json_encode($stats['evolution']['reservations']) !!},
                borderColor: 'rgb(255, 159, 64)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                }
            }
        }
    });

    // Graphique en camembert
    new Chart(document.getElementById('typesPieChart'), {
        type: 'doughnut',
        data: {
            labels: ['Mandats', 'Réservations', 'Non retournés'],
            datasets: [{
                data: [
                    {{ $stats['total_mandats'] }},
                    {{ $stats['reservations_actives'] }},
                    {{ $stats['non_retournes'] }}
                ],
                backgroundColor: [
                    'rgb(75, 192, 192)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 99, 132)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>
@endpush

<style>
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,.1);
}

.card-body {
    padding: 1.5rem;
}

.opacity-50 {
    opacity: 0.5;
}

.progress {
    border-radius: 20px;
}

.progress-bar {
    border-radius: 20px;
}

@media (max-width: 768px) {
    .card {
        margin-bottom: 1rem;
    }
}
</style>
@endsection 