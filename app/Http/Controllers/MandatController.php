<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mandat;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Contact;
use Illuminate\Support\Facades\DB;
use App\Bien;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;


class MandatController extends Controller
{
    /**
     * Liste des mandats
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {   
        $query = Mandat::with(['user', 'suiviPar', 'contact', 'bien']);
        
        // Filtrer selon le rôle
        if(Auth::user()->role != 'admin') {
            $query->where('suivi_par_id', Auth::user()->id);
        }

        // Recherche globale
        if($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero', 'LIKE', "%{$search}%")
                  ->orWhere('type', 'LIKE', "%{$search}%")
                  ->orWhere('nom_reservation', 'LIKE', "%{$search}%")
                  ->orWhere('observation', 'LIKE', "%{$search}%")
                  ->orWhereHas('contact', function($q) use ($search) {
                      $q->where('nom', 'LIKE', "%{$search}%")
                        ->orWhere('prenom', 'LIKE', "%{$search}%")
                        ->orWhere('raison_sociale', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('bien', function($q) use ($search) {
                      $q->where('type_bien', 'LIKE', "%{$search}%")
                        ->orWhere('ville', 'LIKE', "%{$search}%")
                        ->orWhere('adresse', 'LIKE', "%{$search}%");
                  })
                  ->orWhereHas('suiviPar', function($q) use ($search) {
                      $q->where('nom', 'LIKE', "%{$search}%")
                        ->orWhere('prenom', 'LIKE', "%{$search}%");
                  });
            });
        }

        // Filtre par mandataire
        if($request->suivi) {
            $query->whereHas('suiviPar', function($q) use ($request) {
                $q->where(DB::raw("CONCAT(nom, ' ', prenom)"), 'LIKE', "%{$request->suivi}%");
            });
        }

        // Filtre par type
        if($request->type) {
            $query->where('statut', $request->type);
        }
        
        // Filtre par clôturé
        if($request->cloture) {
            $query->where('est_cloture', true);
        }

        // Filtre par non retourné
        if($request->non_retourne) {
            $query->where('est_retourne', false);
        }
        
        // Tri
        if($request->sort && $request->direction) {
            $sortField = $request->sort;
            $direction = $request->direction;

            switch($sortField) {
                case 'mandant':
                    $query->orderBy(function($q) {
                        return Contact::select('nom')
                            ->whereColumn('contacts.id', 'mandats.contact_id')
                            ->limit(1);
                    }, $direction);
                    break;
                case 'suivi':
                    $query->orderBy(function($q) {
                        return User::select(DB::raw("CONCAT(nom, ' ', prenom)"))
                            ->whereColumn('users.id', 'mandats.suivi_par_id')
                            ->limit(1);
                    }, $direction);
                    break;
                default:
                    $query->orderBy($sortField, $direction);
            }
        } else {
            $query->orderBy('created_at', 'desc');
        }

        $mandats = $query->paginate(50);
 
        
        $mandataires = User::mandatairesActifs();
        return view('mandat.index', compact('mandats', 'mandataires'));
    }

    /**
     * Génère le prochain numéro de mandat
     */
    private function getNextMandatNumber()
    {
        $lastMandat = Mandat::orderBy('numero', 'desc')->first();
        
        if ($lastMandat && $lastMandat->numero) {
            return $lastMandat->numero + 1;
        }
        
        // Si aucun mandat n'existe, utiliser la valeur de démarrage depuis .env
        return env('START_MANDAT', 1);
    }

