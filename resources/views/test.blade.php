@extends('layouts.app')
@section('content')
    @section ('page_title')
    Tests
    @endsection
    
    <style>
    
    *{
        margin: 0 auto;
        padding: 0 auto;
    }
    
        .container{
            display:flex;
            flex-wrap: wrap;
       
            justify-content: space-around;
            
        }
        
        .sous-container{
            flex: 1;
            flex-direction: column;
            align-items: center;
            
            box-shadow: 1px 1px 10px  blue;
            margin: 10px;
            text-align: center;
            
        }
    </style>
    <div class="row"> 
       
        <div class="col-lg-12">
                @if (session('ok'))
       
                <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
                </div>
             @endif       
     
            
            <div class="row">
            
                <div class="container">
                
                    {{-- <div class="sous-container"> --}}
                        
                        <div class="sous-container"> 
                            <div class=""> <img src="{{asset("images/test.jpg")}}" width="300vw" alt=""></div>
                            <div class=""><h1>Montre classique</h1></div>
                            <div class="">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, unde asperiores corrupti doloribus possimus dicta aliquam cumque esse similique iste vitae libero enim dignissimos voluptate. Iure tenetur magnam ex velit.
                            </div>
                        </div>
                        
                        <div class="sous-container"> 
                            <div class=""> <img src="{{asset("images/test.jpg")}}" width="300vw" alt=""></div>

                            <div class=""><h1>Montre Connectée</h1></div>
                            <div class="">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, unde asperiores corrupti doloribus possimus dicta aliquam cumque esse similique iste vitae libero enim dignissimos voluptate. Iure tenetur magnam ex velit.
                            </div>
                        </div>
                        
                        <div class="sous-container"> 
                            <div class=""> <img src="{{asset("images/test.jpg")}}" width="300vw" alt=""></div>
                            <div class=""><h1>Montre Haut de gamme</h1></div>
                            <div class="">
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Ipsam, unde asperiores corrupti doloribus possimus dicta aliquam cumque esse similique iste vitae libero enim dignissimos voluptate. Iure tenetur magnam ex velit.
                            </div>
                        </div>
                    
                    {{-- </div> --}}
                </div>
            </div>
            
    
            
            <!-- END MODAL -->
            
            
            @stop
            
            @section('js-content')
            {{-- TABLEAU DES PLANIFICATIONS --}}
            
            
            
            @endsection