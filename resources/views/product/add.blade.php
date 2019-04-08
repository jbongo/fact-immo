@extends('layouts.app')

@section('content')
@section ('page_title')
Ajouter un article
@endsection
<div id="main-content">
    <div class="card alert">
        <div class="card-header">
            <h4></h4>
            <div class="card-header-right-icon">
                
            </div>
        </div>
        <div class="card-body">
            <div class="horizontal-form" id="add-article">
                <form class="form-horizontal" method="post" id="form-add-article" action="{{ route('product.store') }}">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <div class="form-group">
                                <label class=" control-label">Nom</label>
                                <div class="">
                                    <input type="text" name="name" required class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6">
                            <label class=" control-label">Catégorie</label>
                            <div class="" >
                                <select name="productCategory_id" id=""  required class="form-control">
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label class="control-label">Description</label>
                                <div class="">
                                <textarea class="form-control" name="description" required id="" cols="20" rows="5"></textarea>
                            </div>
                    </div>
                    
                        </div>
                    </div>

                    
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class=" control-label">Prix de vente</label>
                                <div class="">
                                    <input type="number" name="coast" required class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label class="control-label">Prix d'achat</label>
                                <div class=""> 
                                    <input type="number" name="selling_price" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>

                    </div>
<br><br>
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <span>Engagement <img width="50px" height="35px" src="{{ asset('images/icon/icon_eng.png') }}" title="Engagement" alt="engagement"></span><hr>
                            <div class="form-group">
                                <label class=" control-label">Nb Likes</label>
                                <div class="">
                                    <input type="number"  name="eng_like" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label">Nb Commentaires </label>
                                <div class="">
                                    <input type="number"  name="eng_comment" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label">Nb Partages</label>
                                <div class="">
                                    <input type="number"  name="eng_share" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" control-label">Nb Réaction </label>
                                <div class="">
                                    <input type="number" name="eng_reaction"  class="form-control" placeholder="">
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <span>Profit <img width="50px" height="35px" src="{{ asset('images/icon/icon_profit.png') }}" title="Profit"  alt="profit"></span><hr>
                            <div class="form-group">
                                <label class="control-label">CPA Min</label>
                                <div class="">
                                    <input type="number" name="cpa_min" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">CPA Max</label>
                                <div class="">
                                    <input type="number" name="cpa_max" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <span>Analytic <img width="50px" height="35px" src="{{ asset('images/icon/icon_analy.png') }}" title="Analytic"  alt="Analytic"></span> <hr>                                       
                            <div class="form-group">
                                <label class="control-label">Source</label>
                                <div class="">
                                    <input type="texte" name="analy_source" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nb Commandes</label>
                                <div class="">
                                    <input type="number" name="analy_order" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nb Votes</label>
                                <div class="">
                                    <input type="number" name="analy_vote" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Nb Avis</label>
                                <div class="">
                                    <input type="number" name="analy_review" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Evaluation</label>
                                <div class="">
                                    <input type="number" name="analy_rating" class="form-control" placeholder="">
                                </div>
                            </div>

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <span>Link <img width="50px" height="35px" src="{{ asset('images/icon/icon_link.png') }}" title="Link"  alt="Link"></span><hr>
                            <div class="form-group">
                                <label class="control-label">Lien Aliexpress</label>
                                <div class="">
                                    <input type="texte" name="link_aliexpress" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Lien Alibaba</label>
                                <div class="">
                                    <input type="texte" name="link_alibaba" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Lien Facebook Ad</label>
                                <div class="">
                                    <input type="texte" name="link_facebookAd" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Lien Amazon</label>
                                <div class="">
                                    <input type="texte" name="link_amazon" class="form-control" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Lien Ebay</label>
                                <div class="">
                                    <input type="texte" name="link_ebay" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>
                    <br>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-lg-offset-4 col-md-offset-4">
                        <button  id="ajouter-photo" style="width:160px" name="ajouterSeul" class="btn btn-lg btn-success"> @lang('Ajouter photos')</button>
                        </div>
                    </div>
                
                </form>
            </div>

        </div>
    </div>
</div> 




@endsection

@section('js-content')

<script>
    
    </script>
@endsection