<?php

namespace App\Http\Controllers\Admin;

use App\Models\Domains;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DomainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $domains = Domains::all();
        return view('domains.index')->with('domains', $domains);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $types = $this->getTypes();

        return view('domains.create')->with('types',$types);
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
            'name'=> 'required|active_url',
            'status'=> 'required',
        ];

        $this->validate($request, $rules);

        $domainData['name'] = $request->name;
        $domainData['status'] = $request->status;

        Domains::create($domainData);
        return redirect('admin/domain');

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

    public function getTypes(){

        return array(
            '1' =>  'Active',
            '2' =>  'Inactive'
        );

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $domain = Domains::find($id);
        $types  = $this->getTypes();

        return view('domains.edit',compact('types','domain'));
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
        $domain = Domains::find($id);
        $rules = [
            'name'=> 'required|active_url',
            'status'=> 'required',
        ];

        $this->validate($request, $rules);

        $domain->update($request->all());
        return redirect('admin/domain');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $domain = Domains::find($id);
        $domain->delete();
        return redirect('admin/domain');
    }
}
