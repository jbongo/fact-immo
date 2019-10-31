<?php

use Illuminate\Database\Seeder;

class ContratsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('contrats')->delete();
        
        \DB::table('contrats')->insert(array (
            0 => 
            array (
                'id' => 16,
                'user_id' => NULL,
                'forfait_entree' => 220.0,
                'forfait_administratif' => 200.0,
                'forfait_carte_pro' => 20.0,
                'date_entree' => '2019-09-27',
                'date_deb_activite' => '2019-09-27',
                'ca_depart' => 0.0,
                'ca_depart_sty' => 0.0,
                'est_demarrage_starter' => 1,
                'a_parrain' => 0,
                'parrain_id' => NULL,
                'pourcentage_depart_starter' => 65.0,
                'duree_max_starter' => 7,
                'duree_gratuite_starter' => 4,
                'a_palier_starter' => 1,
                'palier_starter' => 'level_starter1=1&percent_starter1=0&ca_min_starter1=0&ca_max_starter1=30000&level_starter2=2&percent_starter2=5&ca_min_starter2=30001&ca_max_starter2=50000&level_starter3=3&percent_starter3=4&ca_min_starter3=50001&ca_max_starter3=90000',
                'pourcentage_depart_expert' => 75.0,
                'duree_max_starter_expert' => 7,
                'duree_gratuite_expert' => 4,
                'a_palier_expert' => 1,
                'palier_expert' => 'level_expert1=1&percent_expert1=0&ca_min_expert1=0&ca_max_expert1=50000&level_expert2=2&percent_expert2=5&ca_min_expert2=50001&ca_max_expert2=80000&level_expert3=3&percent_expert3=3&ca_min_expert3=80001&ca_max_expert3=100000',
                'nombre_vente_min' => 4,
                'nombre_mini_filleul' => 4,
                'chiffre_affaire_mini' => 27000.0,
                'a_soustraitre' => 10.0,
                'prime_forfaitaire' => NULL,
                'packpub_id' => 1,
                'est_modele' => 1,
                'created_at' => '2019-10-17 13:23:58',
                'updated_at' => '2019-10-30 14:33:06',
            ),
            1 => 
            array (
                'id' => 17,
                'user_id' => 11,
                'forfait_entree' => 220.0,
                'forfait_administratif' => 200.0,
                'forfait_carte_pro' => 20.0,
                'date_entree' => '2019-09-27',
                'date_deb_activite' => '2019-09-27',
                'ca_depart' => 6000.0,
                'ca_depart_sty' => 0.0,
                'est_demarrage_starter' => 1,
                'a_parrain' => 0,
                'parrain_id' => NULL,
                'pourcentage_depart_starter' => 65.0,
                'duree_max_starter' => 7,
                'duree_gratuite_starter' => 4,
                'a_palier_starter' => 1,
                'palier_starter' => 'level_starter1=1&percent_starter1=0&ca_min_starter1=0&ca_max_starter1=50000&level_starter2=2&percent_starter2=3&ca_min_starter2=50001&ca_max_starter2=80000&level_starter3=3&percent_starter3=4&ca_min_starter3=80001&ca_max_starter3=120000&level_starter4=4&percent_starter4=2&ca_min_starter4=120001&ca_max_starter4=200000&level_starter5=5&percent_starter5=1&ca_min_starter5=200001&ca_max_starter5=350000',
                'pourcentage_depart_expert' => 75.0,
                'duree_max_starter_expert' => 7,
                'duree_gratuite_expert' => 4,
                'a_palier_expert' => 0,
                'palier_expert' => 'level_expert1=1&percent_expert1=0&ca_min_expert1=0&ca_max_expert1=50000',
                'nombre_vente_min' => 4,
                'nombre_mini_filleul' => 4,
                'chiffre_affaire_mini' => 27000.0,
                'a_soustraitre' => 10.0,
                'prime_forfaitaire' => NULL,
                'packpub_id' => 1,
                'est_modele' => 0,
                'created_at' => '2019-10-17 13:24:59',
                'updated_at' => '2019-10-28 13:46:20',
            ),
            2 => 
            array (
                'id' => 18,
                'user_id' => 12,
                'forfait_entree' => 220.0,
                'forfait_administratif' => 200.0,
                'forfait_carte_pro' => 20.0,
                'date_entree' => '2019-10-04',
                'date_deb_activite' => '2019-10-12',
                'ca_depart' => 2500.0,
                'ca_depart_sty' => 0.0,
                'est_demarrage_starter' => 1,
                'a_parrain' => 1,
                'parrain_id' => 11,
                'pourcentage_depart_starter' => 65.0,
                'duree_max_starter' => 7,
                'duree_gratuite_starter' => 4,
                'a_palier_starter' => 1,
                'palier_starter' => 'level_starter1=1&percent_starter1=0&ca_min_starter1=0&ca_max_starter1=50000&level_starter2=2&percent_starter2=1&ca_min_starter2=50001&ca_max_starter2=70000&level_starter3=3&percent_starter3=2&ca_min_starter3=70001&ca_max_starter3=100000&level_starter4=4&percent_starter4=5&ca_min_starter4=100001&ca_max_starter4=150000&level_starter5=5&percent_starter5=3&ca_min_starter5=150001&ca_max_starter5=200000',
                'pourcentage_depart_expert' => 75.0,
                'duree_max_starter_expert' => 7,
                'duree_gratuite_expert' => 4,
                'a_palier_expert' => 0,
                'palier_expert' => 'level_expert1=1&percent_expert1=0&ca_min_expert1=0&ca_max_expert1=50000',
                'nombre_vente_min' => 4,
                'nombre_mini_filleul' => 4,
                'chiffre_affaire_mini' => 27000.0,
                'a_soustraitre' => 10.0,
                'prime_forfaitaire' => NULL,
                'packpub_id' => 2,
                'est_modele' => 0,
                'created_at' => '2019-10-17 13:28:40',
                'updated_at' => '2019-10-28 13:32:44',
            ),
            3 => 
            array (
                'id' => 19,
                'user_id' => 14,
                'forfait_entree' => 220.0,
                'forfait_administratif' => 200.0,
                'forfait_carte_pro' => 20.0,
                'date_entree' => '2019-09-27',
                'date_deb_activite' => '2019-09-27',
                'ca_depart' => 0.0,
                'ca_depart_sty' => 0.0,
                'est_demarrage_starter' => 1,
                'a_parrain' => 0,
                'parrain_id' => NULL,
                'pourcentage_depart_starter' => 65.0,
                'duree_max_starter' => 7,
                'duree_gratuite_starter' => 4,
                'a_palier_starter' => 0,
                'palier_starter' => 'level_starter1=1&percent_starter1=0&ca_min_starter1=0&ca_max_starter1=50000',
                'pourcentage_depart_expert' => 75.0,
                'duree_max_starter_expert' => NULL,
                'duree_gratuite_expert' => 4,
                'a_palier_expert' => 0,
                'palier_expert' => 'level_expert1=1&percent_expert1=0&ca_min_expert1=0&ca_max_expert1=50000',
                'nombre_vente_min' => 4,
                'nombre_mini_filleul' => 4,
                'chiffre_affaire_mini' => 27000.0,
                'a_soustraitre' => 10.0,
                'prime_forfaitaire' => NULL,
                'packpub_id' => 1,
                'est_modele' => 0,
                'created_at' => '2019-10-30 13:55:44',
                'updated_at' => '2019-10-30 13:55:44',
            ),
        ));
        
        
    }
}