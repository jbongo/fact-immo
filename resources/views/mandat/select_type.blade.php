@extends('layouts.app')
@section('content')
@section ('page_title')
    <a href="{{route('mandat.index')}}" class="btn btn-warning btn-flat btn-addon m-b-10 m-l-5">
        <i class="ti-angle-double-left"></i>@lang('Retour')
    </a>
    Créer un nouveau mandat
@endsection

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class="col-lg-12">
                        <div class="alert " style="background-color: #f8d7da; border-color: #f5c6cb; text-color: #721c24;">
                            <i class="ti-info-alt"></i> 
                            Vous avez des réservations en cours. Utilisez les réservations qui n'ont pas abouti avant de créer un nouveau mandat.
                        </div>

                        <!-- Liste des réservations -->
                        <div class="row">
                            <h4 class="mb-4">Réservations en cours</h4> <br>
                            
                            @foreach($reservations as $index => $reservation)
                                <div class="col-md-3">
                                    <div class="reservation-item p-3 mb-3 border rounded">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h5 class="mb-1">Réservation #{{ $reservation->numero }}</h5>
                                                <p class="mb-1 text-muted">
                                                    {{ $reservation->nom_reservation }}
                                                    @if(Auth::user()->role == 'admin')
                                                        <br>
                                                        @if($reservation->suiviPar != null) <small>Suivi par: {{ $reservation->suiviPar->nom }} {{ $reservation->suiviPar->prenom }} @endif</small>
                                                    @endif
                                                </p>
                                                <small>Créée le {{ $reservation->created_at->format('d/m/Y') }}</small>
                                            </div>
                                            <a href="{{ route('mandat.edit', Crypt::encrypt($reservation->id)) }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="ti-pencil"></i> Compléter
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @if(($index + 1) % 4 == 0)
                                    </div><div class="row" style="margin-top: 10px;">
                                @endif
                            @endforeach
                        </div>
                
                        <!-- Bouton nouveau mandat -->
                        <hr style="border-color: #000;">
                        <div class="text-center col-md-6 " style="margin-top: 30px;">
                            <a href="{{ route('mandat.create') }}" class="btn btn-danger btn-md">
                                <i class="ti-plus"></i> Créer un nouveau mandat
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.reservation-item {
    transition: all 0.3s ease;
    background: #fff;
}

.reservation-item:hover {
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}
</style>
@endsection 