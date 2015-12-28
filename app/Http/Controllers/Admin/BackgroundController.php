<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Background;
use Illuminate\Support\Facades\File;

class BackgroundController extends Controller
{
    private $imagePath = "images/backgrounds/";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Background $backgrounds)
    {
        $backgrounds = $backgrounds->all();

        return view('background.index', compact('backgrounds'));
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
        $data = $request;

        $rules = [
            'file' => 'required'
        ];
        $this->validate($data, $rules);

        $file = $request->file('file');

        if ($file !== null)
        {
            $filename_with_ex = $file->getClientOriginalName();
            $imagePath = rand(1, 1000).'-'.$filename_with_ex;
            $image = $file->move($this->imagePath, $imagePath, File::get($file));
            if($image)
            {
                $data['name'] = $imagePath;
            }
        }

        Background::create($data->all());

        return redirect('admin/backgrounds');
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
        $background = Background::find($id);

        $filename = $background['name'];
        $default_backgrounds = ['home-bg1.jpg','home-bg2.jpg','home-bg3.jpg','home-bg4.jpg', 'home-bg5.jpg', 'home-bg6.jpg'];

        if(!in_array($filename,$default_backgrounds))
        {
            $file_path = public_path("images/backgrounds/{$filename}");

            if(File::exists($file_path)) File::delete($file_path);
        }

        Background::destroy($id);

        return redirect('admin/backgrounds');
    }
}
