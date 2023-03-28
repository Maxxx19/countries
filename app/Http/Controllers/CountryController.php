<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($continent, $sorting)
    {
        if ($continent != 0) {
            if ($sorting != 0) {
                $countries = Country::where('continent_code', $continent)->orderBy('country_id', $sorting)->paginate(10);
            } else {
                $countries = Country::where('continent_code', $continent)->paginate(10);
            }
        } else {
            if ($sorting != 0) {
                $countries = Country::orderBy('country_id', $sorting)->paginate(10);
            } else {
                $countries = Country::paginate(10);
            }
        }

        return  response()->json(['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50|unique:countries',
            'code' => 'required|alpha|uppercase|max:2||min:2|unique:countries',
            'full_name' => 'required|max:100|unique:countries',
            'iso3' => 'required|regex:/^[a-zA-Z]+$/u|uppercase|max:3|min:3',
            'number' => 'required|integer|digits:3',
            'continent_code' => 'required|alpha|uppercase|max:2|min:2',
            'display_order' => 'required|integer|digits_between:1,3',
        ]);

        $input = $request->all();

        Country::create($input);

        return redirect()->route('countries.index', ['continent' => 0, 'sorting' => 0]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = Country::where('country_id', $id)->first();

        return  response()->json(['country' => $country]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
