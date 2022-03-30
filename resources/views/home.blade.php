@extends('layouts.app')


@section('content')



<style type="text/css">
    .button {
      backface-visibility: hidden;
    position: relative;
    width: 40px;
    height: 40px;
    cursor: pointer;
    display: inline-block;
    white-space: nowrap;
    
    border-radius: 100px;
    border: 0px solid #444;
    border-width: 0px 0px 0px 0px;
    padding: 10px 13px 10px 13px;
      color: #000;
    font-size: 16px;
    font-family: Helvetica Neue;
    font-weight: 900;
    font-style: normal
    }
    .button > div {
      color: #999;
    font-size: 10px;
    font-family: Helvetica Neue;
    font-weight: initial;
    font-style: normal;
    text-align: center;
    margin: 0px 0px 0px 0px
    }
    .button > i {
      color: #fff;
    font-size: 1em;
    border-radius: 0px;
    border: 0px solid transparent;
    border-width: 0px 0px 0px 0px;
    padding: 0px 0px 0px 0px;
    margin: 0px 0px 0px 0px;
    position: static
    }
    .button > .ld {
      font-size: initial
    }
    
    .stats-text{
        font-weight: 900;
    
    }
  </style>
  
  
  
@section ('page_title')
    {{-- <a class="btn btn-success  btn-rounded btn-addon btn-sm m-b-10 m-l-5" id="ajouter"><i class="ti-plus"></i>Stats {{config('stats.STATS.annee')}} </a>  --}}
    <label>Modifier l'année</label>
    <div class="row">
        <div class="col-md-2">
  
    <select name="annee" id="annee" class="form-control">
            @for ($an = 2019; $an <= date('Y') +1 ; $an++)
                @if($an == config('stats.STATS.annee'))
                    <option selected="selected" value="{{config('stats.STATS.annee')}}">{{config('stats.STATS.annee')}}</option>
                @else
                    <option value="{{$an}}">{{$an}} </option>

                @endif
            @endfor

    </select>

        </div>
    </div>
    
    <br><br>
    
    
   

    
@endsection

 @if(Auth::user()->role == "mandataire") 
 
 
  
 <div class="row" >
      
    <div class="col-lg-8">
        <div class="card alert">
            <div class="card-header">
                <h4>Mon Chiffre d'affaires HT {{config('stats.STATS.annee')}}  </h4>
                {{-- <div class="card-header-right-icon">
                    <ul>
                        <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li>
                        <li class="doc-link"><a href="#"><i class="ti-link"></i></a></li>
                    </ul>
                </div> --}}
                <br><br>
                <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}#sous_offre_nav"><div title="Sous offre" class="button" style="background:#FF8C00;" href="{{route('compromis.index')}}#sous_offre_nav"><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_sous_offre_N"]}}</div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires sous offre</span> 
                <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}#sous_compromis_nav"><div title="Sous compromis" class="button" style="background: #0ad2ff;" href="{{route('compromis.index')}}#sous_compromis_nav"><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_sous_compromis_N"]}}</div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires sous compromis</span> 
                <a href="{{route('facture.index_honoraire_en_attente',config('stats.STATS.annee'))}}"><div title="En attente d'encaissement" class="button" style="background: #e6e6e6;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_en_attente_perso_N"]}}</div></div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires non encaissées</span>
                <a href="{{route('facture.index_honoraire_encaissee',config('stats.STATS.annee'))}}"><div title="Encaissé" class="button" style="background: #2e5;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_encaisse_perso_N"]}}</div></div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires encaissées</span>  
                <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}"><div title="Général" class="button" style="background: #ff1a1a;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_global_perso_N"]}}</div></div></div></a> <span style="font-family: Montserrat; font-size:13px;  "> Toutes les affaires</span> 
             <br><br>
            </div>
            <div class="sales-chart_perso">
                <canvas id="sales-chart_perso"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4" >
        <div class="card" style="height: 100%; ">
            <div class="card-body">
                <h4 class="card-title">Mon Chiffre d'affaires HT annuel {{config('stats.STATS.annee')}} </h4>
                <div id="morris-donut-chart_perso"></div>
            </div>
            <div>
                <button style="background-color:#ff1a1a; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Mon Chiffre d'affaires HT Général : {{number_format( array_sum(config('stats.CA_N')[5]) ,2,'.',',')}}</span> 
            </div>

           

        </div>
        
    </div>
     
  
