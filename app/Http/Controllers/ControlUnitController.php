<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ControlUnit;

class ControlUnitController extends Controller
{
    public function index()
    {
        $controlUnits = ControlUnit::all();

        // load the view and pass the sharks
        return response()->json([
            'controlUnits' => $controlUnits
        ]);
    }

    public function create(Request $request)
    {
        $controlUnit = new ControlUnit;
        $controlUnit->name = $request->input('name');
        $controlUnit->address = $request->input('address');
        $controlUnit->city = $request->input('city');
        $controlUnit->cap = $request->input('cap');
        $controlUnit->country = $request->input('country');
        $controlUnit->user_id = $request->input('user_id');
        $controlUnit->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Control unit created successfully',
            'controlUnit' => $controlUnit
        ]);
    }


    /**
        * Store a newly created resource in storage.
        *
        * @return Response
        */

    /**
        * Display the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
    public function show($id)
    {
        $controlUnit = ControlUnit::findOrFail($id);
    
        return response()->json([
            'status' => 'success',
            'controlUnit' => $controlUnit
        ]);
    }
        

    /**
        * Show the form for editing the specified resource.
        *
        * @param  int  $id
        * @return Response
        */
    public function edit($id)
    {
        $controlUnit = ControlUnit::findOrFail($id);
    
        return response()->json([
            'status' => 'success',
            'controlUnit' => $controlUnit
        ]);
    }
        

    /**
        * Update the specified resource in storage.
        *
        * @param  int  $id
        * @return Response
        */
    public function update(ControlUnit $id)
    {
        return response()->json([
            'status' => 'success',
            'controlUnit' => $controlUnit
        ]);
    }

    /**
        * Remove the specified resource from storage.
        *
        * @param  int  $id
        * @return Response
        */
    public function destroy($id)
    {
        $controlUnit = ControlUnit::find($id);
        $controlUnit->delete();

        // redirect
        Session::flash('message', 'Successfully deleted the controlUnit!');
        return Redirect::to('controlUnits');
    }
}
