@extends('layouts.app')
@section('content')
    @section ('page_title')
    Calculs stats {{$mandataire->nom}} {{$mandataire->prenom}}
    @endsection
    <div class="row"> 
       
        <div class="col-lg-12">
                @if (session('ok'))
       
                <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
                </div>
             @endif       
            <div class="card alert">
                <!-- table -->
                
                <div class="card-body">
                        
                    <span style="color: #ff0080"> CA directe sur les 12 derniers mois  </span> :<span> {{$ca_direct}}</span> <hr>
                    <span style="color: #ff0080"> CA indirecte sur les 12 derniers mois </span> : <span> {{$ca_indirect}}</span> <hr>
                    <span style="color: #ff0080"> Nombre de vente sur les 12 derniers mois </span> : <span> {{$vente_12}}</span> <hr>
                    <span style="color: #ff0080"> Nombre de filleuls </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> CA global Styl'immo 2019 tableau </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> CA global Styl'immo 2020 tableau </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> CA Styl en attente d'encaissement </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> CA Styl encaissé </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> Nombre de mandataire </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> Nombre d'affaires en cour' </span> : <span>{{$nb_filleul}} </span> <hr>
                    <span style="color: #ff0080"> Est-il à jour dans ses règlements de pubs ? </span> : <span> </span> <hr>
                    <span style="color: #ff0080"> Si filleul, dans quel cycle ?  </span> : <span> </span> <hr>

<br>
                    <hr>
                <form action="{{route('store.parrain',$mandataire->id)}}" method="post">
                    {{ csrf_field() }}
            <div class="form-group row" id="parrain-id">
                <label class="col-lg-4 col-form-label" for="parrain_id">Choisir le parrain</label>
                <div class="col-lg-8">
                    <select class="selectpicker col-lg-6" id="parrain_id" name="parrain_id" data-live-search="true" data-style="btn-warning btn-rounded">
                        @foreach ($parrains as $parrain )
                        <option value="{{ $parrain->id }}" data-tokens="{{ $parrain->nom }} {{ $parrain->prenom }}">{{ $parrain->nom }} {{ $parrain->prenom }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
       
                    
<br><br>
<div class="form-group row" style="text-align: center; margin-top: 50px;">
    <div class="col-lg-8 ml-auto">
        <button class="btn btn-danger btn-flat btn-addon btn-lg m-b-10 m-l-5  " id="sauvegarder"><i class="ti-save"></i>Sauvegarder</button>
    </div>
</div> </form>
<br><br><hr>


                </div>
                <!-- end table -->
            </div>
        </div>
    </div>
@endsection
@section('js-content')
<script>

    </script>

    {{-- ###### Parrainage --}}
<script>
    
    // $('#parrain-id').hide();
    // $('#parrainage_div').hide();

    $('#a_parrain').change(function(e) {
        e.preventDefault();
        if($("#a_parrain").prop('checked')){
            $('#parrain-id').slideDown();
            $('#parrainage_div').slideDown();
        }else{
            $('#parrain-id').slideUp();
            $('#parrainage_div').slideUp();
            
        }
        

    });
</script>
{{-- ###### Fin parrain --}}
@endsection