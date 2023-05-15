@if ($bien->notaires === null)
    <div class="panel lobipanel-basic panel-warning">
        <div class="panel-heading">
            <div class="panel-title">INSTRUCTIONS</div>
        </div>
        <div class="panel-body">
            Vous devez attacher les études de notaires qui signent le compromis et l'acte de vente définitif avant de
            pouvoir plannifier les rendez-vous pour
            la signature, le choix des notaires peut dépendre de plusieurs critères(Préference du vendeur ou de
            l'acquéreur, proximité....).<br><br>
            <a href="#" data-toggle="modal" data-target="#notaire_add"
                class="btn btn-success btn-rounded btn-addon btn-sm m-b-10 m-l-5"><i
                    class="ti-plus"></i>@lang('Ajouter')</a>
        </div>
    </div>
@else
    @php
        $data = unserialize($bien->notaires);
        $notaire_compromis = $data[0];
        $notaire_acte = $data[1];
    @endphp
    @if ($bien->statut === 'compromis')
        <div class="col-lg-6">
            <div class="card alert" style="border: 5px solid #799eab; border-radius: 20px;">
                <div class="products_1 text-center">
                    <div class="pr_img_price">
                        <div class="product_img">
                            <i class="material-icons color-pink"
                                style="font-size: 90px; border: 4px solid #799eab; padding: 4px; border-radius: 20px;">gavel</i>
                        </div>
                        <div class="product_price">
                            <div class="prd_prc_box">
                                <div class="product_price">
                                    <p><strong><a
                                                href="{{ route('contact.entite.show', Crypt::encrypt($notaire_compromis['notaire_id'])) }}"
                                                data-toggle="tooltip" title="Voir"><i class="material-icons"
                                                    style="color:white;"> visibility </i></a></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product_details">
                        <div class="product_name">
                            <span class="badge badge-default">COMPROMIS</span><br>
                            <strong class="color-info">{{ $notaire_compromis['nom_etude'] }}</strong>
                        </div>
                        <div class="product_des">
                            @if ($notaire_compromis['demande_rendez_vous'] == 1)
                                <p>Demande de rendez-vous pour la signature du compromis effectuée le <strong
                                        class="color-danger">{{ $notaire_compromis['date_demande'] }}</strong></p>
                            @else
                                <p>Aucune demande de rendez-vous effectuée !</p>
                            @endif
                        </div>
                        <div class="product_des">
                            <a type="button"
                                href="{{ route('suiviaffaire.notaire.appointement', [Crypt::encrypt($bien->id), 'compromis']) }}"
                                class="btn btn-info btn-rounded btn-addon btn-xs m-b-10"><i
                                    class="ti-settings"></i>demande rendez-vous</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($bien->statut === 'acte')
        <div class="col-lg-6">
            <div class="card alert" style="border: 5px solid #799eab; border-radius: 20px;">
                <div class="products_1 text-center">
                    <div class="pr_img_price">
                        <div class="product_img">
                            <i class="material-icons color-pink"
                                style="font-size: 90px; border: 4px solid #799eab; padding: 4px; border-radius: 20px;">gavel</i>
                        </div>
                        <div class="product_price">
                            <div class="prd_prc_box">
                                <div class="product_price">
                                    <p><strong><a
                                                href="{{ route('contact.entite.show', Crypt::encrypt($notaire_acte['notaire_id'])) }}"
                                                data-toggle="tooltip" title="Voir"><i class="material-icons"
                                                    style="color:white;"> visibility </i></a></strong></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="product_details">
                        <div class="product_name">
                            <span class="badge badge-default">ACTE DE VENTE</span><br>
                            <strong class="color-info">{{ $notaire_acte['nom_etude'] }}</strong>
                        </div>
                        <div class="product_des">
                            @if ($notaire_acte['demande_rendez_vous'] == 1)
                                <p>Demande de rendez-vous pour la signature de l'acte de vente effectuée le <strong
                                        class="color-danger">{{ $notaire_acte['date_demande'] }}</strong></p>
                            @else
                                <p>Aucune demande de rendez-vous effectuée !</p>
                            @endif
                        </div>
                        <div class="product_des">
                            <a type="button"
                                href="{{ route('suiviaffaire.notaire.appointement', [Crypt::encrypt($bien->id), 'acte']) }}"
                                class="btn btn-info btn-rounded btn-addon btn-xs m-b-10"><i
                                    class="ti-settings"></i>demande rendez-vous</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endif