    /**
     * Réserve un mandat pour un mandataire.
     *
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function reserver(Request $request)
    {
        $request->validate([
            'nom_reservation' => 'required',
        ]);

        $mandataire = User::where('id', $request->mandataire_id)->first();
        
        if ($mandataire->quota_mandats <= 0) {
            // return back()->withErrors(['error' => 'Quota atteint !']);
        }

        Mandat::create([
            'user_id' => Auth::user()->id,
            'suivi_par_id' => $mandataire->id,
            'nom_reservation' => $request->nom_reservation,
            'statut' => 'réservation',
            'numero' => $this->getNextMandatNumber()
        ]);

        // $mandataire->decrement('quota_mandats_non_retournes');
        return response()->json(['success' => true]);

    }

    /**
     * Réserve un mandat par sms pour un mandataire.
     *
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function reserver_par_sms(Request $request)
    {
        $request->validate([
            'nom_reservation' => 'required',
        ]);

        $mandataire = User::where('code_unique', $request->code_unique)->first();

        if ($mandataire->quota_mandats <= 0) {
            return back()->withErrors(['error' => 'Quota atteint !']);
        }

        Mandat::create([
            'type' => 'Vente',
            'nature' => 'Simple',
            'user_id' => $mandataire->id,
            'nom_reservation' => $request->nom_reservation,
            'statut' => 'réservation',
            'numero' => $this->getNextMandatNumber()
        ]);

        // $mandataire->decrement('quota_mandats_non_retournes');

        return redirect()->route('mandat.index')->with('success', 'Mandat réservé !');
    }

    /**
     * Affiche le formulaire de création d'un mandat
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $mandataires = User::mandatairesActifs();
        return view('mandat.add', compact('mandataires'));
    }
    /**
     * Formulaire de modification d'un mandat
     * @param int $id identifiant du mandat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
       
        $mandat = Mandat::findOrFail(Crypt::decrypt($id));
        $mandataires = User::mandatairesActifs();
        return view('mandat.edit', compact('mandat', 'mandataires'));
    }

    /**
     * Enregistre un nouveau mandat
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validation des données avec messages personnalisés
            $messages = [
                'type_mandat.required' => 'Le type de mandat est obligatoire',
                'nature_mandat.required' => 'La nature du mandat est obligatoire',
                'type_contact.required' => 'Le type de contact est obligatoire',
                'type_bien.required' => 'Le type de bien est obligatoire',
                'date_debut.required' => 'La date de début est obligatoire',
                'date_fin.required' => 'La date de fin est obligatoire',
            ];

            $validator = Validator::make($request->all(), [
                'type_mandat' => 'required',
                'nature_mandat' => 'required',
                'type_contact' => 'required',
                'type_bien' => 'required',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after:date_debut',
                'suivi_par_id' => Auth::user()->role == 'admin' ? 'required|exists:users,id' : '',
            ], $messages);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();
            
            // 1. Création du contact si nouveau
            $contact_id = null;
            if ($request->type_contact != 'contact_existant') {
                $contact = new Contact;

                $contact->type_contact = $request->type_contact;

                switch($request->type_contact) {
                    case 'personne_physique':
                        $contact->civilite = $request->civilite;
                        $contact->nom = $request->nom;
                        $contact->prenom = $request->prenom;
                        $contact->adresse = $request->adresse;
                        $contact->code_postal = $request->code_postal;
                        $contact->ville = $request->ville;
                        break;

                    case 'couple':
                        $contact->civilite_p1 = $request->civilite_p1;
                        $contact->nom_p1 = $request->nom_p1;
                        $contact->prenom_p1 = $request->prenom_p1;
                        $contact->email_p1 = $request->email_p1;
                        $contact->telephone_p1 = $request->telephone_p1;
                        $contact->adresse_p1 = $request->adresse_p1;
                        $contact->code_postal_p1 = $request->code_postal_p1;
                        $contact->ville_p1 = $request->ville_p1;
                        
                        $contact->civilite_p2 = $request->civilite_p2;
                        $contact->nom_p2 = $request->nom_p2;
                        $contact->prenom_p2 = $request->prenom_p2;
                        $contact->email_p2 = $request->email_p2;
                        $contact->telephone_p2 = $request->telephone_p2;
                        $contact->adresse_p2 = $request->adresse_p2;
                        $contact->code_postal_p2 = $request->code_postal_p2;
                        $contact->ville_p2 = $request->ville_p2;
                        break;

                    case 'entreprise':
                        $contact->raison_sociale = $request->raison_sociale;
                        $contact->adresse = $request->adresse_entreprise;
                        $contact->code_postal = $request->code_postal_entreprise;
                        $contact->ville = $request->ville_entreprise;
                        break;
                    
                    case 'indivision':
                        $contact->nom_indivision = $request->nom_indivision;
                        $contact->nom = $request->nom_contact;
                        $contact->adresse = $request->adresse_contact;
                        $contact->code_postal = $request->code_contact;
                        $contact->ville = $request->ville_contact;
                        break;
                    case 'tiers':
                        $contact->nom = $request->nom_tiers;
                        $contact->adresse = $request->adresse_tiers;
                        $contact->code_postal = $request->code_postal_tiers;
                        $contact->ville = $request->ville_tiers;
                    
                        break;
                }

                $contact->email = $request->email;
                $contact->telephone = $request->telephone;
                
                $contact->user_id = Auth::id();
             
                $contact->save();
                
                $contact_id = $contact->id;
            } else {
                $contact_id = $request->contact_id;
            }

            // 2. Création du bien
            $bien = new Bien();
            $bien->user_id = Auth::id();
            $bien->type_bien = $request->type_bien;
            $bien->adresse = $request->adresse_bien;
            $bien->ville = $request->ville_bien;
            $bien->code_postal = $request->code_postal_bien;
            $bien->save();

            // 3. Création du mandat avec les nouveaux champs
            $mandat = new Mandat();
            $mandat->type = $request->type_mandat;
            $mandat->statut = 'mandat';
            $mandat->nature = $request->nature_mandat;
            $mandat->user_id = Auth::id();
            $mandat->suivi_par_id = $request->suivi_par_id ?? Auth::id();
            $mandat->contact_id = $contact_id;
            $mandat->bien_id = $bien->id;
            $mandat->date_debut = $request->date_debut;
            $mandat->date_fin = $request->date_fin;
            $mandat->duree_tacite_reconduction = $request->tacite_reconduction;
            $mandat->duree_irrevocabilite = $request->duree_irrevocabilite;
            $mandat->numero = $this->getNextMandatNumber();
            $mandat->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Le Mandat '.$mandat->numero.' a été créé avec succès',
                'redirect' => route('mandat.index')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la création du mandat: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Mise à jour d'un mandat
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            // Ajout de la méthode PUT pour la mise à jour
            $request->merge(['_method' => 'PUT']);
            
            $validator = Validator::make($request->all(), [
                'type_mandat' => 'required',
                'nature_mandat' => 'required',
                'type_contact' => 'required',
                'type_bien' => 'required',
                'date_debut' => 'required|date',
                'date_fin' => 'required|date|after:date_debut',
                'suivi_par_id' => Auth::user()->role == 'admin' ? 'required|exists:users,id' : '',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            DB::beginTransaction();

            try {
                $mandat = Mandat::findOrFail($id); // Suppression du Crypt::decrypt
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Mandat introuvable'
                ], 404);
            }

            // 1. Mise à jour du contact
            if ($request->type_contact != 'contact_existant') {
                if (!$mandat->contact || $request->nouveau_contact == 'Oui') {
                    $contact = new Contact();
                    $contact->user_id = Auth::id();
                } else {
                    $contact = $mandat->contact;
                }

                $contact->type_contact = $request->type_contact;

                switch($request->type_contact) {
                    case 'personne_physique':
                        $contact->civilite = $request->civilite;
                        $contact->nom = $request->nom;
                        $contact->prenom = $request->prenom;
                        $contact->email = $request->email;
                        $contact->telephone = $request->telephone;
                        $contact->adresse = $request->adresse;
                        $contact->code_postal = $request->code_postal;
                        $contact->ville = $request->ville;
                        break;

                    case 'couple':
                        $contact->civilite_p1 = $request->civilite_p1;
                        $contact->nom_p1 = $request->nom_p1;
                        $contact->prenom_p1 = $request->prenom_p1;
                        $contact->email_p1 = $request->email_p1;
                        $contact->telephone_p1 = $request->telephone_p1;
                        $contact->adresse_p1 = $request->adresse_p1;
                        $contact->code_postal_p1 = $request->code_postal_p1;
                        $contact->ville_p1 = $request->ville_p1;
                        
                        $contact->civilite_p2 = $request->civilite_p2;
                        $contact->nom_p2 = $request->nom_p2;
                        $contact->prenom_p2 = $request->prenom_p2;
                        $contact->email_p2 = $request->email_p2;
                        $contact->telephone_p2 = $request->telephone_p2;
                        $contact->adresse_p2 = $request->adresse_p2;
                        $contact->code_postal_p2 = $request->code_postal_p2;
                        $contact->ville_p2 = $request->ville_p2;
                        break;
                    
                    case 'entreprise':
                        $contact->raison_sociale = $request->raison_sociale;
                        $contact->adresse = $request->adresse_entreprise;
                        $contact->code_postal = $request->code_postal_entreprise;
                        $contact->ville = $request->ville_entreprise;
                        break;
                    
                    case 'indivision':
                        $contact->nom_indivision = $request->nom_indivision;
                        $contact->nom = $request->nom_contact;
                        $contact->adresse = $request->adresse_contact;
                        $contact->code_postal = $request->code_postal_contact;
                        $contact->ville = $request->ville_contact;
                        break;
                    case 'tiers':
                        $contact->nom = $request->nom_tiers;
                        $contact->adresse = $request->adresse_tiers;
                        $contact->code_postal = $request->code_postal_tiers;
                        $contact->ville = $request->ville_tiers;
                    
                        break;
                }

                $contact->save();
                $contact_id = $contact->id;
            } else {
                $contact_id = $request->contact_id;
            }

            // 2. Mise à jour du bien
            if (!$mandat->bien) {
                $bien = new Bien();
                $bien->user_id = Auth::id();
            } else {
                $bien = $mandat->bien;
            }

            $bien->type_bien = $request->type_bien;
            $bien->adresse = $request->adresse_bien;
            $bien->ville = $request->ville_bien;
            $bien->code_postal = $request->code_postal_bien;
            $bien->save();

            // 3. Mise à jour du mandat
            $mandat->type = $request->type_mandat;
            $mandat->statut = 'mandat';
            $mandat->nature = $request->nature_mandat;
            $mandat->suivi_par_id = $request->suivi_par_id ?? Auth::id();
            $mandat->contact_id = $contact_id;
            $mandat->bien_id = $bien->id;
            $mandat->date_debut = $request->date_debut;
            $mandat->date_fin = $request->date_fin;
            $mandat->duree_tacite_reconduction = $request->tacite_reconduction;
            $mandat->duree_irrevocabilite = $request->duree_irrevocabilite;
            $mandat->save();

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Le Mandat '.$mandat->numero.' a été modifié avec succès',
                'redirect' => route('mandat.index')
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la modification du mandat: ' . $e->getMessage()
            ], 500);
        }
    }

    public function store_reservation(Request $request)
    {
        $request->validate([
            'nom_reservation' => 'required|string|max:255'
        ]);

        // Créer la réservation dans la base de données
        $reservation = new Mandat();
        $reservation->nom = $request->nom_reservation;
        $reservation->statut = 'réservation';
        $reservation->user_id = Auth::user()->id;
        // Ajoutez d'autres champs si nécessaire
        $reservation->save();

        return response()->json(['success' => true]);
    }

    /**
     * Mise à jour d'une réservation
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mandat  $mandat
     * @return \Illuminate\Http\JsonResponse
     */
    public function update_reservation(Request $request, Mandat $mandat)
    {
        $request->validate([
            'nom_reservation' => 'required',
        ]);

        $mandat->nom_reservation = $request->nom_reservation;
        
        if(Auth::user()->role == 'admin' && $request->mandataire_id) {
            $mandat->suivi_par_id = $request->mandataire_id;
        }
        
        $mandat->save();

        return response()->json(['success' => true]);
    }

