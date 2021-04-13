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
    
                            <div class="table-responsive" >
                                <table  id="example1" class=" table student-data-table  table-striped table-hover dt-responsive display    "  style="width:100%"  >
                                    <thead>
                                        <tr>
                                           
                                
                                            <th>@lang('Mandataire')</th>
                                    
                                            {{-- <th>@lang('Type Facture')</th> --}}
                                            <th>@lang('Pack ')</th>
                                            <th>@lang('Montant HT ')</th>
                                            <th>@lang('Montant TTC ')</th>
                                           
                                            <th>@lang('Action')</th>
                                         
    
                                        </tr>
                                    </thead>
                                    {{-- {{dd($today60)}} --}}
                                    <tbody>
                                        @foreach ($factures as $facture)
                                            
                                        
                                            <tr>
                                                
                                              
                                          
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
                                               
                                                
                                                <td width="" >
                                                  
                                                     <a href="{{route('compromis.etat', Crypt::encrypt($facture->id))}}"  target="_blank"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 " id="visualiser"><i class="ti-check"></i>valider</a>
                                                    <a href="{{route('compromis.etat', Crypt::encrypt($facture->id))}}"  target="_blank"  class="btn btn-danger btn-flat btn-addon  m-b-10 m-l-5 " id="visualiser"><i class="ti-close"></i>réfuser</a> 
                                                
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
            $('a.delete').click(function(e) {
                let that = $(this)
                e.preventDefault()
                const swalWithBootstrapButtons = swal.mixin({
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
})

        swalWithBootstrapButtons({
            title: '@lang('Vraiment archiver cet compromis  ?')',
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
                        type: 'PUT'
                    })
                    .done(function () {
                            that.parents('tr').remove()
                    })

                swalWithBootstrapButtons(
                'Archivé!',
                'L\'compromis a bien été archivé.',
                'success'
                )
                
                
            } else if (
                // Read more about handling dismissals
                result.dismiss === swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons(
                'Annulé',
                'L\'utlisateur n\'a pas été archivé :)',
                'error'
                )
            }
        })
            })
        })
    </script>
@endsection