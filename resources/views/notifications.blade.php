@extends('layouts.app')
@section('content')
    @section ('page_title')
  Toutes les notifications
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
                

            <div class="row">
                <a id="delete" href="{{route('notification.delete')}}" class="btn btn-danger btn-rounded"> Tout upprimer</a>
<hr>
              
            @foreach ($notifications as $key=>$notification)
            
            <div class="row">
                <div class="alert alert-warning col-md-6 col-lg-6 col-sm-6">
                    <a href="#" class="alert-link">{{$notification->data['message']}}</a>.
               </div>
               <div class="col-md-1 col-lg-1 col-sm-1">
                <a id="{{$notification->id}}" href="{{route('notification.delete', $key)}}"  class="btn btn-pink btn-rounded"> Supprimer</a>
                </div>
            </div>
                   
            @endforeach




<br>
<br>
<hr><br>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js-content')



@endsection