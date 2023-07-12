@extends('layouts.app')

@section('content')
@section('page_title')
    Facture Pack pub
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


            <table style="height: 26px; width: 760px;">
                <tbody>
                    <tr>
                        <td style="width: 370px;"><img src="https://www.stylimmo.com/images/logo.jpg" alt=""
                                width="249" height="140" /></td>
                        <td style="width: 378px;">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
            <table style="height: 132px;" width="756">
                <tbody>
                    <tr style="height: 100px;">
                        <td style="width: 370px; height: 100px;">Bagnols sur C&egrave;ze le,&nbsp;31 mars 2017</td>
                        <td style="width: 370px; height: 100px;">
                            <p><strong>Mme LAUCAGNE Valentine</strong></p>
                            <p><strong>99 Avenue du
                                    Mistral</strong><br /><strong>{{ App\Parametre::params()->code_postal }} SAINT
                                    ETIENNE DES SORTS</strong></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table style="height: 72px;" width="756">
                <tbody>
                    <tr>
                        <td style="width: 370px;"><strong>FACTURE N&deg; F14 908</strong></td>
                        <td style="width: 370px;">&nbsp;</td>
                    </tr>
                </tbody>
            </table>
            <table style="height: 57px;" width="755">
                <tbody>
                    <tr>
                        <td style="width: 745px; text-align: center;">Je vous prie de bien vouloir trouver ci-joint la
                            facture concernant vos logiciels, passerelles &amp; outils.</td>
                    </tr>
                </tbody>
            </table>
            <table style="height: 48px;" width="755">
                <tbody>
                    <tr>
                        <td style="width: 745px; text-align: center;">P&eacute;riode d'utilisation du mois de
                            :&nbsp;mars</td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td>Logiciel</td>
                    </tr>
                </tbody>
            </table>
            <table style="height: 49px;" width="754">
                <tbody>
                    <tr style="height: 134px;">
                        <td style="width: 744px; height: 134px;"><img
                                style="display: block; margin-left: auto; margin-right: auto;"
                                src="{{ asset('images/logiciel.png') }}" width="446" height="100" /></td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td>Passerelle dans votre PAC 20</td>
                    </tr>
                </tbody>
            </table>
            <table width="754">
                <tbody>
                    <tr>
                        <td><img style="display: block; margin-left: auto; margin-right: auto;"
                                src="{{ asset('images/passerelle_abon.png') }}" width="446" height="200" /></td>
                    </tr>
                </tbody>
            </table>
            <table>
                <tbody>
                    <tr>
                        <td>Passerelles illimit&eacute;es dans votre Pac</td>
                    </tr>
                </tbody>
            </table>
            <table width="754">
                <tbody>
                    <tr>
                        <td><img style="display: block; margin-left: auto; margin-right: auto;"
                                src="{{ asset('images/passerelle_grat.png') }}"
                                alt="https://www.stylimmo.com/images/logo.jpg" width="446" height="120" /></td>
                    </tr>
                </tbody>
            </table>
            <table style="height: 46px;" width="754">
                <tbody>
                    <tr>
                        <td style="width: 243px;">T H.T. : 236,90 &euro;</td>
                        <td style="width: 243px;">T.V.A. 20 % : 4 7,38 &euro;</td>
                        <td style="width: 246px;">TOTAL T.T.C. : 284,28 &euro;</td>
                    </tr>
                </tbody>
            </table>
            <table style="height: 49px;" width="753">
                <tbody>
                    <tr>
                        <td style="width: 743px; text-align: center;">Conditions de paiement : &agrave; r&eacute;ception
                            de la facture par virement en pr&eacute;cisant le N&deg; de la pr&eacute;sente facture.</td>
                    </tr>
                </tbody>
            </table>
            <p>&nbsp;</p>

            <table class="table table-striped table-bordered table-hover" style="width: 100%;" border="1"
                cellspacing="0">
                <thead>
                    <tr style="height: 18px;">
                        <th align="center" style="height: 18px;">DOMICILIATION BANCAIRE: Crédit Mutuel</th>
                    </tr>
                </thead>
                <tbody>
                    <tr style="height: 18px;">
                        <th align="center" style="height: 18px;">RIB: 10278 07941 00020227202 11</th>
                    </tr>
                    <tr style="height: 18px;">
                        <th align="center">IBAN: FR76 1027 8079 4100 0202 2720 308</th>
                    </tr>
                    <tr style="height: 8px;">
                        <th align="center" style="height: 8px;">BIC: CMCIFR2A</th>
                    </tr>
                </tbody>
            </table>
            <hr />
            <div style="text-align: center; font-size: 11px; margin-right: 25%; margin-left: 25%; margin-top: 20px;">
                <p><strong>SARL {{ App\Parametre::params()->raison_sociale }}</strong> -
                    {{ App\Parametre::params()->adresse }} - Zone Artisanale de Berret -
                    {{ App\Parametre::params()->code_postal }} {{ App\Parametre::params()->ville }} Carte
                    professionnelle N&deg;1312T14 SIRET: {{ App\Parametre::params()->numero_siret }} - RCS NIMES
                    {{ App\Parametre::params()->numero_rcs }}</p>
            </div>

        </div>
    </div>
</div>
@endsection
