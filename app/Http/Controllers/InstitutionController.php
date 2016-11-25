<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;
use EscojLB\Repo\Institution\InstitutionInterface;
use EscojLB\Repo\Country\CountryInterface;


use ESCOJ\Http\Requests\InstitutionAddOrUpdateRequest;

class InstitutionController extends Controller
{

    protected $institution;
    protected $country;

    public function __construct(InstitutionInterface $institution, CountryInterface $country){

        $this->middleware('auth');
        $this->middleware('admin');

        $this->institution = $institution;
        $this->country = $country;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = ($request->has('name')) ? $request->name : null;
        $country = ($request->has('country')) ? $request->country : null;

        
        $institutions = $this->institution->getAllPaginate(5, $name, $country);
       	$countries = $this->country->getkeyValueAll('id','name');

        $request->flash();
        return view('institution.index',['institutions' => $institutions, 'countries' => $countries]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
       	$countries = $this->country->getkeyValueAll('id','name');

        return view('institution.add',['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InstitutionAddOrUpdateRequest $request)
    {
        //
        if($this->institution->create($request->name, $request->country))
            flash('The institution has been created successfully','success')->important();
        else
            flash('Could not create the institution','warning')->important();
        return redirect()->route('institution.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $institution = $this->institution->findById($id);
       	$countries = $this->country->getkeyValueAll('id','name');
       	
        return view('institution.update',['institution' => $institution, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InstitutionAddOrUpdateRequest $request, $id)
    {
        if($this->institution->update($request->name, $request->country, $id))
            flash('The institution has been updated successfully.','success')->important();
        else
            flash('The institution could not be updated.','warning')->important();
        return redirect()->route('institution.index');
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
