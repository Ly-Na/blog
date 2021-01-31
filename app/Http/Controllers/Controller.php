<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Salle;
use App\Models\Reservation;
use DateTime;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dashboard ()
    {
        $Salles = Salle::all();
        $Reservations = Reservation::where('date', '=', (new DateTime())->format('Y-m-d'))->get();

   return view('dashboard', compact('Reservations','Salles'));
        
    }
}
