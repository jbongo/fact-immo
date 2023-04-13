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
	font-weight: bold;
}
body{
	font-family: 'Courier New', Courier, monospace;
	font-size: 12px;
}
</style>

	<div class="row space m-b-2">
		<div class="col-sm-12 col-md-12 col-lg-12">

			<p>Offre de : <span style="font-weight:bold; font-size:15px;">{{$bien->type_offre}}</span> <br></p>
			<p>Mandat n° :****************</p>

		</div>
	</div>

	<div class="row">
		<div class="col-sm-4 col-md-4 col-lg-4">
			<span><img src="images/logo.png" alt="Logo Stylimmo"></span>
		</div>

		<div class="col-sm-8 col-md-8 col-lg-8">

			<span style="font-weight:bold; font-size:15px;">{{$bien->prix_public}} €</span> <br>
			<span>{{$bien->titre_annonce}}</span><br>
			<span>{{$bien->adresse_bien}} {{$bien->code_postal}}, {{$bien->ville}}</span> <br>
		</div>

	</div>
<br><br>




	<div class="row">

		<div class="col-sm-4 col-md-4 col-lg-4  m-r-20">
	
			@if(isset($bien->photosbiens[0]))	<p class="space"><img src="images/photos_bien/{{$bien->photosbiens[0]->filename}}" width="100%" height="150px" alt="Logo Stylimmo"></p> @endif
			
			@if(isset($bien->photosbiens[1])) <span ><img class="space" src="images/photos_bien/{{$bien->photosbiens[1]->filename}}" width="47%" height="100%" alt="Logo Stylimmo"></span> @endif
		
			@if(isset($bien->photosbiens[2]))<span ><img class="space" src="images/photos_bien/{{$bien->photosbiens[2]->filename}}" width="47%" height="100%" alt="Logo Stylimmo"></span>@endif
			
		</div>
		<div class="col-sm-8 col-md-8 col-lg-8">
			<p class="title">@lang('DESCRIPTIF')</p>
			<p>
				<ul>

					@php
						//maison appart
						printData("Nombre de pièces ",$bien->nombre_piece, null," " );
						printData("Nombre de chambres ",$bien->nombre_chambre, null," " );
						printData("Nombre de salles d'eau ",$bien->biendetail->agen_inter_nb_salle_eau, null," " );
						printData("Nombre de salles de bain ",$bien->biendetail->agen_inter_nb_salle_bain, null," " );
						printData("Nombre de WC",$bien->biendetail->agen_inter_nb_wc, null," " );
						printData("nombre de garage ",$bien->biendetail->agen_exter_nb_garage, null," " );
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
			<p class="title">INFORMATIONS</p>
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
			<p class="title">SECTEUR</p>
			<p>
				<ul>
					@php
						printData("Adresse ",$bien->adresse_bien, null," " );						
						printData("Complément d'adresse ",$bien->complement_adresse, null," " );						
						printData("Secteur",$bien->secteur,null," " );						
						printData("Transports à proximité ",$bien->transport_a_proximite, null," " );									
					@endphp	
				</ul>
			</p>
		</div>
	</div>



	<div class="row">
		<div class="col-sm-6 col-md-6 col-lg-6">
			<p class="title">DESCRIPTION</p>
			<p >
				{{$bien->description_annonce}}
			</p>
		</div>
		<div class="col-sm-6 col-md-6 col-lg-6">
			<p class="title">SURFACES</p>
			<p>
				<ul>
					@php
						printData("Surface habitable ",$bien->surface_habitable,null,"m²" );
						printData("Surface du terrain ",$bien->surface_terrain,null,"m²" );
						printData("Surface carrez ",$bien->biendetail->agen_inter_surface_carrez,null,"m²" );
						printData("Garages ",$bien->biendetail->agen_exter_surface_garage,null,"m²" );

					@endphp

						
				</ul>
			</p>
		</div>
	</div>


	<div class="row">
		<div class="col-sm-4 col-md-4 col-lg-4">
			<p>@include('layouts.dpe')
			</p>
			
			
		</div>
		<div class="col-sm-8 col-md-8 col-lg-8">
			<p class="title">VOTRE AGENCE</p>
			<span><img src="images/logo.png" alt=""></span> <strong>{{$bien->user->prenom}}  {{$bien->user->nom}}</strong> <br>
			Adresse <strong>{{$bien->user->adresse}} {{$bien->user->code_postal}}, {{$bien->user->ville}}</strong> <br>
			Tél : <strong>{{$bien->user->telephone}}</strong> <br>
			Mail : <strong>{{$bien->user->email}} </strong> 
			
		</div>
	</div>

@endsection