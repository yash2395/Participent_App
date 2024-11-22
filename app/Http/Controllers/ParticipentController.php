<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Participent;
use Illuminate\Http\Request;
use App\Models\ParticipentAddress;
use Illuminate\Support\Facades\Hash;

class ParticipentController extends Controller
{

    public function showListView()
    {
        return view('participent.index');
    }
    public function index()
    {
        $participents = Participent::with('address', 'address.state', 'address.city')->get();
        // dd($participents->toArray());
        // Return participents data as JSON
        return response()->json(['data' => $participents], 200);
    }
    public function create()
    {
        // dd('hi');
        $states = State::all();

        return view('participent.create', compact('states'));
    }

    public function store(Request $request)
    {

        // dd($request->all());

        $participent = Participent::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'mobile' => $request->mobile,
            'is_active' => true,
        ]);

        ParticipentAddress::create([
            'participent_id' => $participent->id,
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);



        return redirect()->route('participent.list')->with('success', 'Participent created successfully.');
    }
    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)->get();
        return response()->json(['cities' => $cities]);
    }

    public function updateStatus($id, Request $request)
    {
        // dd('hi');
        $participant = Participent::findOrFail($id);
        $participant->is_active = $request->is_active;
        $participant->save();

        return response()->json(['message' => 'Status updated successfully']);
    }


    public function edit($id)
    {
        $participent = Participent::with('address')->findOrFail($id);
        $states = State::all();
        $cities = City::where('state_id', $participent->address->state_id)->get();


        return view('participent.edit', compact('participent', 'states', 'cities'));
    }

    public function update(Request $request, $id)
    {


        $participent = Participent::findOrFail($id);

        $participent->update([
            'name' => $request->name,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'is_active' => $request->has('is_active'),
        ]);

        $participent->address->update([
            'state_id' => $request->state_id,
            'city_id' => $request->city_id,
            'address' => $request->address,
        ]);

        if ($request->filled('password')) {
            $participent->update(['password' => Hash::make($request->password)]);
        }

        return response()->json(['message' => 'Participant updated successfully', 'data' => $participent], 200);
    }


    public function destroy($id)
    {
        $participent = Participent::find($id);

        if ($participent) {
            ParticipentAddress::where('participent_id', $id)->delete();
            $participent->delete();
        }

        return redirect()->route('participent.list')->with('success', 'Participant deleted successfully.');
    }
}
