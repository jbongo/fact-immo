@extends('layouts.app')
@section('content')
    @section ('page_title')
    Affaires {{$compromis->numero_mandat}}
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
            @if (Auth()->user()->role == "mandataire")
                <a href="{{route('compromis.create')}}" class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i class="ti-user"></i>@lang('Nouvelle affaire')</a>
            <br><br>
            @endif
                <!-- table -->
                

            <div class="row">

                <div class="col-lg-6">
                    <div class="card alert">
                        <div class="card-header">
                            <h4 class="m-l-5">Infos Affaire</h4>
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
                                            <div class="stats-digit">{{$compromis->numero_mandat}}</div>
                                            <div class="stats-text">Mandat</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 border-bottom border-left">
                                        <div class="stats-content">
                                            <div class="stats-digit">{{$compromis->date_mandat->format('d/m/yy')}}</div>
                                            <div class="stats-text">Date Mandat</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 border-bottom border-left border-right">
                                        <div class="stats-content">
                                            <div class="stats-digit">{{$compromis->date_vente->format('d/m/yy')}}</div>
                                            <div class="stats-text">Date vente</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 ">
                                        <div class="stats-content">
                                            <div class="stats-digit">@if($compromis->est_partage_agent == true) Oui @else Non @endif</div>
                                            <div class="stats-text">Partagée</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 border-left">
                                        <div class="stats-content">
                                            <div class="stats-digit">{{$compromis->type_affaire}}</div>
                                            <div class="stats-text">Type</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 border-left border-right">
                                        <div class="stats-content">
                                            <div class="stats-digit">{{$compromis->net_vendeur}}</div>
                                            <div class="stats-text">Net Vendeur</div>
                                        </div>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card alert">
                        <div class="card-header">
                            <h4 class="m-l-5">Infos Facture STYL'IMMO</h4>
                            
                        </div>
                        <div class="card-body">
                            <div class="media-stats-content text-center">
                                @if($compromis->getFactureStylimmo() != null)
                                <div class="row">
                                    <div class="col-lg-4 border-bottom border-left">
                                        <div class="stats-content">
                                            <div class="stats-digit">{{$compromis->getFactureStylimmo()->numero}}</div>
                                            <div class="stats-text">Numéro</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 border-bottom border-left">
                                        <div class="stats-content">
                                            <div class="stats-digit">{{$compromis->getFactureStylimmo()->montant_ht}}</div>
                                            <div class="stats-text">Montant HT</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 border-bottom border-left">
                                        <div class="stats-content">
                                            <div class="stats-digit">{{$compromis->getFactureStylimmo()->montant_ttc}}</div>
                                            <div class="stats-text">Montant TTC</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 border-right  border-left ">
                                        <div class="stats-content">
                                            <div class="stats-digit">@if($compromis->getFactureStylimmo()->date_encaissement != null) {{$compromis->getFactureStylimmo()->date_encaissement->format('d/m/yy')}} @else Non encaissée @endif</div>
                                            <div class="stats-text">Date Encaissement</div>
                                        </div>
                                    </div>
                                  
                                   
                                </div>

                                @endif
                            </div>
                        </div>
                    </div>
                </div>

            </div>
