<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Models\ReLink;
use App\Models\ReLinkClicks;

class ReLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ReLink $relink)
    {
        $relinks = $relink->all();

        return view('relink.index', compact('relinks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('relink.create');
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
        $short_link = $data->domain.'/r/'.$data->url_path;
        $data['short_link'] = $short_link;

        $rules = [
            'title' => 'required',
            'redirect_url' => 'required',
            'domain' => 'required',
            'url_path' => 'required',
            'code' => 'required',
            'short_link' => 'unique:relinks'
        ];
        $this->validate($data, $rules);

        $data['slug'] = preg_replace('/[^A-Za-z0-9-]+/', '-', strtolower($request->title));
        $data['user_id'] = Auth::user()->id;

        $relink = ReLink::create($data->all());

        $request->session()->flash('relink', $relink['short_link']);

        return redirect('/short-link');
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
        $relink = Relink::find($id);
        $rules = [
            'title'=> 'required',
            'redirect_url'=> 'required|url',
            'code'=> 'required',
        ];

        $this->validate($request, $rules);

        $relink->update($request->all());

        return redirect('/relink');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ReLinkClicks::where('relink_id', '=', $id)->delete();
        ReLink::destroy($id);

        return redirect('/relink');
    }

    public function show_relink()
    {
        if(session('relink'))
        {
            $relink = session('relink');

            return view('relink.show_short_link', compact('relink'));
        }
        else{
            return redirect('/');
        }
    }

    public function redirect_relink($path)
    {
        $short_link = url('/').'/r/'.$path;

        $relink_item = ReLink::where(['short_link' => $short_link])->first();

        $data['relink_id'] = $relink_item['id'];
        $data['ip'] = $this->getip();
        ReLinkClicks::create($data);

        return view('relink.loading', compact('relink_item'));
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

}
