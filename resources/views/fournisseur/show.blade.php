@extends('layouts.app') 
@section('content') 
@section ('page_title') 
Profil du fournisseur 
@endsection
<style>
   .modal-content {
   border-radius: 50px;
   width: 90%;
   }
</style>
<div class="card">
   <a href="{{route('fournisseur.index')}}" class="btn btn-default btn-flat btn-addon m-b-10 m-l-5"><i class="ti-angle-double-left"></i>@lang('liste des fournisseurs ')</a>
   <a href="{{route('fournisseur.facture.create',Crypt::encrypt($fournisseur->id) )}}"  class="btn btn-danger btn-rounded btn-addon btn-xs m-b-10 m-l-30"><i class="ti-plus"></i>Ajouter Facture</a>
   <a href="{{route('fournisseur.document.create',Crypt::encrypt($fournisseur->id) )}}"  class="btn btn-danger btn-rounded btn-addon btn-xs m-b-10 m-l-30"><i class="ti-plus"></i>Ajouter Document</a>
   
   <div class="card-body">
   
    @if (session('ok'))
    <div class="alert alert-success alert-dismissible fade in" style="color: #000">
       <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
       <strong> {{ session('ok') }}</strong>
    </div>
    @endif      
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default lobipanel-basic">
                   <div class="panel-heading">Fiche fournisseur.</div>
                   <div class="panel-body">
                      <div class="card alert">
                         <div class="card-body">
                            <div class="user-profile">
                               <div class="row">
                                  <div class="col-lg-12">
                                     <div class="user-profile-name" style="color: #d68300;"> {{$fournisseur->nom}} </div>
                                     <a href="{{route('fournisseur.edit',Crypt::encrypt($fournisseur->id) )}}"  class="btn btn-warning btn-rounded btn-addon btn-xs m-b-10"><i class="ti-pencil"></i>Modifier</a>
                                     <div class="custom-tab user-profile-tab">
                                        <ul class="nav nav-tabs" role="tablist">
                                           <li role="presentation" class="active"><a href="#1" aria-controls="1" role="tab" data-toggle="tab">Détails</a></li>
                                        </ul>
                                        <div class="tab-content">
                                           <div role="tabpanel" class="tab-pane active" id="1">
                                              <div class="contact-information">
                                                 <div class="phone-content">
                                                    <span class="contact-title"><strong>Contact 1:</strong></span>
                                                    <span class="phone-number" style="color: #ff435c; text-decoration: underline;">{{$fournisseur->telephone1}}</span>
                                                 </div>
                                                 <div class="phone-content">
                                                    <span class="contact-title"><strong>Contact 2:</strong></span>
                                                    <span class="phone-number" style="color: #ff435c; text-decoration: underline;">{{$fournisseur->telephone2}}</span>
                                                 </div>
                                                 <div class="email-content">
                                                    <span class="contact-title"><strong>Email:</strong></span>
                                                    <span class="contact-email" style="color: #ff435c; text-decoration: underline;">{{$fournisseur->email}}</span>
                                                 </div>
                                                 <div class="website-content">
                                                    <span class="contact-title"><strong>Site web:</strong></span>
                                                    <span class="contact-website">{{$fournisseur->site_web}}</span>
                                                 </div>
                                                 <div class="website-content">
                                                    <span class="contact-title"><strong>Login:</strong></span>
                                                    <span class="contact-website">{{$fournisseur->login}}</span>
                                                 </div>
                                                 <div class="website-content">
                                                    <span class="contact-title"><strong>Mot de passe:</strong></span>
                                                    <span class="contact-website">{{$fournisseur->password}}</span>
                                                 </div>
                                              </div>
                                              <div class="basic-information">
                                                 <div class="gender-content">
                                                    <span class="contact-title"><strong>Date d'ajout:</strong></span>
                                                    <span class="gender">{{date('d-m-Y',strtotime($fournisseur->created_at ))}}</span>
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
                   </div>
                </div>
             </div>
        </div>
   
        
        <div class="row">
            <div class="col-lg-12">
               <hr style="border:2px solid red">
               <div class="row">
               
                  <div class="col-md-12">
                     <div class="card">
                        <div class="media">
                                                
                   
                            <div class="media-left media-middle" >
                                <i class="ti-folder f-s-48 color-danger m-r-20"></i> <label for="" style="font-weight: bold">Contrats</label>
                                <a href="{{route('fournisseur.contrat.create',Crypt::encrypt($fournisseur->id) )}}"  class="btn btn-success btn-rounded btn-addon btn-xs m-b-10 m-l-30"><i class="ti-plus"></i>Ajouter Contrat</a>
                            </div>
                            
                            @foreach ($fournisseur->contrats as $contrat)
                            <div class="row">
                                <div class="col-md-11 col-lg-11 col-sm-11 " style="background: #617f8e; color: white;">
                                        <h4>{{$contrat->libelle}} - {{$contrat->numero_contrat}}  @if($contrat->date_fin != null) **/** Expire le : {{$contrat->date_fin->format('d/m/Y')}} @endif</h4>                          
                                </div>
                                <div class="col-md-1 col-lg-1 col-sm-1"  style="margin-left:-60px;">
                                        <button class="btn btn-dark btn-flat btn-addon" type="button"  onclick="masquerDiv('btn_clic_afficher_contrat_{{$contrat->id}}', 'div_contrat_{{$contrat->id}}' )" id="btn_clic_afficher_contrat_{{$contrat->id}}" style="height: 39px;margin-left:-10px;margin-bottom:10px;"><i  class="ti-minus"></i>&nbsp;</button>
                                </div>        
                            </div>
                            <hr>
                            
                            <div id="div_contrat_{{$contrat->id}}" >
                            
                            
                                <div class="col-lg-5 col-md-5">
                                    <div class="card alert">
                                       <div class="card-body">
                                          <div class="table-responsive">
                                             <table class="table table-hover">
                                                <thead>
                                                   <tr>
                                                        <th>Libellé</th>
                                                        <th>N° contrat</th>
                                                        <th>N° client</th>
                                                        <th>Date Deb</th>
                                                        <th>Date Fin</th>
                                                        <th>Actions</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                   
                                                 <tr>
                                                    <td>{{$contrat->libelle}}</td>
                                                    <td><span class="text-danger" style="font-size: 13px"> {{$contrat->numero_contrat}} </span>  </td>
                                                    <td><span class="text-danger" style="font-size: 13px"> {{$contrat->numero_client}} </span>  </td>
                                                    <td><span class="text-primary" style="font-size: 13px"> @if($contrat->date_deb != null) {{$contrat->date_deb->format('d/m/Y')}} @endif</span>  </td>
                                                    <td><span class="text-primary" style="font-size: 13px"> @if($contrat->date_fin != null) {{$contrat->date_fin->format('d/m/Y')}} @endif</span>  </td>
                                                    <td>
                                                        <span><a href="{{route('fournisseur.contrat.edit',Crypt::encrypt($contrat->id))}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $contrat->libelle }}"><i class="large material-icons color-warning">edit</i></a></span>
                                                        <span><a href="#"  data-href="{{route('fournisseur.contrat.archiver',$contrat->id)}}" class="archiver" data-toggle="tooltip" title="@lang('Archiver ') {{ $contrat->libelle }}"><i class="large material-icons color-danger">delete</i> </a></span>
                                                    </td>
                                                   
                                                 </tr>
                                             
                                                   
                                                </tbody>
                                             </table>
                                             
                                             <div style="text-align: center; margin-bottom:50; margin-top:50px">
                                                    <a data-toggle="modal" data-target="#add-article" data-contrat="{{$contrat->id}}" class="btn btn-danger btn-rounded btn-addon btn-xs m-b-10 m-l-30 add-article"><i class="ti-plus"></i>Ajouter un article au contrat</a>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                </div>
                                
                                
                                <div class="col-lg-7 col-md-7">
                                
                                    <div class="media-left media-middle">
                                        <i class="ti-list f-s-48 color-danger m-r-20"></i> <label for="" style="font-weight: bold">Articles </label> 
                                     </div>                           
                                     <div class="col-lg-12 m-b-70">
                                        <div class="card alert">
                                           <div class="card-body">
                                              <div class="table-responsive">
                                                 <table class="table table-hover">
                                                    <thead>
                                                       <tr>
                                                          <th>Libellé</th>
                                                          <th>Description</th>
                                                          <th>Type</th>
                                                          <th>Quantité</th>
                                                          <th>Prix d'achat</th>
                                                          {{-- <th>Périodicité facturation</th> --}}
                                                          <th>Date d'achat</th>
                                                          <th>Actions</th>
                                                       </tr>
                                                    </thead>
                                                    <tbody>
                                                       @foreach ($contrat->articles as $article)
                                                       @if( $article->archive == false)
                                                           <tr>
                                                                <td>{{$article->libelle}}</td>
                                                                <td><span class="text-danger" style="font-size: 13px"> {{$article->description}} </span>  </td>
                                                                <td><span class="text-danger" style="font-size: 13px"> {{$article->type}} </span>  </td>
                                                                <td><span class="text-danger" style="font-size: 13px"> {{$article->quantite}} </span>  </td>
                                                                <td><span class="text-danger" style="font-size: 13px"> {{$article->prix_achat}} </span>  </td>
                                                                {{-- <td><span class="text-danger" style="font-size: 13px"> {{$article->periodicite_facturation}} </span>  </td> --}}
                                                                <td><span class="text-primary" style="font-size: 13px"> @if($article->date_achat != null) {{$article->date_achat->format('d/m/Y')}} @endif</span>  </td>
                                                                <td>
                                                                    <span><a href="{{route('article.edit',Crypt::encrypt($article->id))}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $article->libelle }}"><i class="large material-icons color-warning">edit</i></a></span>
                                                                    <span><a href="#"  data-href="{{route('article.archiver',$article->id)}}" class="archiver" data-toggle="tooltip" title="@lang('Archiver ') {{ $article->libelle }}"><i class="large material-icons color-danger">delete</i> </a></span>
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
                                     
                                     
                                </div>
                            
                            </div>
                            
                        
                            @endforeach
                        
                        
                        
                            <br><br><br>
                            <hr style="border:2px solid red; margin-top:300px">
                        
                            <br><br><br>
                            
                            
                            
                            <div class="media-left media-middle" >
                              <i class="ti-folder f-s-48 color-danger m-r-20"></i> <label for="" style="font-weight: bold; font-size:20px;">Bons de commande</label>
                              <a href="{{route('fournisseur.commande.create',Crypt::encrypt($fournisseur->id) )}}"  class="btn btn-success btn-rounded btn-addon btn-xs m-b-10 m-l-30"><i class="ti-plus"></i>Ajouter Bon de Commande</a>
                          </div>
                          
                           @foreach ($fournisseur->commandes as $commande)
                              @if($commande->archive != true)
                                 <div class="row">
                                    <div class="col-md-11 col-lg-11 col-sm-11 " style="background: #617f8e; color: white;">
                                            <h4>N° {{$commande->numero_commande}} </h4>                          
                                    </div>
                                    <div class="col-md-1 col-lg-1 col-sm-1"  style="margin-left:-60px;">
                                            <button class="btn btn-dark btn-flat btn-addon" type="button"  onclick="masquerDiv('btn_clic_afficher_contrat_{{$commande->id}}', 'div_contrat_{{$commande->id}}' )" id="btn_clic_afficher_contrat_{{$commande->id}}" style="height: 39px;margin-left:-10px;margin-bottom:10px;"><i  class="ti-minus"></i>&nbsp;</button>
                                    </div>        
                                 </div>
                                <hr>
                                
                                 <div id="div_contrat_{{$commande->id}}" >
                                
                                
                                    <div class="col-lg-5 col-md-5">
                                        <div class="card alert">
                                           <div class="card-body">
                                              <div class="table-responsive">
                                                 <table class="table table-hover">
                                                    <thead>
                                                       <tr>
                                                            <th>Numéro Commande</th>
                                                            <th>Date Commande</th>
                                                            <th>Description</th>
                                                            
                                                            <th>Actions</th>
                                                       </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                       
                                                     <tr>
                                                    
                                                        <td><span class="text-danger" style="font-size: 13px"> {{$commande->numero_commande}} </span>  </td>
                                                      
                                                        <td><span class="text-primary" style="font-size: 13px"> @if($commande->date_commande != null) {{$commande->date_commande->format('d/m/Y')}} @endif</span>  </td>
                                                        <td>{{$commande->description}}</td>
                                                        <td>
                                                            <span><a href="{{route('fournisseur.commande.edit',Crypt::encrypt($commande->id))}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $commande->libelle }}"><i class="large material-icons color-warning">edit</i></a></span>
                                                            <span><a href="#"  data-href="{{route('fournisseur.commande.archiver',$commande->id)}}" class="archiver" data-toggle="tooltip" title="@lang('Archiver ') {{ $commande->libelle }}"><i class="large material-icons color-danger">delete</i> </a></span>
                                                        </td>
                                                       
                                                     </tr>
                                                 
                                                       
                                                    </tbody>
                                                 </table>
                                                 
                                                 <div style="text-align: center; margin-bottom:50; margin-top:50px">
                                                        <a data-toggle="modal" data-target="#add-article" data-commande="{{$commande->id}}" class="btn btn-danger btn-rounded btn-addon btn-xs m-b-10 m-l-30 add-commande"><i class="ti-plus"></i>Ajouter un article à la commande</a>
                                                 </div>
                                              </div>
                                           </div>
                                        </div>
                                    </div>
                                    
                                   
                                    <div class="col-lg-7 col-md-7">
                                    
                                        <div class="media-left media-middle">
                                            <i class="ti-list f-s-48 color-danger m-r-20"></i> <label for="" style="font-weight: bold">Articles </label> 
                                         </div>                           
                                         <div class="col-lg-12 m-b-70">
                                            <div class="card alert">
                                               <div class="card-body">
                                                  <div class="table-responsive">
                                                     <table class="table table-hover">
                                                        <thead>
                                                           <tr>
                                                              <th>Libellé</th>
                                                              <th>Description</th>
                                                              <th>Type</th>
                                                              <th>Quantité</th>
                                                              <th>Prix d'achat</th>
                                                              {{-- <th>Périodicité facturation</th> --}}
                                                              <th>Date d'achat</th>
                                                              <th>Actions</th>
                                                           </tr>
                                                        </thead>
                                                        <tbody>
                                                           @foreach ($commande->articles as $article)
                                                           @if( $article->archive == false)
                                                               <tr>
                                                                    <td>{{$article->libelle}}</td>
                                                                    <td><span class="text-danger" style="font-size: 13px"> {{$article->description}} </span>  </td>
                                                                    <td><span class="text-danger" style="font-size: 13px"> {{$article->type}} </span>  </td>
                                                                    <td><span class="text-danger" style="font-size: 13px"> {{$article->quantite}} </span>  </td>
                                                                    <td><span class="text-danger" style="font-size: 13px"> {{$article->prix_achat}} </span>  </td>
                                                                    {{-- <td><span class="text-danger" style="font-size: 13px"> {{$article->periodicite_facturation}} </span>  </td> --}}
                                                                    <td><span class="text-primary" style="font-size: 13px"> @if($article->date_achat != null) {{$article->date_achat->format('d/m/Y')}} @endif</span>  </td>
                                                                    <td>
                                                                        <span><a href="{{route('article.edit',Crypt::encrypt($article->id))}}" data-toggle="tooltip" title="@lang('Modifier ') {{ $article->libelle }}"><i class="large material-icons color-warning">edit</i></a></span>
                                                                        <span><a href="#"  data-href="{{route('article.archiver',$article->id)}}" class="archiver" data-toggle="tooltip" title="@lang('Archiver ') {{ $article->libelle }}"><i class="large material-icons color-danger">delete</i> </a></span>
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
                                         
                                         
                                    </div>
                                
                                </div>
                                
                              @endif
                          @endforeach
                      
                      
                      
                          <br><br><br>
                          <hr style="border:2px solid red; margin-top:300px">
                            
                            
                            
                            
                            
         
                         
                         {{-- ZONE MODAL --}}
                         
                         
                         
                         
                                <!-- Modal Add agenda -->
                                <div class="modal fade none-border" id="add-article">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title"><strong>Ajouter un article au contrat</strong></h4>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-valide form-horizontal" action="{{ route('article.store') }}" method="post">
                                                    {{ csrf_field() }}
                                  
                                                  <div class="row">
                                                      <br>
                                                   <br>
                                                      <div class="col-lg-6 col-md-6 col-sm-6">
                                                       
                                                          <div class="form-group row">
                                                             <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="type">Type d'article <span class="text-danger">*</span></label>
                                                             <div class="col-lg-8 col-md-8 col-sm-8">
                                                                <select name="type" class="form-control" id="type" required>
                                                                   <option value="annonce">annonce</option>
                                                                   <option value="remontée">remontée</option>
                                                                   <option value="autre">autre</option>
                                                                </select>
                                                                
                                                                @if ($errors->has('type'))
                                                                <br>
                                                                <div class="alert alert-warning ">
                                                                   <strong>{{$errors->first('type')}}</strong> 
                                                                </div>
                                                                @endif
                                                             </div>
                                                          </div>
                                                       
                                                          <div class="form-group row">
                                                              <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="libelle">Libellé <span class="text-danger">*</span></label>
                                                              <div class="col-lg-8 col-md-8 col-sm-8">
                                                                 <input type="text" class="form-control  {{$errors->has('libelle') ? 'is-invalid' : ''}}"   value="{{old('libelle')}}" id="libelle" name="libelle" required>
                                                                 @if ($errors->has('libelle'))
                                                                 <br>
                                                                 <div class="alert alert-warning ">
                                                                    <strong>{{$errors->first('libelle')}}</strong> 
                                                                 </div>
                                                                 @endif
                                                              </div>
                                                           </div>
                                  
                                                  
                                                          <div class="form-group row">
                                                              <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="description">Description </label>
                                                              <div class="col-lg-8 col-md-8 col-sm-8">
                                                              <textarea  class="form-control" name="description" id="description" cols="30" rows="4"></textarea>
                                                                 @if ($errors->has('description'))
                                                                 <br>
                                                                 <div class="alert alert-warning ">
                                                                    <strong>{{$errors->first('description')}}</strong> 
                                                                 </div>
                                                                 @endif
                                                              </div>
                                                           </div>
                                                         
                                                           <div class="form-group row">
                                                              <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="quantite">Quantité <span class="text-danger">*</span></label>
                                                              <div class="col-lg-8 col-md-8 col-sm-8">
                                                                 <input type="number" step="0.01" class="form-control {{$errors->has('quantite') ? 'is-invalid' : ''}}" value="{{old('quantite')}}" id="quantite" name="quantite" required>
                                                                 @if ($errors->has('quantite'))
                                                                 <br>
                                                                 <div class="alert alert-warning ">
                                                                    <strong>{{$errors->first('quantite')}}</strong> 
                                                                 </div>
                                                                 @endif
                                                              </div>
                                                           </div>
                                         
                                                          
                                         
                                                       
                                  
                                                         
                                  
                                                      </div>
                                                      <div class="col-lg-6 col-md-6 col-sm-6">
                                                          <div class="form-group row">
                                                             <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="prix_achat">Prix d'achat <span class="text-danger">*</span></label>
                                                             <div class="col-lg-8 col-md-8 col-sm-8">
                                                                <input type="number" step="0.01" class="form-control {{$errors->has('prix_achat') ? 'is-invalid' : ''}}" value="{{old('prix_achat')}}" id="prix_achat" name="prix_achat" required>
                                                                @if ($errors->has('prix_achat'))
                                                                <br>
                                                                <div class="alert alert-warning ">
                                                                   <strong>{{$errors->first('prix_achat')}}</strong> 
                                                                </div>
                                                                @endif
                                                             </div>
                                                          </div>
                                                       
                                                          <div class="form-group row">
                                                              <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="coefficient">Coefficient <span class="text-danger">*</span></label>
                                                              <div class="col-lg-8 col-md-8 col-sm-8">
                                                                 <input type="number" step="0.01" class="form-control  {{$errors->has('coefficient') ? 'is-invalid' : ''}}" min="1" max="10"  value="{{old('coefficient')}}" id="coefficient" name="coefficient" required>
                                                                 @if ($errors->has('coefficient'))
                                                                 <br>
                                                                 <div class="alert alert-warning ">
                                                                    <strong>{{$errors->first('coefficient')}}</strong> 
                                                                 </div>
                                                                 @endif
                                                              </div>
                                                           </div>
                                  
                                                            <div class="form-group row">
                                                                 <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_achat">Date d'achat <span class="text-danger">*</span></label>
                                                                 <div class="col-lg-8 col-md-8 col-sm-8">
                                                                    <input type="date" class="form-control {{ $errors->has('date_achat') ? ' is-invalid' : '' }}" value="{{old('date_achat')}}" id="date_achat" name="date_achat" required placeholder=""  >
                                                                    @if ($errors->has('date_achat'))
                                                                       <br>
                                                                       <div class="alert alert-warning ">
                                                                          <strong>{{$errors->first('date_achat')}}</strong> 
                                                                       </div>
                                                                    @endif     
                                                                 </div>
                                                           </div>
                                                          
                                                           <div class="form-group row">
                                                             <label class="col-lg-4 col-md-4 col-sm-4 control-label" for="date_expiration">Date d'expiration </label>
                                                             <div class="col-lg-8 col-md-8 col-sm-8">
                                                                <input type="date" class="form-control {{ $errors->has('date_expiration') ? ' is-invalid' : '' }}" value="{{old('date_expiration')}}" id="date_expiration" name="date_expiration"  placeholder=""  >
                                                                @if ($errors->has('date_expiration'))
                                                                   <br>
                                                                   <div class="alert alert-warning ">
                                                                      <strong>{{$errors->first('date_expiration')}}</strong> 
                                                                   </div>
                                                                @endif     
                                                             </div>
                                                          </div>
                                                          
                                                      </div>
                                                  </div>
                                                    
                                                    <input type="hidden"  name="fournisseur_id" value="{{$fournisseur->id}}">
                                                    <input type="hidden"  name="contrat_id" value="">
                                                    <input type="hidden"  name="commande_id" value="">
                                  
                                                    <div class="form-group row" style="text-align: center; margin-top: 50px;">
                                                       <div class="col-lg-8 ml-auto">
                                                          <button class="btn btn-success btn-flat btn-addon btn-lg m-b-10 m-l-5 submit" id="ajouter"><i class="ti-plus"></i>Enregistrer</button>
                                                       </div>
                                                    </div>
                                                 </form>
                                            </div>  
                                        </div>
                                    </div>
                                </div>
                                <!-- END MODAL -->
                         
                         
                         
                         {{-- FIN ZONE MODAL --}}
                         
                         
                           
                           
                           <hr>
                        </div>
                     </div>
                  </div>
               </div>
               
            </div>
         </div>
         
      
   </div>
</div>




@endsection



@section('js-content')
<script>


// Afficher et masquer les zones de contrat et articles
    function masquerDiv(id_bouton_clic,id_zone_masque){
        
    
            $("#"+id_zone_masque).slideToggle();        
            $("#"+id_bouton_clic).toggleClass("ti-plus","ti-minus") ;  
          
  
    }


// FIN


// Resneigner le formulaire modal d'ajout d'articles dans un contrat

$('.add-article').click(function(){

    var contrat_id = $(this).attr('data-contrat');
    
    $('input[name="contrat_id"]').val(contrat_id);
});


$('.add-commande').click(function(){
   var commande_id = $(this).attr('data-commande');
   
   $('input[name="commande_id"]').val(commande_id);
});

   
</script>



<script>

// Archiver un article
    $(function() {
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        })
        $('[data-toggle="tooltip"]').tooltip()
        
        
        $('body').on('click','a.archiver',function(e) {
            let that = $(this)
            e.preventDefault()
            const swalWithBootstrapButtons = swal.mixin({   
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
                 })

            swalWithBootstrapButtons({
                title: '@lang('Vraiment archiver  ?')',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: '@lang('Oui')',
                cancelButtonText: '@lang('Non')',
                
            }).then((result) => {
                if (result.value) {
                    $('[data-toggle="tooltip"]').tooltip('hide')
                        
                        
        
                    $.ajax({
                        type: "GET",
                    
                        url: that.attr('data-href'),
                       
                        // data: data,
                        success: function(data) {
                            
                            swal(
                                    'Archivé',
                                    'Archivé \n ',
                                    'success'
                                )
                                
                          
                              
                        },
                        error: function(data) {
                            console.log(data);
                            
                            swal(
                                'Echec',
                                'Non archivé:)',
                                'error'
                            );
                        }
                    })
                    
                    .done(function () {
                               that.parents('tr').remove();
                               
                               location.reload();
                      });
                    
                  
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons(
                    'Annulé',
                    'Non archivé:)',
                    'error'
                    )
                }
            })
         })
    })
</script>
@endsection