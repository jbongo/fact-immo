
 
                <!-- table -->
                
                <div class="card-body">
                        <div class="panel panel-default m-t-15" id="cont">
                                <div class="panel-heading"></div>
                                <div class="panel-body">

                        <div class="table-responsive" style="overflow-x: inherit !important;">
                            <table  id="example1" class=" table student-data-table  m-t-20 "  style="width:100%">
                                <thead>
                                    <tr>
                                       
                                        <th>@lang('Numéro Honoraire')</th>
                                        <th>@lang('Numéro Stylimmo')</th>
                                        <th>@lang('Numéro Mandat')</th>
                                        @if(auth()->user()->role == "admin")
                                        <th>@lang('Mandataire')</th>
                                        @endif
                                        <th>@lang('Type Facture')</th>
                                        <th>@lang('Montant HT ')</th>
                                        <th>@lang('Montant TTC ')</th>
                                        {{-- <th>@lang('Date Facture')</th> --}}
                                        <th>@lang('Date de l\'acte')</th>
                                        <th>@lang('Paiement')</th>

                                        {{-- @if(auth()->user()->role == "admin")
                                        <th>@lang('Encaissement')</th>
                                        @endif --}}

                                        <th>@lang('Facture')</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($factureHonoraires as $facture)

                                    <tr>
                                        <td width="" >
                                            <label class="color-info">{{$facture->numero}} </label> 
                                        </td>
                                        <td width="" >
                                            <label class="color-info">{{$facture->compromis->getFactureStylimmo()->numero}} </label> 
                                        </td>
                                        <td width="" >
                                            <label class="color-info">{{$facture->compromis->numero_mandat}} </label> 
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
                                        <td width="" >
                                            <label class="color-info">{{$facture->type}} </label> 
                                        </td>
                                        <td  width="" >
                                        {{number_format($facture->montant_ht,2,'.',' ')}}
                                        </td>
                                        <td  width="" >
                                        {{number_format($facture->montant_ttc,2,'.',' ')}}
                                        </td>
                                        {{-- <td  width="" class="color-info">
                                                {{$facture->created_at->format('d/m/Y')}}
                                        </td> --}}
                                       
                                        <td width="" >
                                            <label class="color-info">
                                                {{$facture->compromis->date_vente->format('d/m/Y')}} 
                                            </label> 
                                        </td>

                                        {{--  paiement--}}
                                        @php
                                            $datevente = date_create($facture->compromis->date_vente->format('Y-m-d'));
                                            $today = date_create(date('Y-m-d'));
                                            $interval = date_diff($today, $datevente);
                                        @endphp
                                        {{-- @if($facture->type == "stylimmo") --}}
                                        <td width="" >
                                            @if($facture->reglee == 0)
                                                @if(auth::user()->role == "admin")
                                                    <button data-toggle="modal" data-target="#myModal" id="{{Crypt::encrypt($facture->id)}}"  class="btn btn-success btn-flat btn-addon  m-b-10 m-l-5 payer" ><i class="ti-wallet"></i>Payer</button>
                                                @else 
                                                    <label class="color-danger">Non réglé </label> 
                                                @endif
                                            @else 
                                                <label class="color-success">@if($facture->date_reglement != null) Réglé le {{$facture->date_reglement->format('d-m-Y')}} @else Réglé @endif</label> 
                                            @endif 
                                        </td>

                                        
                                        <td width="" >
                                            @if(auth::user()->role=="admin")
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
                                            @else
                                                <a href="{{route('facture.telecharger_pdf_facture_stylimmo', Crypt::encrypt($facture->compromis->id))}}"  class="btn btn-warning btn-flat btn-addon  m-b-10 m-l-5 " id="ajouter"><i class="ti-download"></i>Télécharger</a>

                                            @endif
                                        </td> 
                                    </tr> 
                               
                            @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>


<div class="container">

        <!-- Trigger the modal with a button -->
        {{-- <button type="button" class="btn btn-info btn-lg" id="myBtn">Open Modal</button> --}}
      
        <!-- Modal -->
        <div class="modal fade" id="myModal" role="dialog">
          <div class="modal-dialog modal-sm">
          
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Date de règlement</h4>
              </div>
              <div class="modal-body">
                <p><form action="" method="get" id="form_regler">
                        <div class="modal-body">
                          
                                <div class="col-lg-offset-2  col-md-offset-2 col-sm-offset-2 col-lg-4 col-md-4 col-sm-4">
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
        
      </div>              


                </div>
                </div>
            <!-- end table -->
            