@extends('layouts.app')
@section('content')
    @section ('page_title')
    Factures Pub à valider
    @endsection
    <div class="row"> 
       
        <div class="col-lg-12">
                @if (session('ok'))
       
                <div class="alert alert-success alert-dismissible fade in">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <a href="#" class="alert-link"><strong> {{ session('ok') }}</strong></a> 
                </div>
             @endif       
                           <!-- table -->
                
                           <div class="card-body">
                            <div class="panel panel-default m-t-15" id="cont">
                                    <div class="panel-heading"></div>
                                    <div class="panel-body">
    
    
    <form action="">
    
    
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6">
            <label for="selection">Tout Sélectionner</label>
            <input type="checkbox" class="selection_parent" name="selection" id="selection">
        
        
            {{-- <label for="action">Action</label> --}}
    
            <select class="" style="padding: 6px 12px; height: 32px;" name="action" id="action">
               <option value="1">Valider les factures</option>
               <option value="2">Refuser les factures</option>
               
            </select>
            
            <input class="btn btn-danger"  type="submit" value="Valider" id="valider_selection">
        </div>
    </div>
    
    <br>
    <hr><br>
    </form>
    
  
    
    
                            <div class="table-responsive" >
                                <table  id="example1" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
                                    <thead>
                                        <tr>
                                           
                                
                                            <th>@lang('Sélection')</th>
                                            <th>@lang('Mandataire')</th>
                                    
                                            {{-- <th>@lang('Type Facture')</th> --}}
                                            <th>@lang('Pack ')</th>
                                            <th>@lang('Montant HT ')</th>
                                            <th>@lang('Montant TTC ')</th>
                                            <th>@lang('Pour le mois de')</th>
                                           
                                            <th>@lang('Recalculer les montants')</th>
                                            <th>@lang('Action')</th>
                                         
    
                                        </tr>
                                    </thead>
                                    {{-- {{dd($today60)}} --}}
                                    @php 
                                    
                                        $mois = Array('','Janvier','Février','Mars','Avril', 'Mai','Juin','Juillet','Aôut', 'Septembre','Octobre','Novembre','Décembre');
                                    @endphp
                                    <tbody>
                                        @foreach ($factures as $facture)
                                            
                                        
                                            <tr>
                                                
                                              <td><input class="selection_child" type="checkbox" id="{{$facture->id}}" class="form-control"></td>
                                          
                                                <td width="" >
                                                    <label class="color-info">
                                                        @if($facture->user !=null)
                                                        <a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>  
                                                        @endif
                                                    </label> 
                                                </td>
                                            
                                                <td  width="" >
                                                    {{$facture->user->contrat->packpub->nom}}
                                                </td>
                                               
                                                <td  width="" >
                                                {{number_format($facture->montant_ht,'2','.','')}}
                                                </td>
                                                <td  width="" >
                                                {{number_format($facture->montant_ttc,'2','.','')}}
                                                </td>
                                                
                                                <td  width="" >
                                                   <span class="badge badge-warning"> {{ $mois[$facture->created_at->format('m')*1]}}</span> 
                                                </td>
                                                <td>
                                                    <a href="{{route('facture.recalculer_fact_pub', [$facture->id])}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="valider"><i class="ti-reload"></i> &nbsp;</a>
                                                
                                                </td>
                                                
                                                <td width="" >
                                                  
                                                     <a href="{{route('facture.valider_fact_pub', [$facture->id,1])}}"  target="_blank"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 valider " id="visualiser"><i class="ti-check"></i>valider</a>
                                                    <a href="{{route('facture.valider_fact_pub', [$facture->id,2])}}"  target="_blank"  class="btn btn-danger btn-flat btn-addon  m-b-10 m-l-5 refuser" id="visualiser"><i class="ti-close"></i>refuser</a> 
                                                
                                                </td> 
                                        
                                    
                                            </tr>
                                      
                                            
                                   
                                @endforeach
                                  </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
    
                </div>
                    <!-- end table -->
            </div>
        </div>
    </div>
