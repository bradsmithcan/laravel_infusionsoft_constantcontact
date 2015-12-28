<?php

namespace App\Http\Controllers;

use App\Models\Background;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\UserService;
use App\Models\ReLinkSnips;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class GrowPageController extends Controller
{
    private $imagePath = "images/growpage/";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReLinkSnips $growPage)
    {
        $growPages = $growPage->all();

        return view('growpage.index', compact('growPages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = $this->get_services();
        $backgrounds = $this->get_backgrounds();

        return view('growpage.create', compact('services','backgrounds'));
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

        $short_link = $data->domain.'/g/'.$data->url_path;
        $data['short_link'] = $short_link;
        $rules = [];
        if($request['type'] == 0)
        {
            $rules = [
                'api' => 'required'
            ];
        }
        $next_rules = [
            'second' => 'required|min:1|max:999|integer',
            'type' => 'required',
            'btntxt' => 'required',
            'btntxt_color' => 'required',
            'btnurl' => 'required|url',
            'page_url' => 'required|url',
            'domain' => 'required',
            'url_path' => 'required',
            'short_link' => 'unique:relink_snips',
            'title' => 'required',
            'title_color' => 'required',
            'descrip' => 'required',
            'descrip_color' => 'required',
            'bg' => 'required'
        ];
        $rules_result = array_merge($rules, $next_rules);

        $this->validate($data, $rules_result);

        $data['user_id'] = Auth::user()->id;

        $fileName = $request->image;
        
        if ($fileName !== null  && !empty($fileName)) {
            Storage::move('/images/growpage/tmp/'.$fileName, '/images/growpage/'.$fileName);
            $data['upload_path'] = $fileName;
        }

        $growPage = ReLinkSnips::create($data->all());

        $request->session()->flash('relink', $growPage['short_link']);

        return redirect('short-link');
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
        $growPage = ReLinkSnips::findorfail($id);
        $services = $this->get_services();
        $backgrounds = $this->get_backgrounds();

        $path = basename($growPage['short_link']);
        $growPage['url_path'] = $path;

        return view('growpage.edit', compact('growPage','services','backgrounds'));
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
        $growPage = ReLinkSnips::find($id);
        $data = $request;

        $short_link = $data->domain.'/g/'.$data->url_path;
        $data['short_link'] = $short_link;
        $data['user_id'] = Auth::user()->id;

        $rules = [];

        if($growPage->short_link == $data['short_link'] ){
            $rules = [
                'short_link' => 'exists:relink_snips'
            ];
        }else{
            $rules = [
                'short_link' => 'unique:relink_snips'
            ];
        }

        if($request['type'] == 0)
        {
            $rules = [
                'api' => 'required'
            ];
        }

        $next_rules = [
            'second' => 'required|min:1|max:999|integer',
            'btntxt' => 'required',
            'btntxt_color' => 'required',
            'btnurl' => 'required|url',
            'type' => 'required',
            'page_url' => 'required|url',
            'domain' => 'required',
            'url_path' => 'required',
            'user_id' => 'exists:relink_snips',
            'title' => 'required',
            'title_color' => 'required',
            'descrip' => 'required',
            'descrip_color' => 'required',
            'bg' => 'required'
        ];
        $rules_result = array_merge($rules, $next_rules);

        $this->validate($data, $rules_result);

        $fileName = $request->image;

        if ($fileName != null) {
            if (Storage::exists('/images/growpage/tmp/'.$fileName)) {
                Storage::move('/images/growpage/tmp/'.$fileName, '/images/growpage/'.$fileName);
                $data['upload_path'] = $fileName;
            }elseif(Storage::exists('/images/growpage/'.$fileName)) {
                $data['upload_path'] = $fileName;
            }
        }else{
            $data['upload_path'] = '';
        }

        $growPage->update($data->all());

        return redirect('growpage');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $growPage = ReLinkSnips::find($id);

        $filename = $growPage['upload_path'];

        $file_path = public_path("images/growpage/{$filename}");

        if(File::exists($file_path)) File::delete($file_path);

        ReLinkSnips::destroy($id);

        return redirect('/growpage');
    }

    public function redirect_relink($path)
    {
        $short_link = url('/g/'.$path);
        $growPage_item = ReLinkSnips::where(['short_link' => $short_link])->first();
        $growPage_item['second'] *= 1000;
        return view('growpage.loading', compact('growPage_item'));
    }

    public function getip()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } elseif (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv('HTTP_X_FORWARDED_FOR')) {
                $realip = getenv('HTTP_X_FORWARDED_FOR');
            } elseif (getenv('HTTP_CLIENT_IP')) {
                $realip = getenv('HTTP_CLIENT_IP');
            } else {
                $realip = getenv('REMOTE_ADDR');
            }
        }
        return $realip;
    }

    public function get_services()
    {
        $userServices = UserService::where('user_id', '=', Auth::user()->id)->get();
        $services = array();
        if($userServices)
        {
            foreach($userServices as $k=>$service)
            {
                $key = $service->api[0]->id;
                $services[$key] = $service->api[0]->name;
            }
        }
        $arr = array_reverse($services, true);
        $arr[''] = 'Please Choose';
        $services = array_reverse($arr, true);

        return $services;
    }

    public function get_backgrounds()
    {
        $backgrounds = Background::all();

        return $backgrounds;
    }

    public function uploadImage(){

        if(Input::hasFile('file')) {
            //upload an image to the /images/growpage/tmp/ directory and return the filepath.
            $file = Input::file('file');
            $tmpFilePath = '/images/growpage/tmp/';
            $tmpFileName = time() . '-' . $file->getClientOriginalName();
            $file = $file->move(public_path() . $tmpFilePath, $tmpFileName);
            $path = $tmpFilePath . $tmpFileName;
            return response()->json(array('path'=> $tmpFileName), 200);
        } else {
            return response()->json(false, 200);
        }
    }

    public function removeImage(Request $request)
    {
        if($request->image){
            Storage::delete('images/growpage/tmp/'.$request->image);
            echo 'ok';
        }else{
            echo "invalid request";
        }
    }

    public function duplicate($id){

        $growPage = ReLinkSnips::find($id)->toArray();

        $sort_link = $growPage['short_link'];

        $i = 1;
        while($i) {

            $new_short_link = $sort_link.'-'.$i;
            $exist = ReLinkSnips::where('short_link', $new_short_link)->first();

            if(!$exist) {

                $growPage['short_link'] = $new_short_link;
                unset($growPage['id']);
                break;
            }

            $i++;
        }

        ReLinkSnips::create($growPage);

        return redirect('/growpage');
    }

    public function splitTest($id){

        $growPage = ReLinkSnips::find($id)->toArray();

        $sort_link = $growPage['short_link'];

        $i = 1;
        while($i)
        {
            $new_short_link = $sort_link.'-'.$i;
            $exist = ReLinkSnips::where('short_link', $new_short_link)->first();

            if(!$exist)
            {
                $growPage['short_link'] = $new_short_link;
                $growPage['parent_id'] = $growPage['id'];
                unset($growPage['id']);
                break;
            }

            $i++;
        }

        $new_growPage = ReLinkSnips::create($growPage);

        return redirect("growpage/{$new_growPage['id']}/edit");
    }

}