<br>
            <hr>
          







            <div class="row">


                <div class="col-lg-8">
                    <div class="col-md-6">
                   
                        <div class="card">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-bag f-s-22 color-danger border-danger round-widget"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h4>Etat financier</h4>
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
                                            <th>#</th>
                                            <th><strong>Montant HT </strong></th>
                                            <th>TVA </th>
                                            <th>Réglée </th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Honoraire porteur</td>
                                            <td> @if($compromis->getHonoPorteur() != null )

                                                <span> {{number_format($compromis->getHonoPorteur()->montant_ht,'2','.',' ')}}  € </span> 

                                                @else 
                                                    <span class="color-warning">{{number_format($compromis->getFactureHonoProvi()['montant_ht'],'2','.',' ')}} €</span>
                                                @endif
                                            </td>

                                            <td> @if($compromis->getHonoPorteur() != null )

                                                <span> @if ($compromis->getHonoPorteur()->montant_ttc > 0) {{number_format($compromis->getHonoPorteur()->montant_ht * 0.2,'2','.',' ')}} @else 0  @endif € </span> 

                                                @else 
                                                    <span class="color-warning">{{number_format($compromis->getFactureHonoProvi()['montant_tva'],'2','.',' ')}} €</span>
                                                @endif
                                            </td>

                                            <td> 
                                                @if($compromis->getHonoPorteur() != null )

                                                    <span>@if ($compromis->getHonoPorteur()->reglee == true ) OUI @else NON @endif  </span> 

                                                @else 
                                                    <span>NON </span> 
                                                    
                                                @endif
                                            </td>

                                            
                                        </tr>

                                        <tr>
                                            <td>Honoraire partage</td>
                                            <td>
                                                @if($compromis->getHonoPartage() != null )

                                                <span> {{number_format($compromis->getHonoPartage()->montant_ht,'2','.',' ')}} € </span> 

                                                @else 
                                                    <span class="color-warning">{{number_format($compromis->getFactureHonoPartageProvi()['montant_ht'],'2','.',' ')}} €</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($compromis->getHonoPartage() != null )

                                                <span>  @if ($compromis->getHonoPartage()->montant_ttc > 0) {{number_format($compromis->getHonoPartage()->montant_ht * 0.2,'2','.',' ')}} @else 0  @endif € </span> 

                                                @else 
                                                    <span class="color-warning">{{number_format($compromis->getFactureHonoPartageProvi()['montant_tva'],'2','.',' ')}} €</span>
                                                @endif
                                            </td>

                                            <td> 
                                                @if($compromis->getHonoPartage() != null )

                                                    <span>@if ($compromis->getHonoPartage()->reglee == true ) OUI @else NON @endif  </span> 

                                                @else 
                                                    <span>NON </span> 
                                                    
                                                @endif
                                            
                                            </td>
                                       
                                        </tr>
                                        <tr>
                                            <td>Parrainnage porteur</td>
                                            <td> 
                                                @if($parrainPorteur != null ) 

                                                    @if($compromis->getFactureParrainPorteur() != null )

                                                    <span> {{number_format($compromis->getFactureParrainPorteur()->montant_ht,'2','.',' ')}}  €</span> 

                                                    @else 
                                                        <span class="color-warning">{{number_format($compromis->getFactureParrainPorteurProvi()['montant_ht'],'2','.',' ')}} €</span>
                                                    @endif
                                            
                                            
                                                @else <span class="color-warning">0 € </span>
                                                
                                                @endif 
                                            </td>
                                            <td>  
                                                @if($parrainPorteur != null ) 

                                                    @if($compromis->getFactureParrainPorteur() != null )

                                                    <span>@if ($compromis->getFactureParrainPorteur()->montant_ttc > 0) {{number_format($compromis->getFactureParrainPorteur()->montant_ht * 0.2,'2','.',' ')}} @else 0  @endif €</span> 

                                                    @else 
                                                        <span class="color-warning">{{number_format($compromis->getFactureParrainPorteurProvi()['montant_tva'],'2','.',' ')}} €</span>
                                                    @endif
                                            
                                            
                                                @else <span class="color-warning"> 0 € </span>
                                                
                                                @endif
                                            </td>
                                            <td>
                                                @if($parrainPorteur != null ) 

                                                    @if($compromis->getFactureParrainPorteur() != null )

                                                        <span>@if ($compromis->getFactureParrainPorteur()->reglee == true ) OUI @else NON @endif  </span> 
                                                    @else 
                                                        <span >NON</span>
                                                    @endif
                                            
                                            
                                                @else <span > NON </span>
                                                
                                                @endif
                                            </td>                                              
                                        </tr>
                                        <tr>
                                            <td>Parrainnage partage</td>
                                            <td> 
                                                @if($parrainPartage != null ) 

                                                    @if($compromis->getFactureParrainPartage() != null )

                                                    <span> {{number_format($compromis->getFactureParrainPartage()->montant_ht,'2','.',' ')}}  €</span> 

                                                    @else 
                                                        <span class="color-warning">{{number_format($compromis->getFactureParrainPartageProvi()['montant_ht'],'2','.',' ')}} €</span>
                                                    @endif
                                            
                                            
                                                @else <span class="color-warning">0 € </span>
                                                
                                                @endif 
                                            </td>
                                            <td>  
                                                @if($parrainPartage != null ) 

                                                    @if($compromis->getFactureParrainPartage() != null )

                                                    <span>@if ($compromis->getFactureParrainPartage()->montant_ttc > 0) {{number_format($compromis->getFactureParrainPartage()->montant_ht * 0.2,'2','.',' ')}} @else 0  @endif €</span> 


                                                    @else 
                                                        <span class="color-warning">{{number_format($compromis->getFactureParrainPartageProvi()['montant_tva'],'2','.',' ')}} €</span>
                                                    @endif
                                            
                                            
                                                @else <span class="color-warning"> 0 € </span>
                                                
                                                @endif
                                            </td>
                                            <td>
                                                @if($parrainPartage != null ) 

                                                    @if($compromis->getFactureParrainPartage() != null )

                                                        <span>@if ($compromis->getFactureParrainPartage()->reglee == true ) OUI @else NON @endif  </span> 
                                                    @else 
                                                        <span >NON</span>
                                                    @endif
                                            
                                            
                                                @else <span > NON </span>
                                                
                                                @endif
                                            </td>                        
                                        </tr>

                                   
                                        <tr>
                                            <td>TOTAL DU</td>
                                            <td> <span class="color-default" style="font-size: 25px"> <strong> {{number_format($compromis->total_du()['total_ht'] ,'2','.',' ')}} €  </strong></span></td>
                                            <td> <span class="color-default" style="font-size: 25px"> <strong> {{ number_format($compromis->total_du()['total_tva'],'2','.',' ')}} €  </strong></span></td>
                                            <td></td>
                                                             
                                        </tr>
                                        <tr>
                                            <td>ENCAISSE STYL'IMMO</td>
                                            <td> <span class="color-primary" style="font-size: 25px"> <strong>  {{number_format($compromis->getFactureStylimmo()->montant_ht,'2','.',' ') }} €</strong></span></td>
                                            <td> <span class="color-primary" style="font-size: 25px"> <strong>  {{number_format($compromis->getFactureStylimmo()->montant_ht * 0.2 ,'2','.',' ') }} €</strong></span></td>
                                            <td></td>
                                                             
                                        </tr>
                                        <tr>
                                            <td>RESTE A REGLER</td>
                                            <td> <span class="color-danger" style="font-size: 25px"> <strong> {{number_format($compromis->reste_a_regler() ,2)}} €  </strong></span></td>
                                            <td> <span class="color-danger" style="font-size: 25px"> <strong> {{number_format($compromis->getFactureStylimmo()->montant_ht * 0.2   - $compromis->total_du()['total_tva'] ,'2','.',' ')}} € </strong></span></td>
                                            <td></td>
                                                             
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>



