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
        $services = $user->services()->with('user')->get();
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
        
        $exists = $user->services()->where('serv_id', $request->serv_id)->exists();
        if ($exists) {
            return response()->json(['error' => 'Услуга уже добавлена'], 422);
        }
        
        $user->services()->attach($request->serv_id, [
            'service_date' => $request->service_date
        ]);
        
        return response()->json(['message' => 'Услуга добавлена']);
    }
}