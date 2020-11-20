<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use App\Notifications\ReitererAffaire;
use Illuminate\Support\Facades\Notification;
use Auth;

class NotificationController extends Controller
{
    
    
       /**
     * Liste des notifications
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
    $admins = User::where('role','admin')->first();
    
    
    // dd($admins->notifications[0]->delete());
    
    $notif = array("id"=>$admins->id, "nom"=> $admins->nom, "numero_mandat"=> 15002 );
    
    Notification::send($admins,  new ReitererAffaire($notif));
    
    $notifications = $admins->notifications;
       return view('notifications', compact('notifications'));
    }
    
    /**
     * supprimer les notifications
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id = null)
    {
    
    
    
       if($id != null){
       
            Auth::user()->notifications[$id]->delete();
            
       }else{
       
            Auth::user()->notifications()->delete();
       }
    
    return redirect()->route('notifications.index')->with('ok', "Notification supprimée");

 
    }
}
