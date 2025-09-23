<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function index()
    {
        $countries = Country::all();
        return view('admin.countries.index', compact('countries'));
    }

    public function create()
    {
        return view('admin.countries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            //'code' => 'nullable|string|max:10',
        ]);

        Country::create($request->all());
        return redirect()->route('countries.index')->with('success', 'Country added!');
    }

    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    public function update(Request $request, Country $country)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            //'code' => 'nullable|string|max:10',
        ]);

        $country->update($request->all());
        return redirect()->route('countries.index')->with('success', 'Country updated!');
    }

    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('countries.index')->with('success', 'Country deleted!');
    }
}