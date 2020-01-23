
 
                <!-- table -->
                
                <div class="card-body">
                        <div class="panel panel-default m-t-15" id="cont">
                                <div class="panel-heading"></div>
                                <div class="panel-body">

                        <div class="table-responsive" >
                            <table  id="example1" class=" table table-striped table-hover dt-responsive "  >
                                <thead>
                                    <tr>
                                       
                                        <th>@lang('Facture Honoraire')</th>
                                        <th>@lang('Facture Stylimmo')</th>
                                        <th>@lang('Mandat')</th>
                                        @if(auth()->user()->role == "admin")
                                        <th>@lang('Mandataire')</th>
                                        @endif
                                        <th>@lang('Type Facture')</th>
                                        <th>@lang('Montant HT ')</th>
                                        <th>@lang('Montant TTC ')</th>
                                        {{-- <th>@lang('Date Facture')</th> --}}
                                        <th>@lang('Date de l\'acte')</th>
                                        <th>Validation</th>
                                        <th>@lang('Paiement')</th>
                                        <th>@lang('Etat (Fac Stylimmo)')</th>

                                        {{-- @if(auth()->user()->role == "admin")
                                        <th>@lang('Encaissement')</th>
                                        @endif --}}

                                        <th>@lang('Note honoraire')</th>
                                        <th>@lang('Télécharger')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factureHonoraires as $facture)

                                    <tr>
                                        <td  >
                                            @if($facture->staut != "en attente de validation")
                                            <label class="color-info">{{$facture->numero}} </label> 
                                            @endif
                                        </td>
                                        <td  >
                                            {{-- <label class="color-info">{{$facture->compromis->getFactureStylimmo()->numero}} </label>  --}}
                                        <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->id))}}"  class="  m-b-10 m-l-5 " id="ajouter"><label class="color-info">{{$facture->compromis->getFactureStylimmo()->numero}}  <i class="ti-download"></i> </label></a>
                                            
                                        </td>
                                        <td  >
                                           
                                        <label class="color-info"><a href="{{route('compromis.show',Crypt::encrypt($facture->compromis->id) )}}" target="_blank" title="@lang('voir l\'affaire  ') ">{{$facture->compromis->numero_mandat}}  <i style="font-size: 17px" class="material-icons color-success">account_balance</i></a></label>

                                        </td>
                                        @if(auth()->user()->role == "admin")
                                        <td  >
                                            <label class="color-info">
                                                @if($facture->user !=null)
                                                <a href="{{route('switch_user',Crypt::encrypt($facture->user->id) )}}" data-toggle="tooltip" title="@lang('Se connecter en tant que ') {{$facture->user->nom}}">{{$facture->user->nom}} {{$facture->user->prenom}}<i style="font-size: 17px" class="material-icons color-success">person_pin</i></a>   
                                                @endif
                                               
                                            </label> 
                                        </td>
                                        @endif
                                        <td  >
                                            <label class="color-info">{{$facture->type}} </label> 
                                        </td>
                                        <td   >
                                        {{number_format($facture->montant_ht,2,'.',' ')}} €
                                        </td>
                                        <td   >
                                        {{number_format($facture->montant_ttc,2,'.',' ')}} €
                                        </td>
                                        {{-- <td   class="color-info">
                                                {{$facture->created_at->format('d/m/Y')}}
                                        </td> --}}
                                       
                                        <td >
                                            <label class="color-info">
                                                {{$facture->compromis->date_vente->format('d/m/Y')}} 
                                            </label> 
                                        </td>

                                        <td  >
                                            @if($facture->statut == "valide" && $facture->numero != null )
                                                <label class="color-primary" ><strong> Bon à payer</strong> </label>                                            
                                            @elseif($facture->statut == "en attente de validation" && $facture->numero != null) 
                                                <label class="color-default"><strong> En attente de validation </strong></label> 
                                            @elseif($facture->statut == "refuse" && $facture->numero != null) 
                                                <label class="color-success"><strong>Réfusée </strong></label>
                                            @else
                                                <label class="color-danger"><strong>Non valide </strong></label> 

                                            @endif 
                                        </td>

                                        {{--  paiement--}}
                                        @php
                                            $datevente = date_create($facture->compromis->date_vente->format('Y-m-d'));
                                            $today = date_create(date('Y-m-d'));
                                            $interval = date_diff($today, $datevente);
                                        @endphp
                                        {{-- @if($facture->type == "stylimmo") --}}
                                        <td  >
                                            @if($facture->reglee == 0)
                                                @if(auth::user()->role == "admin")
                                                    <button data-toggle="modal" @if($facture->compromis->getFactureStylimmo()->encaissee == 0 )disabled style="background:#bdbdbd" @endif data-target="#myModal" id="{{Crypt::encrypt($facture->id)}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 payer" ><i class="ti-wallet"></i>Payer</button>
                                                @else 
                                                    <label class="color-danger">Non réglée </label> 
                                                @endif
                                            @else 
                                                <label class="color-success">@if($facture->date_reglement != null) Réglée le {{$facture->date_reglement->format('d/m/Y')}} @else Réglée @endif</label> 
                                            @endif 
                                        </td>

                                        <td  >
                                            @if($facture->compromis->getFactureStylimmo()->encaissee == 0 )
                                                <label class="color-danger" ><strong> Non encaissée </strong> </label>                                            
                                            @else 
                                                <label class="color-primary"><strong> Encaissée </strong></label> 
                                            @endif 
                                        </td>
                                        
                                        
                                        <td  >
                                            {{-- @if(auth::user()->role=="admin") --}}
                                            {{-- @if ($facture->compromis->je_porte_affaire == 0  || $facture->compromis->agent_id == auth::user()->id || ($facture->compromis->je_porte_affaire == 1 && $facture->compromis->est_partage_agent == 1) ) --}}
                                                @if ($facture->type == "partage" )
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_partage',[Crypt::encrypt($facture->compromis->id), $facture->user_id ])}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 

                                                @elseif($facture->type == "parrainage")
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage',Crypt::encrypt($facture->compromis->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                
                                                @elseif($facture->type == "parrainage_partage")
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire_parrainage_partage',$facture->compromis->id)}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                @else 
                                                    <a target="blank" href="{{route('facture.preparer_facture_honoraire',Crypt::encrypt($facture->compromis->id))}}" data-toggle="tooltip" title="@lang('Note honoraire  ')"><i class="large material-icons color-danger">insert_drive_file</i></a> 
                                                    
                                                @endif
                                            {{-- @else
                                                <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>

                                            @endif --}}
                                        </td> 

                                        <td width="" >     
                                            @if($facture->url != null)                                       
                                                <a href="{{route('facture.telecharger_pdf_facture', Crypt::encrypt($facture->id))}}"  class=" btn btn-warning btn-flat btn-addon m-b-10 m-l-5 " id="telecharger"><i class="ti-download"></i> Télécharger</a>
                                            @else 
                                                <label class="color-danger" ><strong> Non disponible </strong> </label>                                            
                                            @endif
                                        </td>
                                    </tr> 
                               
                            @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>


