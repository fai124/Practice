<?php

namespace App\Http\Controllers;

use App\Models\Serv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserServiceController extends Controller
{
    public function getUserServices()
    {
        $user = Auth::user();

    if (!$user) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $services = $user->services()
        ->with('user')
        ->withPivot('service_date')
        ->get();

    return response()->json($services);
    }
    
    public function getAvailableServices()
    {
        $services = Serv::with('user')->get();
        return response()->json($services);
    }
    
    public function addServiceToUser(Request $request)
    {
        $request->validate([
            'serv_id' => 'required|exists:servs,id',
            'service_date' => 'required|date'
        ]);
        
        $user = Auth::user();
        $user->services()->attach($request->serv_id, [
            'service_date' => $request->service_date
        ]);
        
        return response()->json(['message' => 'Услуга добавлена']);
    }
}