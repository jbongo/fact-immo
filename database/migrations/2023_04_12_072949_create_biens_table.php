<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBiensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('biens', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->unsigned();
            $table->integer('offreachat_id')->nullable();
            $table->integer('proprietaire_id')->unsigned()->nullable();
            $table->string('type_offre')->nullable();
            $table->string('type_bien')->nullable();
            //  ['actif','offre','compromis', 'acte', 'cloture']
            $table->string('statut')->default('actif')->nullable();

            $table->string('type_type_bien')->nullable();
            $table->string('titre_annonce')->nullable();
            $table->text('description_annonce')->nullable();
            $table->string('titre_annonce_vitrine')->nullable();
            $table->text('description_annonce_vitrine')->nullable();
            $table->string('titre_annonce_privee')->nullable();
            $table->text('description_annonce_privee')->nullable();
            // loyer
            $table->integer('duree_bail')->nullable();
            $table->string('meuble')->nullable();
            // #
            $table->double('surface')->nullable();
            $table->double('surface_habitable')->nullable();
            $table->double('surface_terrain')->nullable();
            $table->integer('nombre_piece')->nullable();
            $table->integer('nombre_chambre')->nullable();
            $table->integer('nombre_niveau')->nullable();
            $table->string('jardin')->nullable();
            $table->double('jardin_surface')->nullable();
            $table->string('jardin_privatif')->nullable();
            $table->double('jardin_volume')->nullable();
            $table->string('jardin_pool_house')->nullable();
            $table->string('jardin_chauffee')->nullable();
            $table->string('jardin_couverte')->nullable();
            $table->string('piscine')->nullable();
            $table->string('piscine_statut')->nullable();
            $table->string('piscine_nature')->nullable();
            $table->string('pays')->nullable();
            $table->string('ville')->nullable();
            $table->string('code_postal')->nullable();
            $table->string('numero_dossier')->nullable();
            $table->date('date_creation_dossier')->nullable();
            $table->integer('nombre_garage')->nullable();
            $table->string('exposition_situation')->nullable();
            $table->string('vue_situation')->nullable();
            $table->boolean('mandat_actif')->default(0);
            
            // ### Prix
        
            $table->double('prix_public')->nullable();
            $table->double('prix_prive')->nullable();
            $table->double('loyer')->nullable();
            $table->double('complement_loyer')->nullable();
            $table->string('honoraire_acquereur')->nullable();
            $table->double('frais_agence')->nullable();
            $table->double('taux_frais')->nullable();
            // $table->double('part_acquereur')->nullable();
            // $table->double('taux_prix')->nullable();
            $table->string('honoraire_vendeur')->nullable();
            // $table->double('part_vendeur')->nullable();
            // $table->double('taux_net')->nullable();
            $table->date('estimation_date')->nullable();
            $table->double('estimation_valeur')->nullable();
            $table->double('viager_prix_bouquet')->nullable();
            $table->double('viager_rente_mensuelle')->nullable();
            $table->string('travaux_a_prevoir')->nullable();
            $table->double('depot_garanti')->nullable();
            $table->double('taxe_habitation')->nullable();
            $table->double('taxe_fonciere')->nullable();
            $table->double('charge_mensuelle_total')->nullable();
            $table->string('charge_mensuelle_info')->nullable();
            
            
            // ## Secteur
            $table->string('section_parcelle')->nullable();
            $table->string('pays_annonce')->nullable();
            $table->string('adresse_bien')->nullable();
            $table->string('complement_adresse')->nullable();
            $table->string('quartier')->nullable();
            $table->string('secteur')->nullable();
            $table->string('immeuble_batiment')->nullable();
            $table->string('transport_a_proximite')->nullable();
            $table->string('proximite')->nullable();
            $table->string('environnement')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('biens');
    }
}
