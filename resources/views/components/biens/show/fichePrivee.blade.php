@extends('layouts.pdf')
@section('content')
@php
	function printData($libelle, $valeur, $compare_valeur, $unite){
		if($valeur !=$compare_valeur){
			echo "<li> $libelle : <strong> $valeur $unite</strong> </li>";
		}
	}
@endphp
<style>
	.space {
	padding:  0px;
	border: 2px solid black;
}

.title{
	background-color: #00ccff;
	color: #ffffff;
}
body{
	font-family: 'Courier New', Courier, monospace;
	font-size: 12px;
}
</style>

	<div class="row">
		<div class="col-sm-4 col-md-4 col-lg-4">
			<span><img src="images/logo.png" alt="Logo Stylimmo"></span>
		</div>
		<div class="col-sm-8 col-md-8 col-lg-8">
			<span style="font-weight:bold; font-size:15px;">{{$bien->bienprix->prix_public}} €</span> <br>
			<span>{{$bien->titre_annonce}}</span><br>
			<span>{{$bien->biensecteur->adresse}} {{$bien->code_postal}}, {{$bien->ville}}</span> <br>
		</div>
	</div>
<br><br>


	<div class="row">

		<div class="col-sm-6 col-md-6 col-lg-6 ">				
            @if(isset($bien->photosbiens[0]))   <p class="space"><img src="images/photos_bien/{{$bien->photosbiens[0]->filename}}" width="100%" height="150px" alt="Logo Stylimmo"></p>@endif
            @if(isset($bien->photosbiens[1]))   <p class="space"><img src="images/photos_bien/{{$bien->photosbiens[1]->filename}}" width="100%" height="150px" alt="Logo Stylimmo"></p>@endif
        </div>
        <div class="col-sm-6 col-md-6 col-lg-6">
            <p class="title">DESCRIPTION</p>
            <p> {{$bien->description_annonce}} </p>
        </div>
	</div>

	<div class="row">
		<div class="col-sm-6 col-md-6 col-lg-6 ">
            <p class="title">SECTEUR ET COMMODITES</p>
            <p>
                <ul>
                    @php
						printData("Adresse ",$bien->biensecteur->adresse_bien, null," " );						
						printData("Complément d'adresse ",$bien->biensecteur->complement_adresse, null," " );						
						printData("Secteur",$bien->biensecteur->secteur,null," " );						
						printData("Transports à proximité ",$bien->biensecteur->transport_a_proximite, null," " );									
					@endphp		
                    
                </ul>
            </p>
		</div>
		
		<div class="col-sm-6 col-md-6 col-lg-6">
			<p class="title">NOTES</p>
			<p>
				<ul>
                    	
					
				</ul>
			</p>

		</div>
	</div>

	<div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 ">
                <p class="title">DESCRIPTION </p>
                <p>
                    <ul>
                        @php
						//maison appart
						printData("Nombre de pièces ",$bien->nombre_piece, null," " );
						printData("Nombre de chambres ",$bien->nombre_chambre, null," " );
						printData("Nombre de salles d'eau ",$bien->biendetail->agen_inter_nb_salle_eau, null," " );
						printData("Nombre de salles de bain ",$bien->biendetail->agen_inter_nb_salle_bain, null," " );
						printData("Nombre de WC",$bien->biendetail->agen_inter_nb_wc, null," " );
						printData("nombre de garage ",$bien->nombre_garage, null," " );
						printData("Jardin ",$bien->jardin, "Non précisé"," " );
						printData("Piscine ",$bien->piscine, "Non précisé"," " );
						//terrain
						printData("Raccordement eau ",$bien->biendetail->terrain_raccordement_eau, "Non précisé", " " );
						printData("Raccordement gaz ",$bien->biendetail->terrain_raccordement_gaz, "Non précisé", " " );
						printData("Raccordement électricité ",$bien->biendetail->terrain_raccordement_electricite, "Non précisé", " " );
						printData("Raccordement téléphone ",$bien->biendetail->terrain_raccordement_telephone, "Non précisé", " " );
						printData("Constructible ",$bien->biendetail->terrain_constructible, "Non précisé", " " );
						printData("Viabilisé ",$bien->biendetail->terrain_viabilise, "Non précisé", " " );
					@endphp		
                        
                    </ul>
                </p>
            </div>
            
            <div class="col-sm-6 col-md-6 col-lg-6">
                <p class="title">INFORMATIONS </p>
                <p>
                    <ul>
                        @php
						printData("Année de construction ",$bien->biendetail->diagnostic_annee_construction, null," " );						
						printData("Etat extérieur ",$bien->biendetail->diagnostic_etat_exterieur, "Non défini"," " );						
						printData("Etat intérieur ",$bien->biendetail->diagnostic_etat_interieur, "Non défini"," " );						
						printData("Surface annexe ",$bien->biendetail->diagnostic_surface_annexe, null,"m²" );				
												
					    @endphp		
                        
                    </ul>
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 ">
                <p class="title">INFORMATIONS FINANCIERES</p>
                <p>
                    <ul>
                        @php						
						printData("Prix net vendeur ",$bien->bienprix->prix_net, null,"€" );						
						printData("Prix public ",$bien->bienprix->prix_public, null,"€" );						
						printData("Honoraires charge Acquéreur ",$bien->bienprix->honoraire_acquereur, null," " );						
						printData("Honoraires charge Vendeur ",$bien->bienprix->honoraire_vendeur, null," " );						
						printData("Estimation ",$bien->bienprix->estimation_valeur, null,"€" );						
						printData("Montant foncier total ",$bien->bienprix->taxe_fonciere, null,"€" );						
						printData("Charges Mensuelles ",$bien->bienprix->charge_mensuelle_total, null,"€" );						
						printData("Travaux à prévoir ",$bien->bienprix->travaux_a_prevoir, null," " );						
						printData("Dépôt de garantie ",$bien->bienprix->depot_garanti, null,"€" );						
						printData("Taxe d'habitation ",$bien->bienprix->taxe_habitation, null,"€" );						
						
					    @endphp			
                        
                    </ul>
                </p>
            </div>
            
            <div class="col-sm-6 col-md-6 col-lg-6">
                <p class="title">MANDAT ET DISPONIBILITE</p>
                <p>
                    <ul>
                        @php						
						printData("N° de dossier",$bien->numero_dossier, null,"" );						
						printData("Type d'offre",$bien->type_offre, null,"" );						
						printData("Disponiblité immédiate",$bien->biendetail->dossier_dispo_disponibilite_immediate, "Non précisé","" );						
												
												
												
						
					    @endphp	
                        
                    </ul>
                </p>
            </div>
        </div>
      
	<div class="row m-t-25 ">
		<div class="col-sm-12 col-md-12 col-lg-12">
			<p class="title">VOTRE AGENCE</p>
			<span><img src="images/logo.png" alt=""></span> <strong>{{$bien->utilisateur->individu->prenom}}  {{$bien->utilisateur->individu->nom}}</strong> <br>
			Adresse <strong>{{$bien->utilisateur->adresse}} {{$bien->utilisateur->individu->code_postal}}, {{$bien->utilisateur->individu->ville}}</strong> <br>
			Tél : <strong>{{$bien->utilisateur->individu->telephone}}</strong> <br>
			Mail : <strong>{{$bien->utilisateur->email}} </strong> 
			
		</div>
	</div>

@endsection