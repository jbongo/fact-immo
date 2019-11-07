@extends('layouts.app')


@section('content')




<div class="row">
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="stat-widget-five">
                <div class="stat-icon">
                    <i class="ti-home bg-primary"></i>
                </div>
                <div class="stat-content">
                    <div class="color-primary">Affaires </div>
                    <div class="stat-text">27</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="stat-widget-five">
                <div class="stat-icon">
                    <i class="ti-money bg-success"></i>
                </div>
                <div class="stat-content">
                    <div class=" color-success">Chiffre d'affaires</div>
                    <div class="stat-text">5000</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="stat-widget-five">
                <div class="stat-icon">
                    <i class="ti-user bg-warning"></i>
                </div>
                <div class="stat-content">
                    <div class=" color-primary">Mandataire</div>
                    <div class="stat-text">200</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3 col-md-6 col-sm-6">
        <div class="card">
            <div class="stat-widget-five">
                <div class="stat-icon bg-danger">
                    <i class="ti-sharethis"></i>
                </div>
                <div class="stat-content">
                    <div class="color-primary">Partage</div>
                    <div class="stat-text">6</div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- 
<div class="row">
    <div class="col-md-3">
        <div class="card">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="ti-target f-s-22 color-primary border-primary round-widget"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h4>278</h4>
                    <h6>Aquéreurs potentiels</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="ti-target f-s-22 color-warning border-warning round-widget"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h4>45</h4>
                    <h6>Aquéreurs ayant acheté un bien</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="ti-target f-s-22 color-success border-success round-widget"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h4>458</h4>
                    <h6>Aquéreurs cherchants une maison</h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="media">
                <div class="media-left meida media-middle">
                    <span><i class="ti-target f-s-22 border-danger color-danger round-widget"></i></span>
                </div>
                <div class="media-body media-text-right">
                    <h4>895</h4>
                    <h6>Aquéreurs cherchants un appartement</h6>
                </div>
            </div>
        </div>
    </div>
</div> --}}


<div class="content-wrap">
        <div class="main">
            <div class="container-fluid">
       
                <!-- /# row -->
                <div id="main-content">
                    <div class="row">
                        <!-- column -->
                        
                        <!-- column -->
                      
                        <!-- column -->
                    
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Chiffre d'affaires mensuel 2019</h4>
                                    <div id="morris-bar-chart"></div>
                                </div>
                            </div>
                        </div>
                        <!-- column -->
                        <!-- column -->
                       
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="footer">
                                <p>This dashboard was generated on <span id="date-time"></span> <a href="#" class="page-refresh">Refresh Dashboard</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



@stop
@section('js-content')


<script src="{{ asset('js/lib/morris-chart/raphael-min.js')}}"></script>
<script src="{{ asset('js/lib/morris-chart/morris.js')}}"></script>
<script>

$(function() {
    "use strict";
   
    // Morris bar chart
    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: 'Janvier',
            a: 30000,
          
          
        }, {
            y: 'Février',
            a: 35000,
           
        
        }, {
            y: 'Mars',
            a: 48000,
           
          
        }, {
            y: 'Avril',
            a: 39000,
           
          
        }, {
            y: 'Mai',
            a: 28000,
           
           
        }, {
            y: 'Juillet',
            a: 75000,
           
          
        }, {
            y: 'Aout',
            a: 60000,
        }, {
            y: 'Septembre',
            a: 56000,
        }
        , {
            y: 'Octobre',
            a: 10000,
        }, {
            y: 'Novembre',
            a: 0,
        }, {
            y: 'Décembre',
            a: 0,
        }
    ],
        xkey: 'y',
        ykeys: ['a' ],
        labels: ['Chiffre Affaires', ],
        barColors: ['#55ce63', '#8b67c9', '#009efb'],
        hideHover: 'auto',
        gridLineColor: '#eef0f2',
        resize: true
    });
});
</script>
@endsection