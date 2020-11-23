<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

use App\Notifications\ReitererAffaire;
use Illuminate\Support\Facades\Notification;
use Auth;
use Illuminate\Notifications\DatabaseNotification;
class NotificationController extends Controller
{
    
    
       /**
     * Liste des notifications
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    

    if(Auth::user()->role == "admin"){
    
        $notifications = DatabaseNotification::all();
        
    
    }else{
        $notifications = Auth::user()->notifications;
        
    }
    
    $notifications->markAsRead();
    
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
