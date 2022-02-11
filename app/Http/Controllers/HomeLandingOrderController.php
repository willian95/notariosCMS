<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeLandingOrder;

class HomeLandingOrderController extends Controller
{


    function store(Request $request){

        $homeLanding = new HomeLandingOrder;
        $homeLanding->order = $request->order;
        $homeLanding->project_id = $request->project_id;
        $homeLanding->save();

        return response()->json(["message" => "Orden agregado", "success" => true]);

    }

    function update(Request $request){

        $homeLanding = HomeLandingOrder::find($request->homeOrderId);
        $homeLanding->order = $request->order;
        $homeLanding->project_id = $request->project_id;
        $homeLanding->update();

        return response()->json(["message" => "Orden agregado", "success" => true]);

    }

    function delete(Request $request){

        $homeLanding = HomeLandingOrder::where("id", $request->id)->first();
        $homeLanding->delete();

        return response()->json(["message" => "Orden eliminado", "success" => true]);

    }

    function fetch(){
        $homeLanding = HomeLandingOrder::all();
        return response()->json($homeLanding);
    }

}
