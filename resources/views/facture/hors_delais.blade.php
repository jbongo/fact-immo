@extends('layouts.app')
@section('content')
    @section ('page_title')
    Factures Hors délais
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
                                           
                                            <th>@lang('Facture Stylimmo')</th>
                                            <th>@lang('Mandat')</th>
                                            <th>@lang('Charge')</th>
                                            @if(auth()->user()->role == "admin")
                                            <th>@lang('Mandataire')</th>
                                            @endif
                                            {{-- <th>@lang('Type Facture')</th> --}}
                                            <th>@lang('Montant HT ')</th>
                                            <th>@lang('Montant TTC ')</th>
                                            {{-- <th>@lang('Date Facture')</th> --}}
                                            <th>@lang('Date de l\'acte')</th>
                                            {{-- @if(auth()->user()->role == "admin") --}}
                                            <th>@lang('Alerte paiement')</th>
                                            @if(auth()->user()->role == "admin")
                                            <th>@lang('Encaissement')</th>
    
                                            <th>@lang('Etat Affaire')</th>
    
                                            @endif
                                            {{-- @endif --}}
                                            {{-- <th>@lang('Télécharger')</th> --}}
                                            <th>@lang('Avoir')</th>
    
                                        </tr>
                                    </thead>
                                    {{-- {{dd($today60)}} --}}
                                    <tbody>
                                        @foreach ($factures as $facture)
                                            
                                            @if($facture->compromis->date_vente->format('Y-m-d') < $today60)
                                            <tr>
                                                <td width="" >
                                                   @if($facture->type != "avoir")
                                                        @if($facture->compromis != null)
                                                            
                                                            <a class="color-info" title="Télécharger la facture stylimmo" href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->getFactureStylimmo()->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  <i class="ti-download"></i> </a>
                                                        @else 
                                                            <a class="color-info" title="Télécharger " href="{{route('facture.telecharger_pdf_facture_autre', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}}  <i class="ti-download"></i> </a>
        
                                                        @endif
                                                    @else 
                                                    <a class="color-info" title="Télécharger la facture d'avoir" href="{{route('facture.telecharger_pdf_avoir', Crypt::encrypt($facture->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$facture->numero}} <i class="ti-download"></i> AV</a>
        
                                                    @endif
                                                </td>
                                                <td width="" >
                                                    {{-- <label class="color-info">{{$facture->compromis->numero_mandat}} </label>  --}}
                                                    @if($facture->compromis != null)
                                                         <label class="color-info"><a href="{{route('compromis.show',Crypt::encrypt($facture->compromis->id) )}}" target="_blank" title="@lang('voir l\'affaire  ') ">{{$facture->compromis->numero_mandat}}  <i style="font-size: 17px" class="material-icons color-success">account_balance</i></a></label>
                                                    @else 
                                                        <label class="color-danger">{{$facture->type}}  </label>
                                                    @endif
                                                </td>
                                                <td  style="">
        
                                                    @if($facture->compromis != null) 
        
                                                        @if($facture->compromis->charge == "Vendeur")
                                                            <strong>{{ substr($facture->compromis->nom_vendeur,0,20)}}</strong> 
                                                        @else
                                                            <strong>{{ substr($facture->compromis->nom_acquereur,0,20)}}</strong> 
                                                        @endif   
                                                    @endif
                                                </td>
                                                @if(auth()->user()->role == "admin")
                                                <td width="" >
                                                    <label class="color-info">
                                                        @if($facture->user !=null)
                                                        <a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>  
                                                        @endif
                                                    </label> 
                                                </td>
                                                @endif
                                                {{-- <td width="" >
                                                    <label class="color-info">{{$facture->type}} </label> 
                                                </td> --}}
                                                <td  width="" >
                                                {{number_format($facture->montant_ht,'2','.','')}}
                                                </td>
                                                <td  width="" >
                                                {{number_format($facture->montant_ttc,'2','.','')}}
                                                </td>
                                                {{-- <td  width="" class="color-info">
                                                        {{$facture->created_at->format('d/m/Y')}}
                                                </td> --}}
                                                {{-- @if($facture->type == "stylimmo") --}}
                                                <td width="" >
                                                    @if($facture->compromis != null)
                                                        <label class="color-info">
                                                            {{$facture->compromis->date_vente->format('d/m/Y')}} 
                                                        </label> 
                                                    @endif
                                                </td>
        
                                                {{-- @else 
                                                <td width="" style="background-color:#DCD6E1" >
                                                    
                                                </td>
                                                @endif --}}
                                                {{--  alert paiement--}}
                                                @php
                                                 if($facture->compromis != null){
                                                     $interval = strtotime(date('Y-m-d')) - strtotime($facture->compromis->date_vente);
                                                    $diff_jours = $interval / 86400 ;
                                                 }
                                                    
                                                
                                                @endphp
                                               
                                                @if($facture->type == "stylimmo" && $facture->a_avoir == false)
                                                <td width="" >
        
                                                    @if($facture->compromis != null)
                                                        @if( $facture->encaissee == false && $diff_jours < 3)
                                                            <label  style="color:lime">En attente de paiement</label>
                                                        @elseif( $facture->encaissee == false && $diff_jours >=3 && $diff_jours <=6)
                                                            <label  style="background-color:#FFC501">Ho làà  !!!&nbsp;&nbsp;&nbsp;</label>
                                                        @elseif($facture->encaissee == false && $diff_jours >6) 
                                                            <label class="danger" style="background-color:#FF0633;color:white;visibility:visible;">Danger !!! &nbsp;&nbsp;</label>
                                                        @elseif($facture->encaissee == true)
                                                            <label  style="background-color:#EDECE7">En banque  </label>
                                                        @endif
                                                    @endif
                                                </td>
        
                                                @else 
                                                <td width="" style="background-color:#DCD6E1" >
                                                   
                                                </td>
                                                @endif
                                            {{-- fin alert paiement --}}
                                                {{-- encaissement seulement par admin --}}
                                                @if(auth()->user()->role == "admin")
                                                <td width="" >
                                                    {{-- si c'est une facture d'avoir --}}
                                                    @if($facture->type == "avoir")
                                                        <label class="color-danger"> Avoir sur {{$facture->facture_avoir()->numero}}</label> 
                                                    @else
                                                        {{-- Si la facture stylimmo a un avoir --}}
                                                        @if($facture->a_avoir == 1 && $facture->avoir() != null)
                                                            <label class="color-primary"> annulée par AV {{$facture->avoir()->numero}}</label> 
        
                                                        @else
                                                            @if($facture->encaissee == 0)
                                                            <button   data-toggle="modal" data-target="#myModal2" class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 encaisser" onclick="getId({{$facture->id}})"  id="{{$facture->id}}"><i class="ti-wallet"></i>Encaisser</button>
                                                            @else 
                                                            <label class="color-danger"> @if($facture->date_encaissement != null) encaissée le {{$facture->date_encaissement->format('d/m/Y')}} @else encaissée @endif  </label> 
                                                            @endif 
                                                        @endif
        
                                                    @endif
                                                </td>
                                                
                                                <td width="" >
                                                    @if($facture->encaissee == true && $facture->compromis != null )
                                                    <a href="{{route('compromis.etat', Crypt::encrypt($facture->compromis->id))}}"  target="_blank"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="visualiser"><i class="ti-eye"></i>Visualiser</a>
                                                    @endif
                                                </td> 
                                                @endif
                                               {{-- Avoir --}}
                                                <td width="" >
        
                                                    @if($facture->type != "avoir")
                                                        @if($facture->a_avoir == 0 && $facture->encaissee == 0 && $facture->compromis != null && $facture->compromis->cloture_affaire == 0 && auth()->user()->role == "admin") 
        
                                                            <a href="{{route('facture.avoir.create', Crypt::encrypt($facture->id))}}"   class="btn btn-info  btn-flat btn-addon  m-b-10 m-l-5 " id=""><i class="ti-link"></i>créer</a>
        
                                                        @elseif($facture->a_avoir == 0 && $facture->encaissee == 0 && $facture->compromis == null  && auth()->user()->role == "admin") 
        
                                                            <a href="{{route('facture.avoir.create', Crypt::encrypt($facture->id))}}"  class="btn btn-info  btn-flat btn-addon  m-b-10 m-l-5 " id=""><i class="ti-link"></i>créer</a>
                                                        @elseif($facture->a_avoir == 1 && $facture->avoir() != null)
                                                            <a href="{{route('facture.telecharger_pdf_avoir', Crypt::encrypt($facture->avoir()->id))}}"  class="btn btn-danger btn-flat btn-addon m-b-10 m-l-5 " id=""><i class="ti-download"></i>avoir {{$facture->avoir()->numero}}</a>
                                                        @endif
                                                    @endif
                                                </td>
                                            </tr>
                                        @endif
                                            
                                   
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