       /**
     * Mise à jour d'une réservation
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mandat  $mandat
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateReservationExterne(Request $request, $id)
    {
        $request->validate([
            'nom_reservation' => 'required',
        ]);

        $mandat = Mandat::findOrFail($id);

        $mandat->nom_reservation = $request->nom_reservation;
        $mandat->save();

        return response()->json(['success' => true]);
    }


    
    /**
     * Retourne la liste des contacts, filtrés par l'utilisateur connecté
     * si l'utilisateur n'est pas admin.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getContacts()
    {
        if(Auth::user()->role == 'admin') {
            $contacts = Contact::all();
        } else {
            $contacts = Contact::where('user_id', Auth::user()->id)->get();
        }
        return response()->json($contacts);
    }

    /**
     * Afficher les détails d'un mandat
     *
     * @param  \App\Mandat  $mandat
     * @return \Illuminate\Http\Response
     */
    public function show($mandat_id)
    {
        $mandat = Mandat::findOrFail(Crypt::decrypt($mandat_id));
        return view('mandat.show', compact('mandat'));
    }

    public function cloturer(Request $request, $id)
    {
        
        try {
            $validator = Validator::make($request->all(), [
                'raison_cloture' => 'required',
                'autre_raison' => 'required_if:raison_cloture,autre'
            ]);
           
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Veuillez remplir tous les champs obligatoires'
                ], 422);
            }

            $mandat = Mandat::findOrFail(Crypt::decrypt($id));
            
            $raison = $request->raison_cloture === 'autre' 
                ? $request->autre_raison 
                : $request->raison_cloture;

            $mandat->update([
                'est_cloture' => true,
                'motif_cloture' => $raison,
                'date_cloture' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Le mandat a été clôturé avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la clôture du mandat'.$e->getMessage()
            ], 500);
        }
    }

    /**
     * Affiche la page de sélection du type de mandat (nouveau ou réservation)
     */
    public function selectType()
    {
        // Récupérer les réservations selon le rôle
        if(Auth::user()->role == 'admin') {
            $reservations = Mandat::where('statut', 'réservation')->orderBy('created_at', 'desc')->get();
        } else {
            $reservations = Mandat::where([
                ['statut', 'réservation'],
                ['suivi_par_id', Auth::id()]
            ])->orderBy('created_at', 'desc')->get();
        }

        // Si aucune réservation, rediriger vers la création
        if($reservations->isEmpty()) {
            return redirect()->route('mandat.create');
        }

        return view('mandat.select_type', compact('reservations'));
    }

    /**
     * Affiche la page de réservation externe
     */
    public function reservationExterne()
    {
        return view('mandat.reservation_externe');
    }

    /**
     * Vérifie si le code client est valide
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */ 
    public function checkCode(Request $request)
    {
        $request->validate([
            'code_client' => 'required'
        ]);

        $user = User::where('code_client', $request->code_client)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Code client invalide'
            ], 404);
        }

        $reservations = Mandat::where([
            ['user_id', $user->id],
            ['statut', 'réservation']
        ])->orderBy('created_at', 'desc')->get();

        return response()->json([
            'success' => true,
            'user' => $user,
            'reservations' => $reservations
        ]);
    }
    /**
     * Réserve un mandat depuis la page de réservation externe
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function reserverExterne(Request $request)
    {
        $request->validate([
            'code_client' => 'required',
            'nom_reservation' => 'required'
        ]);

        $user = User::where('code_client', $request->code_client)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Code client invalide'
            ], 404);
        }

        $nb_mandats_non_retournes = Mandat::nonRetournesParUser($user->id)->count();

        if ($user->quota_mandats_non_retournes <= $nb_mandats_non_retournes) {
            return response()->json([
                'success' => false,
                'message' => 'Quota de mandats non retorunés atteint ('.$nb_mandats_non_retournes.'/'.$user->quota_mandats_non_retournes.')'
            ], 422);
        }

        $nb_reservations = Mandat::reservationsParUser($user->id)->count();

        if ($user->quota_reservation_en_cours <= $nb_reservations) {
            return response()->json([
                'success' => false,
                'message' => 'Quota de réservations atteint ('.$nb_reservations.'/'.$user->quota_reservation_en_cours.')'
            ], 422);
        }

        $mandat = Mandat::create([
            'user_id' => $user->id,
            'suivi_par_id' => $user->id,
            'statut' => 'réservation',
            'nom_reservation' => $request->nom_reservation,
            'statut' => 'réservation',
            'numero' => $this->getNextMandatNumber()
        ]);

        // $user->decrement('quota_mandats_non_retournes');

        return response()->json([
            'success' => true,
            'numero_mandat' => $mandat->numero,
            'message' => 'Réservation créée avec succès'
        ]);
    }

    /**
     * Affiche la page des paramètres des mandats
     */
    public function parametres()
    {
        $users = User::mandatairesActifs();
        // dd($users); 
        return view('mandat.parametres', compact('users'));
    }

    /**
     * Met à jour les paramètres de mandat d'un utilisateur
     */
    public function updateParametres(Request $request, User $user)
    {
        $request->validate([
            'quota_mandats_non_retournes' => 'required|integer|min:0',
            'quota_reservation_en_cours' => 'required|integer|min:0',
        ]);

        $user->update([
            'quota_mandats_non_retournes' => $request->quota_mandats_non_retournes,
            'quota_reservation_en_cours' => $request->quota_reservation_en_cours,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Paramètres mis à jour avec succès'
        ]);
    }

    /**
     * Restaure un mandat clôturé
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mandat  $mandat
     * @return \Illuminate\Http\JsonResponse
     */
    public function restaurer(Request $request, $id)
    {
        try {
            $mandat = Mandat::findOrFail(Crypt::decrypt($id));
            
            $mandat->update([
                'est_cloture' => false,
                'motif_cloture' => null,
                'date_cloture' => null
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Le mandat a été restauré avec succès'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue lors de la restauration du mandat'
            ], 500);
        }
    }

    public function statistiques()
    {
        $stats = [
            'total_mandats' => Mandat::where('statut', 'mandat')->count(),
            'mandats_mois' => Mandat::where('statut', 'mandat')
                ->whereMonth('created_at', now()->month)
                ->count(),
            'reservations_actives' => Mandat::where('statut', 'réservation')->count(),
            'non_retournes' => Mandat::where('statut', 'mandat')
                ->where('est_retourne', false)
                ->count(),
            
            // Stats par mandataire - Correction de la jointure
            'non_retournes_par_mandataire' => User::join('contrats', 'users.id', '=', 'contrats.user_id')
                ->where('users.role', 'mandataire')
                ->where('contrats.a_demission', false)
                ->select('users.*', 'contrats.a_demission')
                ->get()
                ->map(function($user) {
                    return [
                        'nom' => $user->nom . ' ' . $user->prenom,
                        'count' => Mandat::nonRetournesParUser($user->id)->count(),
                        'quota' => $user->quota_mandats_non_retournes
                    ];
                }),

            // Données d'évolution
            'evolution' => $this->getEvolutionData()
        ];

        return view('mandat.statistiques', compact('stats'));
    }

    private function getEvolutionData()
    {
        $months = collect(range(5, 0))->map(function($i) {
            return now()->subMonths($i)->format('Y-m');
        });

        $mandats = $months->map(function($month) {
            return Mandat::where('statut', 'mandat')
                ->whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count();
        });

        $reservations = $months->map(function($month) {
            return Mandat::where('statut', 'réservation')
                ->whereYear('created_at', substr($month, 0, 4))
                ->whereMonth('created_at', substr($month, 5, 2))
                ->count();
        });

        return [
            'labels' => $months->map(function($month) {
                return \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y');
            }),
            'mandats' => $mandats,
            'reservations' => $reservations
        ];
    }

    /**
     * Affiche la page d'importation de mandats
     */
    public function import()
    {
        return view('mandat.import');
    }

    /**
     * Traite l'importation de mandats
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls'
        ]);

        try {
            $path = $request->file('file')->store('temp');
            $data = Excel::toArray([], storage_path('app/' . $path));
            $rows = $data[0];
            array_shift($rows); // Enlever l'en-tête
            
            // Prendre les 30 premières lignes
            $preview = array_slice($rows, 0, 1000);
            $formattedPreview = [];
            
            foreach($preview as $row) {
                // Traitement de la date et du mandataire
                preg_match('/(\d{2}\/\d{2}\/\d{4})\s*(?:\((.*?)\))?\s*(\d{2}\/\d{2}\/\d{4})?/', $row[1], $matches);
                
                $dateDebut = $matches[1] ?? null;
                $mandataire = isset($matches[2]) ? trim($matches[2]) : null;
                $dateFin = $matches[3] ?? null;

                // Traitement du mandant et de l'adresse du mandat
                $nomMandant = trim($row[2] ?? '');
                $adresseMandat = trim($row[3] ?? '');

                // Traitement du type de mandat
                $typeMandat = $row[4] ?? '';
                $typeExtrait = '';
                if (stripos($typeMandat, 'vente') !== false) {
                    $typeExtrait = 'vente';
                } elseif (stripos($typeMandat, 'recherche') !== false) {
                    $typeExtrait = 'recherche';
                }

                $formattedPreview[] = [
                    'numero' => $row[0] ?? '',
                    'date_debut' => $dateDebut,
                    'mandataire' => $mandataire,
                    'date_fin' => $dateFin,
                    'mandant' => $nomMandant,
                    'adresse_mandat' => $adresseMandat,
                    'type_mandat' => [
                        'original' => $typeMandat,
                        'extrait' => $typeExtrait
                    ],
                    'adresse_bien' => $row[5] ?? '',
                    'observations' => $row[6] ?? ''
                ];
            }

            // Supprimer le fichier temporaire
            Storage::delete($path);
            
            return back()->with('preview', $formattedPreview);

        } catch (\Exception $e) {
            return back()->with('error', 'Erreur lors de la lecture du fichier : ' . $e->getMessage());
        }
    }
}
