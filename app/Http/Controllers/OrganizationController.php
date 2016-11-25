<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;
use EscojLB\Repo\Organization\OrganizationInterface;

use ESCOJ\Http\Requests\OrganizationAddOrUpdateRequest;

class OrganizationController extends Controller
{

    protected $organization;

    public function __construct(OrganizationInterface $organization){

        $this->middleware('auth');
        $this->middleware('adminProblemSetterOrCoach');


        $this->organization = $organization;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = ($request->has('name')) ? $request->name : null;
        
        $organizations = $this->organization->getAllPaginate(5, $name);
       
        $request->flash();
        return view('organization.index',['organizations' => $organizations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('organization.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganizationAddOrUpdateRequest $request)
    {
        //
        if($this->organization->create($request->name))
            flash('The organization has been created successfully','success')->important();
        else
            flash('Could not create the organization','warning')->important();
        return redirect()->route('organization.index');
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
        $organization = $this->organization->findById($id);

        return view('organization.update',['organization' => $organization]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrganizationAddOrUpdateRequest $request, $id)
    {
        if($this->organization->update($request->name,$id))
            flash('The organization has been updated successfully.','success')->important();
        else
            flash('The organization could not be updated.','warning')->important();
        return redirect()->route('organization.index');
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
