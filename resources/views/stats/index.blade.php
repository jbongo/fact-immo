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


<br>

<div class="row">

    <div class="col-lg-12">
        <div class="card alert">
            <div class="card-header">
                <h4 class="m-l-5">Moyenne des chiffres d'affaires</h4>
                <div class="card-header-right-icon">
                    <ul>
                        <li><i class="ti-reload"></i></li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="media-stats-content text-center">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card alert">
                               
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Janvier</th>
                                                    <th>Février</th>
                                                    <th>Mars</th>
                                                    <th>Avril</th>
                                                    <th>Mai</th>
                                                    <th>Juin</th>
                                                    <th>Juillet</th>
                                                    <th>Août</th>
                                                    <th>Septembre</th>
                                                    <th>Octobre</th>
                                                    <th>Novembre</th>
                                                    <th>Décembre</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row" style="font-size:20px; font-weight: bold;">CA</th> 
                                                    <th scope="row"  style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][0] ,2,'.',',')}} </th> 
                                                    <th scope="row" style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][1] ,2,'.',',')}} </th>                 
                                                    <th scope="row"  style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][2] ,2,'.',',')}} </th>
                                                    <th scope="row"  style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][3] ,2,'.',',')}} </th>
                                                    <th scope="row"  style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][4] ,2,'.',',')}} </th>
                                                    <th scope="row"  style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][5] ,2,'.',',')}} </th>
                                                    <th scope="row"  style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][6] ,2,'.',',')}} </th>
                                                    <th scope="row"  style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][7] ,2,'.',',')}} </th>
                                                    <th scope="row"  style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][8] ,2,'.',',')}} </th>
                                                    <th scope="row"  style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][9] ,2,'.',',')}} </th>
                                                    <th scope="row"  style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][10] ,2,'.',',')}} </th>
                                                    <th scope="row"  style="font-size:18px; color: #7c20c8; font-weight: bold;"> {{number_format( config('stats.STATS')['CA'][11] ,2,'.',',')}} </th>
                                                </tr>
                                                <tr>
                                                    <th scope="row" style="font-size:20px; font-weight: bold;">Moyenne des CA </th> 
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][0] ,2,'.',',')}} </th> 
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][1] ,2,'.',',')}} </th>                 
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][2] ,2,'.',',')}} </th>
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][3] ,2,'.',',')}} </th>
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][4] ,2,'.',',')}} </th>
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][5] ,2,'.',',')}} </th>
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][6] ,2,'.',',')}} </th>
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][7] ,2,'.',',')}} </th>
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][8] ,2,'.',',')}} </th>
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][9] ,2,'.',',')}} </th>
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][10] ,2,'.',',')}} </th>
                                                    <th scope="row" style="font-size:18px; color: #a7275e; font-weight: bold;"> {{number_format( config('stats.STATS')['CA_MOY'][11] ,2,'.',',')}} </th>
                                                </tr>
                                              
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>


{{-- ####################### PUBS CONSOMMES ####################### --}}


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




{{-- #######  STATS ###### --}}

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





























































@stop
@section('js-content')






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
      window.location.href = "/stats/"+annee;
    // console.log( $('#annee').val());
    
    })
</script>
@endsection