</div>


<hr><br>
 
 @endif

{{--  CA ANNEE N --}}
<div class="row" >
    
 
    {{-- <a href="{{route('compromis_type.index')}}" class="btn btn-danger btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-folder"></i>@lang('Voir les affaires')</a> --}}
    <br>
    <div class="col-lg-8">
        <div class="card alert">
        
           
         <br><br>
            <div class="card-header">
                <h4>Chiffre d'affaires STYL'IMMO HT {{config('stats.STATS.annee')}}  </h4>
                {{-- <div class="card-header-right-icon">
                    <ul>
                        <li class="card-close" data-dismiss="alert"><i class="ti-close"></i></li>
                        <li class="doc-link"><a href="#"><i class="ti-link"></i></a></li>
                    </ul>
                </div> --}}
                
                <br><br>
                <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}#sous_offre_nav"><div title="Sous offre" class="button" style="background:#FF8C00;" href="{{route('compromis.index')}}#sous_offre_nav"><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_sous_offre_N"]}}</div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires sous offre</span> 
                <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}#sous_compromis_nav"><div title="Sous compromis" class="button" style="background: #0ad2ff;" href="{{route('compromis.index')}}#sous_compromis_nav"><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_sous_compromis_N"]}}</div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires sous compromis</span> 
                <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}#en_attente_nav"><div title="En attente d'encaissement" class="button" style="background: #e6e6e6;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_en_attente_N"]}}</div></div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires non encaissées</span>
                <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}#encaissee_nav"><div title="Encaissé" class="button" style="background: #2e5;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_encaisse_N"]}}</div></div></div> </a></span> <span style="font-family: Montserrat; font-size:13px;  "> Les affaires encaissées</span>  
                <a href="{{route('compromis.index_from_dashboard',config('stats.STATS.annee'))}}"><div title="Général" class="button" style="background: #ff1a1a;" ><div><div  style=" color:black;font-family: Montserrat; font-size:13px;" >{{config('stats.STATS')["nb_global_N"]}}</div></div></div></a> <span style="font-family: Montserrat; font-size:13px;  "> Toutes les affaires</span> 
             
            </div>
            <div class="sales-chart">
                <canvas id="sales-chart"></canvas>
            </div>
        </div>
    </div>
    <div class="col-lg-4" >
        <div class="card" style="height: 100%; ">
            <div class="card-body">
                <h4 class="card-title">Chiffre d'affaires Styl HT annuel {{config('stats.STATS.annee')}} </h4>
                <div id="morris-donut-chart"></div>
            </div>
            <hr>
            <div>
                <button style="background-color:#ff1a1a; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Chiffre d'affaires Styl HT Général :  <span style="color: #ff1a1a"> {{number_format( array_sum(config('stats.CA_N')[0]) ,2,'.',',')}} </span></span> 
            </div>

            @if(Auth::user()->role == "mandataire")
            <div>
                {{-- <button style="background-color:#66556f; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Chiffre d'affaires Styl HT contractuel : {{number_format( Auth::user()->chiffre_affaire_styl(Auth::user()->date_anniv(), date('Y-m-d')) ,2,'.',',')}}</span>  --}}
            </div>
            @endif

        </div>
        
    </div>
     
  
</div>
{{-- ######## --}}

{{--  CA ANNEE N --}}
<div class="row" >
      
    <div class="col-lg-12">
        <div class="card alert">
            <div class="card-header">
                {{-- <h4>Légende </h4> --}}
                
               
            </div>
            <div class="sales-chart">
                <!-- sample html for this button-->

  <!-- stylesheet for this button -->
  
            </div>
        </div>
    </div>
   
     
  
</div>

{{-- ####################### PUBS CONSOMMES ####################### --}}

@if(Auth::user()->role == "admin")

<div class="row">

    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"> Pub mensuelle </h4>
                <div id="morris-bar-chart"></div>
            </div>
            <hr>
            <button style="background-color:#39ff1a; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Pub encaissée   </span>
            <button style="background-color:#0ad2ff; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Pub vendue  </span>
            <button style="background-color:#ff1a1a; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Pub achetée  </span> 
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card alert nestable-cart">
            <div class="card-header">
                <h4>Pub annuelle</h4>               
            </div>
            <div class="sparkline-unix">
                <div id="sparkline11" class="text-center"></div>
            </div>
            <hr>
            <div>
                <button style="background-color:#39ff1a; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Pub totale encaissée en {{config('stats.STATS')['annee']}} : <span style="color: #39ff1a">  {{number_format( (config('stats.STATS')['TOTAL_PUB_N']) ,2,'.',',')}} </span> </span> <br>
                <button style="background-color:#ff1a1a; width:50px; height:20px"></button> <span style="font-family: Montserrat; font-size:16px; font-weight:bold; ">Pub Totale achetée en {{config('stats.STATS')['annee']}} : <span style="color: #ff1a1a">  {{number_format( (config('stats.STATS')['TOTAL_PUB_ACH']) ,2,'.',',')}} </span> </span> 
            </div>
        </div>
        <!-- /# card -->
    </div>
</div>

@endif


{{-- #######  STATS ###### --}}

@if(Auth::user()->role == "admin")

<div class="row">

    <div class="col-lg-12">
        <div class="card alert">
            <div class="card-header">
                <h4 class="m-l-5">Infos générales</h4>
                <div class="card-header-right-icon">
                    <ul>
                        <li><i class="ti-reload"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="media-stats-content text-center">
                    <div class="row">
                        <div class="col-lg-4 border-bottom">
                            <div class="stats-content">
                                <div class="stats-digit text-danger">{{config('stats.STATS')["nb_affaires_en_cours"]}}</div>
                                <div class="stats-text">Affaires en cours (Non cloturées)</div>
                            </div>
                        </div>
                       
                        <div class="col-lg-4 border-bottom border-left border-right">
                            <div class="stats-content">
                                <div class="stats-digit text-danger">{{config('stats.STATS')["nb_mandataires_actifs"] }}</div>
                                <div class="stats-text">Mandataires actifs</div>
                            </div>
                        </div>
                        <div class="col-lg-4 border-bottom border-left">
                            <div class="stats-content">
                                <div class="stats-digit text-danger">{{config('stats.STATS')["nb_filleuls"]}}</div>
                                <div class="stats-text">Parrainages Actifs</div>
                            </div>
                        </div>
                        <div class="col-lg-4 ">
                            <div class="stats-content">
                                <div class="stats-digit text-danger">{{config('stats.STATS')["nb_mandataires_actifs_n"] }}</div>
                                <div class="stats-text">Mandataires ayants saisi au moins <h1>1</h1> affaire en {{config('stats.STATS.annee')}}</div>
                            </div>
                        </div>
                        <div class="col-lg-4 border-left">
                            <div class="stats-content">
                                <div class="stats-digit text-danger">{{config('stats.STATS')["nb_mandataires_jetons"] }}</div>
                                <div class="stats-text">Mandataires aux jetons</div>
                            </div>
                        </div>
                        <div class="col-lg-4 border-left border-right">
                            <div class="stats-content">
                                <div class="stats-digit text-danger">{{config('stats.STATS')["nb_mandataires_facture_pub"] }}</div>
                                <div class="stats-text">Mandataires à la facturation</div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>


<br>
<div class="row">


    <div class="col-lg-6">
        <div class="col-md-12">
       
            <div class="card">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span><i class="ti-cup f-s-22 color-primary border-primary round-widget"></i></span>
                    </div>
                    <div class="media-body media-text-right text-primary" style="font-size: 25px">
                        <h4>Classement mandataires en {{config('stats.STATS.annee')}}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card alert">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Rang </th>
                                <th>#</th>
                                <th><strong>Chiffre d'affaires STYL </strong></th>
                                {{-- <th><strong>Chiffre d'affaires prévisionnel</strong></th> --}}
                               
                               
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (config('stats.STATS.classements_n') as $key => $classement_n)
                            
                
                            <tr>
                                <td> <span class="color-default" style="font-size: 25px"> <strong> {{$key +1}} </strong></span></td>
                                <td><span class="color-default" style="font-size: 18px"> <strong> {{$classement_n[1]->nom}} {{$classement_n[1]->prenom}} </strong></td>
                                <td> <span class="color-primary" style="font-size: 25px"> <strong>  {{number_format( $classement_n[0] ,2,'.',',')}}  €  </strong></span></td>
                                {{-- <td> <span class="color-default" style="font-size: 25px"> <strong>  {{number_format( $classement_n[0] ,2,'.',',')}}  €  </strong></span></td> --}}
                                
                                
                            </tr>

                            @endforeach

                           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <div class="col-lg-6">
        <div class="col-md-12">
       
            <div class="card">
                <div class="media">
                    <div class="media-left meida media-middle">
                        <span><i class="ti-cup f-s-22 color-danger border-danger round-widget"></i></span>
                    </div>
                    <div class="media-body media-text-right text-danger" style="font-size: 25px">
                        <h4>Classement mandataires depuis 2020</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="card alert">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Rang </th>
                                <th>#</th>
                                <th><strong>Chiffre d'affaires STYL </strong></th>
                               
                               
                               
                            </tr>
                        </thead>
                        <tbody>
                        @foreach (config('stats.STATS.classements') as $key => $classement)
                            
                
                            <tr>
                                <td> <span class="color-default" style="font-size: 25px"> <strong> {{$key +1}} </strong></span></td>
                                <td><span class="color-default" style="font-size: 18px"> <strong> {{$classement[1]->nom}} {{$classement[1]->prenom}} </strong></td>
                                <td> <span class="color-danger" style="font-size: 25px"> <strong>  {{number_format( $classement[0] ,2,'.',',')}}  €  </strong></span></td>
                                
                                
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>


@endif


























































@stop
@section('js-content')



{{-- CA PERSO --}}

{{-- ####################### TABLEAU DES CHIFFRES D'AFFAIRES POUR LES MANDATAIRES ####################### --}}
@if(Auth::user()->role =="mandataire")
<script>

    //Sales chart ANNEE N
    var ctx = document.getElementById("sales-chart_perso");
    ctx.height = 150;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [
                {
                label: "Sous offre",
                data: {{json_encode(config('stats.CA_N')[8])}},
                backgroundColor: 'transparent',
                borderColor: '#FFA500',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#FFA500',
                    },
                    {
                label: "Sous compromis",
                data: {{json_encode(config('stats.CA_N')[9])}},
                backgroundColor: 'transparent',
                borderColor: '#0ad2ff',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#0ad2ff',
                    },

                {
                label: "En attente",
                data: {{json_encode(config('stats.CA_N')[6])}},
                backgroundColor: 'transparent',
                borderColor: '#e6e6e6',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#e6e6e6',
                    },
                {
                label: "Encaissé",
                data: {{json_encode(config('stats.CA_N')[7])}},
                backgroundColor: 'transparent',
                borderColor: '#6eff1a',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#6eff1a',
                    }, 
                    {
                label: "Général",
                data: {{json_encode(config('stats.CA_N')[5])}},
                backgroundColor: 'transparent',
                borderColor: '#ff1a1a',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#ff1a1a',

                    },
                   
                    
                
                ]
        },

            
        options: {
            // responsive: true,

            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            legend: {
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Mois'
                    }
                        }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "Mon Chiffre d'affaires  HT"
                    }
                        }]
            },
            title: {
                display: false,
                text: 'Normal Legend'
            }
        }
    });

    // ############# 

  
</script>





<script>

    // Morris donut chart ANNEE N
    Morris.Donut({
        element: 'morris-donut-chart_perso',
        data: [
        //     {
        //     label: "Général",
        //     value: {{array_sum(config('stats.CA_N')[0])}},

        // }, 
        {
            label: "Sous offre",
            value:  {{array_sum(config('stats.CA_N')[8])}}
        }, {
            label: "Sous Compromis",
            value:  {{array_sum(config('stats.CA_N')[9])}}
        },
        
        {
            label: "En attente",
            value:  {{array_sum(config('stats.CA_N')[6])}}
        }, {
            label: "Encaissé",
            value:  {{array_sum(config('stats.CA_N')[7])}}
        } ],
        resize: true,
        colors:[ '#FFA500','#0ad2ff','#e6e6e6', '#6eff1a']
    });
    
    

</script>


@endif

{{-- FIN CA PERSO --}}














{{-- CA STYL'IMMO --}}
{{-- ####################### TABLEAU DES CHIFFRES D'AFFAIRES POUR LES ADMINISTRATEURS ####################### --}}


<script>

    //Sales chart ANNEE N
    var ctx = document.getElementById("sales-chart");
    ctx.height = 150;
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet","Août","Septembre","Octobre","Novembre","Décembre"],
            type: 'line',
            defaultFontFamily: 'Montserrat',
            datasets: [
                {
                label: "Sous offre",
                data: {{json_encode(config('stats.CA_N')[3])}},
                backgroundColor: 'transparent',
                borderColor: '#FFA500',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#FFA500',
                    },
                    {
                label: "Sous compromis",
                data: {{json_encode(config('stats.CA_N')[4])}},
                backgroundColor: 'transparent',
                borderColor: '#0ad2ff',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#0ad2ff',
                    },

                {
                label: "En attente",
                data: {{json_encode(config('stats.CA_N')[1])}},
                backgroundColor: 'transparent',
                borderColor: '#e6e6e6',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#e6e6e6',
                    },
                {
                label: "Encaissé",
                data: {{json_encode(config('stats.CA_N')[2])}},
                backgroundColor: 'transparent',
                borderColor: '#6eff1a',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#6eff1a',
                    }, 
                    {
                label: "Général",
                data: {{json_encode(config('stats.CA_N')[0])}},
                backgroundColor: 'transparent',
                borderColor: '#ff1a1a',
                borderWidth: 3,
                pointStyle: 'circle',
                pointRadius: 5,
                pointBorderColor: 'transparent',
                pointBackgroundColor: '#ff1a1a',

                    },
                   
                    
                
                ]
        },

            
        options: {
            // responsive: true,

            tooltips: {
                mode: 'index',
                titleFontSize: 12,
                titleFontColor: '#000',
                bodyFontColor: '#000',
                backgroundColor: '#fff',
                titleFontFamily: 'Montserrat',
                bodyFontFamily: 'Montserrat',
                cornerRadius: 3,
                intersect: false,
            },
            legend: {
                labels: {
                    usePointStyle: true,
                    fontFamily: 'Montserrat',
                },
            },
            scales: {
                xAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: false,
                        labelString: 'Mois'
                    }
                        }],
                yAxes: [{
                    display: true,
                    gridLines: {
                        display: false,
                        drawBorder: false
                    },
                    scaleLabel: {
                        display: true,
                        labelString: "Mon Chiffre d'affaires  HT"
                    }
                        }]
            },
            title: {
                display: false,
                text: 'Normal Legend'
            }
        }
    });

    // ############# 

  
</script>





<script>

    // Morris donut chart ANNEE N
    Morris.Donut({
        element: 'morris-donut-chart',
        data: [
        //     {
        //     label: "Général",
        //     value: {{array_sum(config('stats.CA_N')[0])}},

        // }, 
        {
            label: "Sous offre",
            value:  {{array_sum(config('stats.CA_N')[3])}}
        }, {
            label: "Sous Compromis",
            value:  {{array_sum(config('stats.CA_N')[4])}}
        },
        
        {
            label: "En attente",
            value:  {{array_sum(config('stats.CA_N')[1])}}
        }, {
            label: "Encaissé",
            value:  @if(Auth::user()->role == "mandataire")  {{config('stats.STATS')['ca_styl_encaisse_associe']}}  @else {{array_sum(config('stats.CA_N')[2])}} @endif
        } ],
        resize: true,
        colors:[ '#FFA500','#0ad2ff','#e6e6e6', '#6eff1a']
    });

</script>



{{-- FIN CA STYL'IMMO --}}




{{-- ####################### JETONS CONSOMMES ####################### --}}
@if(Auth::user()->role =="admin")
<script>
// Dashboard 1 Morris-chart
$(function () {
    "use strict";

// Morris bar chart
    Morris.Bar({
        element: 'morris-bar-chart',
        
        data: [
        { 
            y:'Janvier',
            a:{{config('stats.STATS')['PUB_N'][1]}},
            b:{{config('stats.STATS')['PUB_VENDU'][1]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
          
        },
        
        { 
            y:'Février',
            a:{{config('stats.STATS')['PUB_N'][2]}},
            b:{{config('stats.STATS')['PUB_VENDU'][2]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
           
        },
        
        { 
            y:'Mars',
            a:{{config('stats.STATS')['PUB_N'][3]}},
            b:{{config('stats.STATS')['PUB_VENDU'][3]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
          
        },
        
        { 
            y:'Avril',
            a:{{config('stats.STATS')['PUB_N'][4]}},
            b:{{config('stats.STATS')['PUB_VENDU'][4]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
         
        },
        
        { 
            y:'Mai',
            a:{{config('stats.STATS')['PUB_N'][5]}},
            b:{{config('stats.STATS')['PUB_VENDU'][5]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
         
        },
        
        { 
            y:'Juin',
            a:{{config('stats.STATS')['PUB_N'][6]}},
            b:{{config('stats.STATS')['PUB_VENDU'][6]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
          
        },
        
        { 
            y:'Juillet',
            a:{{config('stats.STATS')['PUB_N'][7]}},
            b:{{config('stats.STATS')['PUB_VENDU'][7]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
           
        },
        
        { 
            y:'Août',
            a:{{config('stats.STATS')['PUB_N'][8]}},
            b:{{config('stats.STATS')['PUB_VENDU'][8]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
           
        },
        
        { 
            y:'Septembre',
            a:{{config('stats.STATS')['PUB_N'][9]}},
            b:{{config('stats.STATS')['PUB_VENDU'][9]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
          
        },
        
        { 
            y:'Octobre',
            a: {{config('stats.STATS')['PUB_N'][10]}},
            b:{{config('stats.STATS')['PUB_VENDU'][10]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
           
        },
        
        { 
            y:'Novembre',
            a:{{config('stats.STATS')['PUB_N'][11]}},
            b:{{config('stats.STATS')['PUB_VENDU'][11]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
        
        },
        
        { 
            y:'Décembre',        
            a:{{config('stats.STATS')['PUB_N'][12]}},
            b:{{config('stats.STATS')['PUB_VENDU'][12]}},            
            c:{{config('stats.STATS')['PUB_ACH']}},
            
        },
    ],
        xkey: 'y',
        ykeys: ['a', 'b','c'],
        labels: ['Encaissé','Vendu','Acheté',],
        barColors:['#6eff1a','#0ad2ff', '#ff1a1a', ],
        hideHover: 'auto',
        gridLineColor: '#eef0f2',
        resize: true
    });
 });    
</script>

<script>

$(document).ready(function() {
	"use strict";
	
    var sparklineLogin = function() {

        $('#sparkline11').sparkline([{{config('stats.STATS')['TOTAL_PUB_N']}}, {{config('stats.STATS')['TOTAL_PUB_ACH']}}], {
            type: 'pie',
            height: '300',
            resize: true,
            sliceColors: ['#6eff1a', '#ff1a1a']
        });
        
    }
    var sparkResize;

    $(window).resize(function(e) {
        clearTimeout(sparkResize);
        sparkResize = setTimeout(sparklineLogin, 500);
    });
    sparklineLogin();

});
</script>
@endif
{{-- ####################### FIN JETONS CONSOMMES ####################### --}}



<script>

    $('#annee').on('change',function(){

    var annee = $('#annee').val();
      window.location.href = "/home/"+annee;
    // console.log( $('#annee').val());
    
    })
</script>
@endsection