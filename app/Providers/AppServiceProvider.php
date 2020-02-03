<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Parametre;
use Config;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        // $parametre = Parametre::first();
        // Config::set('setting.raison_sociale',$parametre->raison_sociale);
        // Config::set('setting.numero_siret',$parametre->numero_siret);
        // Config::set('setting.numero_rcs',$parametre->numero_rcs);
        // Config::set('setting.numero_tva',$parametre->numero_tva);
        // Config::set('setting.adresse',$parametre->adresse);
        // Config::set('setting.ville',$parametre->ville);
        // Config::set('setting.ca_imposable',$parametre->ca_imposable);
        // Config::set('setting.tva',$parametre->tva->tva_actuelle);
         
    }
}
