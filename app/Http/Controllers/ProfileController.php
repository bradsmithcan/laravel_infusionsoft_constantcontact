<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManagerStatic as Image;
use App\Models\Profile;

class ProfileController extends Controller
{
    private $imagePath = "images/profiles/";

    private $profiles;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Profile $childprofile)
    {
        if(!empty( $parentId = Auth::user()->parent_user)){
            $this->profiles  = $childprofile->where('parent_id', '=', $parentId)->orWhere('parent_id', '=', Auth::user()->id)->get();
        }else{
            $this->profiles = $childprofile->where('parent_id', '=', Auth::user()->id)->get();
        }
        return view('profile.index', array('profile' => $this->profiles,'image_path' => $this->imagePath));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('profile.create');
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
            'title' => 'required',
            'url' => 'required',
        ];

        $this->validate($request, $rules);
        $file = $request->file('image');

        $child = new Profile();

        /*
         * storing and converting image to 200 * 200 also
         */

        if ($file !== null) {

            $extension  = $file->getClientOriginalExtension();

            $resizeName = $file->getFilename() . '-200.' . $extension;
            $imagePath  = $file->getFilename() . '.' . $extension;

            $image = $file->move($this->imagePath,$imagePath, File::get($file));
            Image::make($image->getRealPath())->resize(200, 200)->save($this->imagePath.$resizeName);

            $child->child_pic_resize = $resizeName;
            $child->child_pic = $imagePath;

        }

        $child->child_name     = $request->title;
        $child->child_home_url = $request->url;
        $child->parent_id      = Auth::user()->id;

        $child->save();

        return redirect('profile');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('profile.create');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $profile = Profile::find($id);
        return view('profile.edit',array('profile' => $profile,'image_path' => $this->imagePath));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id , Request $request)
    {

        // validate
        // read more on validation at http://laravel.com/docs/validation
        $rules = [
            'title' => 'required',
            'url' => 'required',
        ];

        $this->validate($request, $rules);

        // process the login
            // store

            $file = $request->file('image');
            $child = Profile::find($id);

            if ($file !== null) {

                $extension  = $file->getClientOriginalExtension();

                $resizeName = $file->getFilename() . '-200.' . $extension;
                $imagePath  = $file->getFilename() . '.' . $extension;

                $image = $file->move($this->imagePath,$imagePath, File::get($file));
                Image::make($image->getRealPath())->resize(200, 200)->save($this->imagePath.$resizeName);

                $child->child_pic_resize = $resizeName;
                $child->child_pic = $imagePath;

            }

            $child->child_name     = $request->title;
            $child->child_home_url = $request->url;
            $child->parent_id      = Auth::user()->id;
            $child->save();

            // redirect
            \Session::flash('message', 'Successfully updated profile!');
            return \Redirect::to('profile');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        // delete

        $profile = Profile::find($id);
        $profile->delete();

        // redirect
        \Session::flash('message', 'Successfully deleted the profile!');
        return \Redirect::to('profile');

    }
}