@endsection

@section('js-content')
<script>
        $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('a.valider').click(function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
})

        swalWithBootstrapButtons({
            title: '@lang('Vraiment valider la facture ?')',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: '@lang('Oui')',
            cancelButtonText: '@lang('Non')',
            
        }).then((result) => {
            if (result.value) {
                $('[data-toggle="tooltip"]').tooltip('hide')
                    $.ajax({                        
                        url: that.attr('href'),
                        type: 'GET'
                    })
                    .done(function (data) {
                                        
                    that.parents('tr').remove();
                    var url = "/factures/generer-fact-pub/"+data;
                    window.open(url, '_blank');
                    // window.location.href = "/factures/generer-fact-pub/"+data;
                    })

                swalWithBootstrapButtons(
                'Validée!',
                'La facture a bien été validée.',
                'success'
                )
                
                
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Annulé',
                'Facture non validée:)',
                'error'
                )
            }
        })
            })
        });
        
        
        
        
        $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('a.refuser').click(function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
})

        swalWithBootstrapButtons({
            title: '@lang('Vraiment refuser la facture ?')',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: '@lang('Oui')',
            cancelButtonText: '@lang('Non')',
            
        }).then((result) => {
            if (result.value) {
                $('[data-toggle="tooltip"]').tooltip('hide')
                    $.ajax({                        
                        url: that.attr('href'),
                        type: 'GET'
                    })
                    .done(function (data) {
                                        
                    that.parents('tr').remove()
                    window.location.href = "/factures/generer-fact-pub/"+data;
                    })

                swalWithBootstrapButtons(
                'Refusée!',
                'La facture a été refusée.',
                'success'
                )
                
                
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Annulé',
                'Facture non refusée:)',
                'error'
                )
            }
        })
            })
        })
        
        
        
    </script>
    
    
    {{-- SELECTION DESELECTION --}}
    
    
    <script>
    
    $('.selection_parent').click(function(e){
    
    
        if($('.selection_parent').is(':checked')){
        
            $('.selection_child').prop('checked',true);
        
        }else{
            $('.selection_child').prop('checked',false);
        
        
        }
    
    });
    
    
    
    
    
    
    
    // Validation des Factures sélecctionnées
    
    
    $(function() {
            $.ajaxSetup({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
            })
            $('[data-toggle="tooltip"]').tooltip()
            $('#valider_selection').click(function(e) {
            
                var validation = $('#action').val();
                
                var type_validation = validation == 1 ?  "valider" : "refuser"; 
                
                
         
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
                        confirmButtonClass: 'btn btn-success',
                        cancelButtonClass: 'btn btn-danger',
                        buttonsStyling: false,
                    });

                swalWithBootstrapButtons({
                    title: 'Voulez-Vous '+type_validation+' les factures sélectionnées  ?',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#DD6B55',
                    confirmButtonText: '@lang('Oui')',
                    cancelButtonText: '@lang('Non')',
                    
                }).then((result) => {
                    if (result.value) {
                        $('[data-toggle="tooltip"]').tooltip('hide')
                        
                        
                        datas = Array();       
                
                        $('.selection_child').map(function(){
                            
                            if( this.checked == true){
                                datas.push(this.id)
                                return this.id;
                            }
                          
                        })
                        
                        
                        datas = {'list_id':datas};
                        // datas = JSON.stringify(datas);
                        
                        
                      
                        
                            $.ajax({                        
                                url: "/factures/valider-facts-pub/plusieurs/"+validation,
                                data: datas,
                                type: 'GET'
                            })
                            .done(function (data) {
                                                
                           
                            window.location.href = "/factures/pub-a-valider/";
                            })

                
                
                
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Annulé',
                'Annulation:)',
                'error'
                )
            }
        })
            })
        });
        
        
   
    
    </script>
@endsection