{{-- <div class="container"> --}}

        <!-- Trigger the modal with a button -->
        {{-- <button type="button" class="btn btn-info btn-lg" id="myBtn">Open Modal</button> --}}
      
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-sm">
          
            <!-- Modal content-->
            <div class="modal-content col-lg-offset-4  col-md-offset-4 col-sm-offset-4 col-lg-4 col-md-4 col-sm-4">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Date de règlement</h4>
              </div>
              <div class="modal-body">
                <p><form action="" method="get" id="form_regler">
                        <div class="modal-body">
                          
                                <div class="">
                                    <div class="form-group row">
                                        <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_reglement">Date de règlement <span class="text-danger">*</span> </label>
                                        <div class="col-lg-8 col-md-8 col-sm-8">
                                            <input type="date"  class="form-control {{ $errors->has('date_reglement') ? ' is-invalid' : '' }}" value="{{old('date_reglement')}}" id="date_reglement" name="date_reglement" required >
                                            @if ($errors->has('date_reglement'))
                                            <br>
                                            <div class="alert alert-warning ">
                                                <strong>{{$errors->first('date_reglement')}}</strong> 
                                            </div>
                                            @endif   
                                        </div>
                                    </div>
                                </div>
                          </p>
              </div>
              <div class="modal-footer">
                <input type="submit" class="btn btn-success" id="valider_reglement"  value="Valider" />
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              </div>
            </div>
        </form> 
          </div>
        </div>
        
      {{-- </div>               --}}


                </div>
                </div>
            <!-- end table -->
            