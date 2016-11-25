<?php

namespace ESCOJ\Http\Controllers;

use Illuminate\Http\Request;
use EscojLB\Repo\Source\SourceInterface;

use ESCOJ\Http\Requests\SourceAddOrUpdateRequest;

class SourceController extends Controller
{

    protected $source;

    public function __construct(SourceInterface $source){

        $this->middleware('auth');
        $this->middleware('adminOrProblemSetter');


        $this->source = $source;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $name = ($request->has('name')) ? $request->name : null;
        
        $sources = $this->source->getAllPaginate(5, $name);
       
        $request->flash();
        return view('source.index',['sources' => $sources]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('source.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SourceAddOrUpdateRequest $request)
    {
        //
        if($this->source->create($request->name))
            flash('The source has been created successfully','success')->important();
        else
            flash('Could not create the source','warning')->important();
        return redirect()->route('source.index');
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
        $source = $this->source->findById($id);

        return view('source.update',['source' => $source]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SourceAddOrUpdateRequest $request, $id)
    {
        if($this->source->update($request->name,$id))
            flash('The source has been updated successfully.','success')->important();
        else
            flash('The source could not be updated.','warning')->important();
        return redirect()->route('source.index');
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
