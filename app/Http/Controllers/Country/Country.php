<?php

namespace App\Http\Controllers\Country;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\CountryModel;
use Validator;


class Country extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countryList = CountryModel::paginate(10);
        return response()->json($countryList,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:3',
            'iso' => 'required|min:2|max:2|unique:_z_country',
            'dname' =>'required|unique:_z_country',
            'numcode' => 'required|numeric',
            'phonecode' => 'required|numeric',
            'created' => 'required|numeric',
            'register_by' => 'required|numeric',
            'modified' => 'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400); 
        }
        $country= CountryModel::create($request->all());
        return response()->json($country, 201);    
    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $country = CountryModel::find($id);
        if (is_null($country)){
            return response()->json(["message" => "Record Not Found!"],404);
        }
        return response()->json($country,200);
   
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $country = CountryModel::find($id);

        if (is_null($country)) {
            return response()->json(["message" => "Record Not Found!"], 200);
        }
        $country->update($request->all());
        return response()->json($country, 200);    
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = CountryModel::find($id);
        if (is_null($country)) {
            return response()->json(["message" => "Record Not Found!"], 200);
        }
        $country->delete();
        return response()->json(["message" => "Record Deleted Successfully!"], 204);    
    
    }
}