<br>
<br>
<hr><br>

            <div class="row">


                <div class="col-lg-6">
                    <div class="col-md-6">
                   
                        <div class="card">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-bag f-s-22 color-danger border-danger round-widget"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h4>Le Porteur d'affaires</h4>
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
                                            <th>#</th>
                                            <th><strong> Honoraire @if($compromis->getHonoPorteur() == null)  <span class="color-danger">provisoire</span> @endif</strong></th>
                                            <th>Parrainnage </th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Mandataire</td>
                                            <td>{{$compromis->user->nom }} {{$compromis->user->prenom }}</td>
                                            <td> @if($parrainPorteur != null ) {{$parrainPorteur->nom }} {{$parrainPorteur->prenom }} @else <span class="color-warning">Pas de parrain </span> @endif </td>

                                            
                                        </tr>

                                        <tr>
                                            <td><strong> Facture </strong></td>
                                            <td>
                                                @if($compromis->getHonoPorteur() != null )
                                                        <a class="color-info" title="Télécharger" href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($compromis->getHonoPorteur()->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$compromis->getHonoPorteur()->numero}}  <i class="ti-download"></i> </a>

                                                @else 
                                                    <span class="color-warning">Non ajoutée</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($parrainPorteur != null ) 

                                                    @if($compromis->getFactureParrainPorteur() != null )
                                                        <a class="color-info" title="Télécharger" href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($compromis->getFactureParrainPorteur()->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$compromis->getFactureParrainPorteur()->numero}}  <i class="ti-download"></i> </a>

                                                    @else 
                                                        <span class="color-warning">Non ajoutée</span>
                                                    @endif
                                                
                                                
                                                @else <span class="color-warning">Pas de parrain </span>
                                                
                                                @endif 
                                            </td>
                                       
                                        </tr>
                                        <tr>
                                            <td><strong> Règlement </strong></td>
                                            <td>
                                                @if($compromis->getHonoPorteur() != null )
                                                   
                                                    @if($compromis->getHonoPorteur()->date_reglement != null )    
                                                        le {{$compromis->getHonoPorteur()->date_reglement->format('d/m/yy') }} 
                                                    @else 
                                                        Non reglée
                                                    @endif

                                                @else 
                                                    <span class="color-warning">Non ajoutée</span>
                                                @endif

                                            </td>
                                            <td>
                                                @if($parrainPorteur != null ) 

                                                    @if($compromis->getFactureParrainPorteur() != null )

                                                        @if($compromis->getFactureParrainPorteur()->reglee == true)  <span> réglée le {{$compromis->getFactureParrainPorteur()->date_reglement->format('d/m/yy')}} </span> @else  <span class="">Non réglée </span> @endif

                                                    @else 
                                                        <span class="color-warning">Non ajoutée</span>
                                                    @endif
                                            
                                            
                                                @else <span class="color-warning">Pas de parrain </span>
                                                
                                                @endif 

                                            </td>
                                        </tr>
                                        <tr>
                                            <td><strong> Montant HT </strong></td>
                                            <td>
                                                @if($compromis->getHonoPorteur() != null )

                                                <span> {{number_format($compromis->getHonoPorteur()->montant_ht,'2','.',' ')}} € </span> 

                                                @else 
                                                    <span class="color-warning">{{number_format($compromis->getFactureHonoProvi()['montant_ht'],'2','.',' ')}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($parrainPorteur != null ) 

                                                    @if($compromis->getFactureParrainPorteur() != null )

                                                    <span> {{number_format($compromis->getFactureParrainPorteur()->montant_ht,'2','.',' ')}}  €</span> 

                                                    @else 
                                                        <span class="color-warning">{{number_format($compromis->getFactureParrainPorteurProvi()['montant_ht'],'2','.',' ')}}</span>
                                                    @endif
                                            
                                            
                                                @else <span class="color-warning">Pas de parrain </span>
                                                
                                                @endif 
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>









                <div class="col-lg-6">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="media">
                                <div class="media-left meida media-middle">
                                    <span><i class="ti-sharethis f-s-22 color-primary border-primary round-widget"></i></span>
                                </div>
                                <div class="media-body media-text-right">
                                    <h4> Le Partage</h4>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card alert">
                        <div class="card-body">
                            @if($compromis->est_partage_agent == true)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Honoraire @if($compromis->getHonoPartage() == null)  <span class="color-danger">provisoire</span> @endif</th>
                                            <th>Parrainnage  </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Mandataire</td>
                                            <td>{{$compromis->getPartage()->nom }} {{$compromis->getPartage()->prenom }}</td>
                                            <td> @if($parrainPartage != null ) {{$parrainPartage->nom }} {{$parrainPartage->prenom }} @else <span class="color-warning">Pas de parrain @endif</span> </td>
                                        </tr>
                                        <tr>
                                            <td>Facture</td>
                                            <td>
                                                @if($compromis->getHonoPartage() != null )
                                                    <a class="color-info" title="Télécharger" href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($compromis->getHonoPartage()->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$compromis->getHonoPartage()->numero}}  <i class="ti-download"></i> </a>

                                                @else 
                                                    <span class="color-warning">Non ajoutée</span>
                                                @endif
                                            </td>
                                            <td>@if($parrainPartage != null ) 

                                                @if($compromis->getFactureParrainPartage() != null )
                                                    <a class="color-info" title="Télécharger" href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($compromis->getFactureParrainPartage()->id))}}"  class="  m-b-10 m-l-5 " id="ajouter">{{$compromis->getFactureParrainPartage()->numero}}  <i class="ti-download"></i> </a>

                                                @else 
                                                    <span class="color-warning">Non ajoutée</span>
                                                @endif
                                            
                                            
                                            @else <span class="color-warning">Pas de parrain </span>
                                            
                                            @endif </td>
                                       
                                        </tr>
                                        <tr>
                                            <td>Règlement</td>
                                            <td>
                                                @if($compromis->getHonoPartage() != null )
                                                   
                                                    @if($compromis->getHonoPartage()->date_reglement != null )    
                                                        le {{$compromis->getHonoPartage()->date_reglement->format('d/m/yy') }} 
                                                    @else 
                                                        Non reglée
                                                    @endif

                                                @else 
                                                    <span class="color-warning">Non ajoutée</span>
                                                @endif

                                            </td>
                                            <td>
                                                @if($parrainPartage != null ) 

                                                @if($compromis->getFactureParrainPartage() != null )

                                                    @if($compromis->getFactureParrainPartage()->reglee == true)  <span> réglée le {{$compromis->getFactureParrainPartage()->date_reglement->format('d/m/yy')}} </span> @else  <span class="">Non réglée </span> @endif

                                                @else 
                                                    <span class="color-warning">Non ajoutée</span>
                                                @endif
                                            
                                            
                                            @else <span class="color-warning">Pas de parrain </span>
                                            
                                            @endif 
                                        </td>
                                        </tr>
                                        <tr>
                                            <td>Montant HT</td>
                                            <td>
                                                @if($compromis->getHonoPartage() != null )

                                                <span> {{number_format($compromis->getHonoPartage()->montant_ht,'2','.',' ')}} € </span> 

                                                @else 
                                                    <span class="color-warning">{{number_format($compromis->getFactureHonoPartageProvi()['montant_ht'],'2','.',' ')}}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($parrainPartage != null ) 

                                                    @if($compromis->getFactureParrainPartage() != null )

                                                    <span> {{number_format($compromis->getFactureParrainPartage()->date_reglement->montant_ht,'2','.',' ')}} </span> 

                                                    @else 
                                                    <span class="color-warning">{{number_format($compromis->getFactureParrainPartageProvi()['montant_ht'],'2','.',' ')}}</span>
                                                @endif
                                            
                                            
                                                @else <span class="color-warning">Pas de parrain </span>
                                                
                                                @endif 
                                            </td>
                                        </tr>
                                       
                                    </tbody>
                                </table>
                            </div>
                            @else 

                                <span class="color-warning"> <strong>  Affaire non partagée</strong></span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            RESTE A REGLER

            </div>
        </div>

    </div>
@endsection
@section('js-content')

@endsection