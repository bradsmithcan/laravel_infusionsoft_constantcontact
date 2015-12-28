<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserService;
use App\Http\Requests;
use App\Models\GrowBar;
use Illuminate\Support\Facades\Auth;
class GrowBarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $growBars = GrowBar::all();
        return view('growbar.index', compact('growBars'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $services = $this->get_services();

        return view('growbar.create', compact('services','backgrounds'));
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
        $rules = [];
        if($request['type'] == 0)
        {
            $rules = [
                'api_id' => 'required'
            ];
        }

        if($request['cd'] == 0){
            $rules = [
                'cdbg' => 'required',
                'cdtext' => 'required',
                'cdlc' => 'required',
            ];
        }
        $next_rules = [
            'type' => 'required',
            'website' => 'required|url',
            'link_url' => 'required|url',
            'openin' => 'required',
            'headline' => 'required',
            'link_text' => 'required',
            'font_family' => 'required',
            'background_color' => 'required',
            'text_color' => 'required',
            'action_color' => 'required',
            'action_text_color' => 'required',
            'position' => 'required',
            'size' => 'required',
            'animate' => 'required',
            'wiggle' => 'required',
            'hidebar' => 'required',
            'push' => 'required',

        ];
        $rules_result = array_merge($rules, $next_rules);

        $this->validate($data, $rules_result);

        $data['user_id'] = Auth::user()->id;
        $bar = GrowBar::create($data->all());

        $hash = $this->encode($bar->id . '=id', "W5jb2RpbmcgYW5kIERlY29kaW5nIEVuY3J5cHRlZCBQSFAgQ29kZ");
        $bar->hash = $hash;
        $bar->save();
        $request->session()->flash('growbar', $hash);

        return redirect('growbar');
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
        $growBar = GrowBar::findorfail($id);
        $services = $this->get_services();

        return view('growbar.edit', compact('services','growBar'));

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
        $growBar = GrowBar::find($id);
        $data = $request;

        $rules = [];
        if($request['type'] == 0)
        {
            $rules = [
                'api_id' => 'required'
            ];
        }

        if($request['cd'] == 0){
            $rules = [
                'cdbg' => 'required',
                'cdtext' => 'required',
                'cdlc' => 'required',
            ];
        }
        $next_rules = [
            'type' => 'required',
            'website' => 'required|url',
            'link_url' => 'required|url',
            'openin' => 'required',
            'headline' => 'required',
            'link_text' => 'required',
            'font_family' => 'required',
            'background_color' => 'required',
            'text_color' => 'required',
            'action_color' => 'required',
            'action_text_color' => 'required',
            'position' => 'required',
            'size' => 'required',
            'animate' => 'required',
            'wiggle' => 'required',
            'hidebar' => 'required',
            'push' => 'required',

        ];
        $rules_result = array_merge($rules, $next_rules);

        $this->validate($data, $rules_result);

        $data['user_id'] = Auth::user()->id;

        $growBar->update($data->all());

        return redirect('growbar');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        GrowBar::destroy($id);

        return redirect('growbar');
    }

    public function script($key)
    {
        header("Content-Type: application/javascript");
        $getid  = explode('=',  $this->decode($key,"W5jb2RpbmcgYW5kIERlY29kaW5nIEVuY3J5cHRlZCBQSFAgQ29kZ"));
        $id = $getid[0];
        $growBar = GrowBar::findorfail($id);
        $content = '
            var script = document.createElement("script");
            script.src = "'.asset('assets/plugins/countdown/').'/countdown.js";
            document.getElementsByTagName("head")[0].appendChild(script);
            GB = {
            animateIn: function(t) {

            "object" == typeof t.classList ? (t.classList.remove("animateOut"), t.classList.add("animated"), t.classList.add("animateIn")) : t.style.display = ""
            },
            animateOut: function(t, e) {
            //alert("dsfsdf");
            console.log(t.classList);
            "object" == typeof t.classList ? (t.classList.remove("animateIn"), t.classList.add("animated"), t.classList.add("animateOut")) : t.style.display = "none", hideIframe = window.setTimeout(function() {
            var n = t.getAttribute("class");
            null != n && n.indexOf("Bar") > -1 && !isBar && "pull-down" != t.id && t.setAttribute("style", "height:0px;max-height:0px"), "function" == typeof e && e()
            }, 250)
            },
            wiggleEventListeners: function(t) {
            t.addEventListener("mouseenter", function(){
                t.getElementsByClassName("gb-cta")[0].classList.add("wiggle");
            });
            /*t.addEventListener("mouseleave", function(){
            setTimeout(function() {
            t.getElementsByClassName("gb-cta")[0].classList.remove("wiggle");
            }, 2500);
            });*/
            }

            }

            /******************************* Main Bar Created ********************************/
            // Wrapper Div
            var containerDiv = document.createElement("div");
            containerDiv.setAttribute("id", "growbar_container");';
        $position   = $growBar->position == "Top"?"top":"bottom";
        $size       = $growBar->size == "large"?"large":"regular";
        $content .= 'containerDiv.setAttribute("class", "Bar ' .$size. ' bar-'.$position.' remains_in_place growbar");';

        if($growBar->size == "regular"){
            $content .= 'containerDiv.setAttribute("style", "min-height:30px;");';
        }

        $clockcss	= '';
        $headline 	= $growBar->headline;
        if(stripos($headline,"[[gcdown]]") !== false){
            $array 	= explode("[[gcdown]]",$headline);
            $fulldate	= $array[1];
            $date_array	= explode(" ",$fulldate);
            $date 	= $date_array[0];
            $time	= $date_array[1];

            $date 	= explode("/",$date);
            $year	= $date[0];
            $month	= $date[1];
            $day	= $date[2];

            $time	= explode(":",$time);
            $hour	= $time[0];
            $minute	= $time[1];
            $second	= $time[2];

            $headline = $array[0].' <span id='."gb-headline-counter-holder".' class='."$size".'></span>'.$array[2];

            $clockcss = " clock";

            $date1 = strtotime($fulldate);
            $date2 = time();
            $diff	= $date1 - $date2;

            $range = $diff > 86400?'day':($diff > 3600 ? 'hour':'minute');

            $cdbg = $growBar->cdbg;
            $cdtxt = $growBar->cdtext;
            $cdlc = $growBar->cdlc;
        }



        $content .= '
        var mainDiv = document.createElement("div");
            mainDiv.setAttribute("id", "growbar");
            mainDiv.setAttribute("class", "growbar '.$size.$clockcss .'");

            /******* Left Div *********/
            var leftDiv = document.createElement("div");
            leftDiv.setAttribute("class","gb-logo-wrapper");
            leftDiv.innerHTML = "<span>UserGrow</span>";

            var midDiv = document.createElement("div");
            midDiv.setAttribute("class","gb-content-wrapper");

            var midDivTextWrapper = document.createElement("div");
            //midDivTextWrapper.setAttribute("class","gb-text-wrapper");


            // Main Headline
            var headlineSpan = document.createElement("span");
            headlineSpan.setAttribute("id","gb_msg_container");
            headlineSpan.setAttribute("class","gb-headline-text gb-text-wrapper");';

        if(!empty($headline)){
            $content .= ' headlineSpan.innerHTML = "'.stripslashes($headline).'";';
        }else{
            $content .= ' headlineSpan.innerHTML = "Click Here";';
        }

        if($growBar->type == '0'){

            $content .='
            // emailInput Holder
            var emailInputSpan = document.createElement("span");
            emailInputSpan.setAttribute("class","btn");

            emailInputSpan.setAttribute("class","btn");

            var inputEmail = document.createElement("input");
            inputEmail.setAttribute("class","form-control");
            inputEmail.setAttribute("id","email-Full-Width");
            inputEmail.setAttribute("name","email");
            inputEmail.setAttribute("type","email");
            inputEmail.setAttribute("placeholder","Email Address");
            emailInputSpan.appendChild(inputEmail);
            ';

        }
        $content .='

            // Button Holder
            var btnHolderSpan = document.createElement("span");
            btnHolderSpan.setAttribute("class","gb-headline-btn-holder");

            // Clock JS Holder
            /*var clockHolderSpan = document.createElement("span");
            clockHolderSpan.setAttribute("id","gb-headline-counter-holder");
            */
            var btnLinkTag = document.createElement("a");
            btnLinkTag.setAttribute("class","gb-cta gb-cta-style-button");
            btnLinkTag.setAttribute("id","gb_headline_btn");';

        if($growBar->openin == "1"){
            $content .= 'btnLinkTag.setAttribute("target","_blank");';
        }

        if(!empty($growBar->link_url)){
            $content .= 'btnLinkTag.setAttribute("href", "'. url('/').'");';
        }else{
            $content .= 'btnLinkTag.setAttribute("href", "#");';
        }

        if(!empty($growBar->link_text)){
            $content .= 'btnLinkTag.innerHTML = "'.$growBar->link_text.'";';
        }else{
            $content .= 'btnLinkTag.innerHTML = "Click Here";';
        }
        $content .= '
            // Append

            btnHolderSpan.appendChild(btnLinkTag);
            //midDivTextWrapper.appendChild(clockHolderSpan);
            midDivTextWrapper.appendChild(headlineSpan);
            ';

        if($growBar->type == '0'){
            $content .= 'midDivTextWrapper.appendChild(emailInputSpan);';
        }

        $content .='
            midDivTextWrapper.appendChild(btnHolderSpan);
            midDiv.appendChild(midDivTextWrapper);

            /******* Right Div *********/
            var rightDiv = document.createElement("div");
            rightDiv.setAttribute("class","gb-arrow-wrapper");

            var arrowLinkTag = document.createElement("a");
            arrowLinkTag.setAttribute("onclick","GB.animateOut(this.parentNode.parentNode.parentNode);GB.animateIn(document.getElementById('."pull-down".'));");
            arrowLinkTag.setAttribute("id","close_bar");
';
        $content .= 'arrowLinkTag.innerHTML = "'."<img class='gb-arrow' src='".asset('assets')."/images/arrow_white.png'  width='28' height='29' />".'";';
        $content .='
            rightDiv.appendChild(arrowLinkTag);

            mainDiv.appendChild(leftDiv);
            mainDiv.appendChild(midDiv);



            ';
        if($growBar->hidebar == '1'){
            $content .=' mainDiv.appendChild(rightDiv);';
        }

        $content .= 'var rawstyles = "@import url(//fonts.googleapis.com/css?family=Open+Sans:400,600,700);@font-face{font-family:'."icomoon".';src:url(data:application/x-font-ttf;charset=utf-8;base64,AAEAAAALAIAAAwAwT1MvMg8SAywAAAC8AAAAYGNtYXAaVcxZAAABHAAAAExnYXNwAAAAEAAAAWgAAAAIZ2x5ZjAeVDIAAAFwAAABzGhlYWQFJeYbAAADPAAAADZoaGVhB8IDyAAAA3QAAAAkaG10eA4AADgAAAOYAAAAHGxvY2EAzgFgAAADtAAAABBtYXhwAAoAMAAAA8QAAAAgbmFtZVcZpu4AAAPkAAABRXBvc3QAAwAAAAAFLAAAACAAAwQAAZAABQAAApkCzAAAAI8CmQLMAAAB6wAzAQkAAAAAAAAAAAAAAAAAAAABEAAAAAAAAAAAAAAAAAAAAABAAADmAgPA/8AAQAPAAEAAAAABAAAAAAAAAAAAAAAgAAAAAAACAAAAAwAAABQAAwABAAAAFAAEADgAAAAKAAgAAgACAAEAIOYC//3//wAAAAAAIOYA//3//wAB/+MaBAADAAEAAAAAAAAAAAAAAAEAAf//AA8AAQAAAAAAAAAAAAIAADc5AQAAAAABAAAAAAAAAAAAAgAANzkBAAAAAAEAAAAAAAAAAAACAAA3OQEAAAAAAQA4/9oDyAOIACYAAAkBNjQnJgYHCQEmIgcGFhcJAQYUFx4BMzI2NwkBHgEzMjY3NjQnAQKKAT4bGxtPIP7C/sIbTyAfBBsBPv7CGxsSJBISIg4BPgE+DSMSEiIOGxv+yAHAAT4bTyAfBBv+wgE4GxsbTyD+yP7CG08gCQ8QDgE4/sINERAOG08gAT4AAAAAAgAAAAAEAAKAABAALQAAASEiBhURFBYzITI2NRE0JiMHIxUzFSE1MzUhFTMVITUzNSM1IRUjFSE1IzUhFQPz/BoFCAgFA+YFCAgFgG1t/rp5/rR5/rptbQFGeQFMeQFGAoAIBf2aBQgIBQJmBQjG+lpgWlpZWfRgWk1HYGAAAAACAAAAgAQAAwAAEAAtAAABISIGFREUFjMhMjY1ETQmIwcjFTMVITUzNSEVMxUhNTM1IzUhFSMVITUjNSEVA/P8GgUICAUD5gUICAWAbW3+unn+tHn+um1tAUZ5AUx5AUYDAAgF/ZoFCAgFAmYFCMb6WmBaWllZ9GBaTUdgYAAAAAEAAAABAAClcKjgXw889QALBAAAAAAA0QNQ3gAAAADRA1DeAAD/2gQAA4gAAAAIAAIAAAAAAAAAAQAAA8D/wAAABAAAAAAABAAAAQAAAAAAAAAAAAAAAAAAAAcAAAAAAAAAAAAAAAACAAAABAAAOAQAAAAEAAAAAAAAAAAKABQAHgBmAKYA5gABAAAABwAuAAIAAAAAAAIAAAAAAAAAAAAAAAAAAAAAAAAADgCuAAEAAAAAAAEADgAAAAEAAAAAAAIADgBHAAEAAAAAAAMADgAkAAEAAAAAAAQADgBVAAEAAAAAAAUAFgAOAAEAAAAAAAYABwAyAAEAAAAAAAoANABjAAMAAQQJAAEADgAAAAMAAQQJAAIADgBHAAMAAQQJAAMADgAkAAMAAQQJAAQADgBVAAMAAQQJAAUAFgAOAAMAAQQJAAYADgA5AAMAAQQJAAoANABjAGkAYwBvAG0AbwBvAG4AVgBlAHIAcwBpAG8AbgAgADEALgAwAGkAYwBvAG0AbwBvAG5pY29tb29uAGkAYwBvAG0AbwBvAG4AUgBlAGcAdQBsAGEAcgBpAGMAbwBtAG8AbwBuAEYAbwBuAHQAIABnAGUAbgBlAHIAYQB0AGUAZAAgAGIAeQAgAEkAYwBvAE0AbwBvAG4ALgAAAAADAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA) format(truetype),url(data:application/font-woff;charset=utf-8;base64,d09GRgABAAAAAAWYAAsAAAAABUwAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAABPUy8yAAABCAAAAGAAAABgDxIDLGNtYXAAAAFoAAAATAAAAEwaVcxZZ2FzcAAAAbQAAAAIAAAACAAAABBnbHlmAAABvAAAAcwAAAHMMB5UMmhlYWQAAAOIAAAANgAAADYFJeYbaGhlYQAAA8AAAAAkAAAAJAfCA8hobXR4AAAD5AAAABwAAAAcDgAAOGxvY2EAAAQAAAAAEAAAABAAzgFgbWF4cAAABBAAAAAgAAAAIAAKADBuYW1lAAAEMAAAAUUAAAFFVxmm7nBvc3QAAAV4AAAAIAAAACAAAwAAAAMEAAGQAAUAAAKZAswAAACPApkCzAAAAesAMwEJAAAAAAAAAAAAAAAAAAAAARAAAAAAAAAAAAAAAAAAAAAAQAAA5gIDwP/AAEADwABAAAAAAQAAAAAAAAAAAAAAIAAAAAAAAgAAAAMAAAAUAAMAAQAAABQABAA4AAAACgAIAAIAAgABACDmAv/9//8AAAAAACDmAP/9//8AAf/jGgQAAwABAAAAAAAAAAAAAAABAAH//wAPAAEAAAAAAAAAAAACAAA3OQEAAAAAAQAAAAAAAAAAAAIAADc5AQAAAAABAAAAAAAAAAAAAgAANzkBAAAAAAEAOP/aA8gDiAAmAAAJATY0JyYGBwkBJiIHBhYXCQEGFBceATMyNjcJAR4BMzI2NzY0JwECigE+GxsbTyD+wv7CG08gHwQbAT7+whsbEiQSEiIOAT4BPg0jEhIiDhsb/sgBwAE+G08gHwQb/sIBOBsbG08g/sj+whtPIAkPEA4BOP7CDREQDhtPIAE+AAAAAAIAAAAABAACgAAQAC0AAAEhIgYVERQWMyEyNjURNCYjByMVMxUhNTM1IRUzFSE1MzUjNSEVIxUhNSM1IRUD8/waBQgIBQPmBQgIBYBtbf66ef60ef66bW0BRnkBTHkBRgKACAX9mgUICAUCZgUIxvpaYFpaWVn0YFpNR2BgAAAAAgAAAIAEAAMAABAALQAAASEiBhURFBYzITI2NRE0JiMHIxUzFSE1MzUhFTMVITUzNSM1IRUjFSE1IzUhFQPz/BoFCAgFA+YFCAgFgG1t/rp5/rR5/rptbQFGeQFMeQFGAwAIBf2aBQgIBQJmBQjG+lpgWlpZWfRgWk1HYGAAAAABAAAAAQAApXCo4F8PPPUACwQAAAAAANEDUN4AAAAA0QNQ3gAA/9oEAAOIAAAACAACAAAAAAAAAAEAAAPA/8AAAAQAAAAAAAQAAAEAAAAAAAAAAAAAAAAAAAAHAAAAAAAAAAAAAAAAAgAAAAQAADgEAAAABAAAAAAAAAAACgAUAB4AZgCmAOYAAQAAAAcALgACAAAAAAACAAAAAAAAAAAAAAAAAAAAAAAAAA4ArgABAAAAAAABAA4AAAABAAAAAAACAA4ARwABAAAAAAADAA4AJAABAAAAAAAEAA4AVQABAAAAAAAFABYADgABAAAAAAAGAAcAMgABAAAAAAAKADQAYwADAAEECQABAA4AAAADAAEECQACAA4ARwADAAEECQADAA4AJAADAAEECQAEAA4AVQADAAEECQAFABYADgADAAEECQAGAA4AOQADAAEECQAKADQAYwBpAGMAbwBtAG8AbwBuAFYAZQByAHMAaQBvAG4AIAAxAC4AMABpAGMAbwBtAG8AbwBuaWNvbW9vbgBpAGMAbwBtAG8AbwBuAFIAZQBnAHUAbABhAHIAaQBjAG8AbQBvAG8AbgBGAG8AbgB0ACAAZwBlAG4AZQByAGEAdABlAGQAIABiAHkAIABJAGMAbwBNAG8AbwBuAC4AAAAAAwAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA==) format(woff);font-weight:400;font-style:normal}[class^='."icon-".'],[class*='." icon-".']{speak:none;line-height:1;font-style:normal;font-weight:400;font-variant:normal;text-transform:none;font-family:'."icomoon".';-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased}.icon-close:before{content:'."\e600".'}.icon-gb-logo:before{content:'."\e602".'}.icon-gb-text-logo:before{content:'."\e601".'}*,:after,:before{box-sizing:border-box;-o-box-sizing:border-box;-ms-box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box}#growbar{width:100%;color:#5c5e60;position:relative;background-color:#fff;box-shadow:0 1px 3px 2px rgba(0,0,0,.15);font-size:14px;font-family:'."Open Sans".','."Helvetica".',sans-serif;overflow:hidden;margin:0;padding:0}.gb-cta-style-button{opacity:1;color:';
        if(!empty($growBar->action_text_color)){
            $content .=  "$growBar->action_text_color";
        }else{
            $content .=  "#000000";
        }
        $content .= ';background:';

        if(!empty($growBar->action_color)){
            $content .=  "$growBar->action_color";
        }else{
            $content .=  "#ffffff";
        }
        $content .= ';display:block;cursor:pointer;line-height:1.4;max-width:22.5em;text-align:center;position:relative;border-radius:3px;white-space:nowrap;text-decoration:none;margin:1.75em auto 0;padding:.67em 1.33em}.gb-cta-style-button:hover{opacity:.9;color:';
        if(!empty($growBar->action_text_color)){
            $content .=  "$growBar->action_text_color";
        }else{
            $content .=  "#000000";
        }
        $content .= ';}.gb-text-wrapper{line-height:1.3}.gb-text-wrapper .gb-headline-text{font-weight:600;font-size:1.25em}.gb-text-wrapper .gb-secondary-text{margin-top:5px;-moz-osx-font-smoothing:grayscale;-webkit-font-smoothing:antialiased}.gb-input-wrapper .gb-input-block{width:100%;position:relative;vertical-align:middle}.gb-input-wrapper .gb-input-block input{width:100%;height:3em;outline:0;color:#5c5e60;font-size:.9em;border-radius:2px;border:1px solid #e0e0e0;appearance:none;-o-appearance:none;-ms-appearance:none;-moz-appearance:none;-webkit-appearance:none;box-sizing:border-box;-o-box-sizing:border-box;-ms-box-sizing:border-box;-moz-box-sizing:border-box;-webkit-box-sizing:border-box;transition:border-color .2s ease;-o-transition:border-color .2s ease;-ms-transition:border-color .2s ease;-moz-transition:border-color .2s ease;-webkit-transition:border-color .2s ease;padding:0 10px}.gb-input-wrapper .gb-input-block input:focus{border-color:#b2b2b2}.gb-input-wrapper .gb-cta{margin-top:1.25em}.gb-logo-wrapper{opacity:.33;margin-top:2em;font-size:.85em;margin-bottom:-1em;font-family:'."Open Sans".',sans-serif;transition:opacity .2s ease;-o-transition:opacity .2s ease;-ms-transition:opacity .2s ease;-moz-transition:opacity .2s ease;-webkit-transition:opacity .2s ease}.gb-logo-wrapper a{color:#5c5e60;text-decoration:none}.gb-logo-wrapper .gb-logo-line{display:inline;line-height:1.15;white-space:nowrap}.gb-logo-wrapper svg{width:1.45em;height:1.25em;fill:#5c5e60;backface-visibility:hidden;-o-backface-visibility:hidden;-ms-backface-visibility:hidden;-moz-backface-visibility:hidden;-webkit-backface-visibility:hidden;transform:translatey(2px);-o-transform:translatey(2px);-ms-transform:translatey(2px);-moz-transform:translatey(2px);-webkit-transform:translatey(2px)}.gb-logo-wrapper:hover{opacity:.67}.gb-social-wrapper{min-width:1px;min-height:20px;display:inline-block;margin:1em auto -1.25em}.gb-social-wrapper #___follow_0,.gb-social-wrapper #___plusone_0{display:block!important}.gb-social-wrapper.gb-google-wrapper{height:24px!important}.gb-social-wrapper.gb-linkedin-wrapper{height:20px!important}.gb-social-wrapper .gb-buffer-share-button{width:55px;height:20px;margin-right:0;overflow:hidden;position:relative;display:inline-block;}.gb-social-wrapper .gb-buffer-share-button:hover{background-position:0 -20px}.gb-social-wrapper script,.gb-social-wrapper .gc-bubbleDefault,.gb-social-wrapper .pls-container{display:none!important}.gb-old-ie .gb-input-wrapper .gb-input-block label{top:30%;right:1.25em;color:#e0e0e0;font-size:.85em;position:absolute;display:inline-block}#growbar{width:100%;color:';

        if(!empty($growBar->text_color)){
            $content .=  "$growBar->text_color";
        }else{
            $content .=  "#ffffff";
        }

        $content .= ';height:50px;display:table;font-size:17px;font-weight:600;background-color:';

        if(!empty($growBar->background_color)){
            $content .=  "$growBar->background_color";
        }else{
            $content .=  "#eb593c";
        }
        $content .= ';-webkit-font-smoothing:antialiased;margin:0;padding:.33em .5em}#growbar .gb-logo-wrapper,#growbar .gb-content-wrapper,#growbar .gb-arrow-wrapper{display:table-cell;vertical-align:middle}#growbar .gb-cta{display:inline-block;vertical-align:middle;margin:5px 0}#growbar .gb-cta-style-text{color:#fff;border-radius:4px;text-decoration:underline;background:none!important;padding:6px 15px 6px 5px}#growbar .gb-cta-style-button{line-height:1.05;margin:0;padding:5px 15px}#growbar .gb-social-wrapper{line-height:0;vertical-align:text-bottom;margin:0}#growbar .gb-social-wrapper.gb-google-wrapper{vertical-align:middle}#growbar .gb-social-wrapper #___follow_0,#growbar .gb-social-wrapper #___plusone_0{display:inline-block!important}#growbar.has_border{border-bottom:3px solid #fff}#growbar .gb-arrow-wrapper{width:8rem;text-align:right;padding-left:1rem}#growbar .gb-arrow-wrapper .gb-arrow{cursor:pointer;width:28px;height:29px;opacity:.3}#growbar .gb-arrow-wrapper .gb-arrow:hover{opacity:.6}#growbar .gb-text-wrapper{margin-right:.67em;display:inline-block}#growbar .gb-text-wrapper .gb-headline-text{font-size:1em;display:inline-block}#growbar .gb-input-wrapper,#growbar .gb-input-wrapper .gb-input-block,#growbar .gb-input-wrapper .gb-cta{width:auto;display:inline-block}#growbar .gb-input-wrapper .gb-input-block input{height:2.3em;font-size:.67em}#growbar .gb-logo-wrapper{width:8rem;opacity:.7;margin-top:0;font-size:12px;text-align:left;font-weight:400;padding-right:1rem}#growbar .gb-logo-wrapper a{color:#fff}#growbar .gb-logo-wrapper svg{fill:#fff}#growbar .gb-logo-wrapper .gb-logo-line{display:block}#growbar .gb-logo-wrapper.gb-logo-inverted a{color:#3c3e3f}#growbar .gb-logo-wrapper.gb-logo-inverted svg{fill:#3c3e3f}#growbar .gb-logo-wrapper:hover{opacity:1}#growbar.bar-bottom{top:auto;bottom:0;position:absolute}#growbar_container.bar-bottom .gb-arrow-wrapper .gb-arrow{filter:flipv;transform:scaley(-1);-o-transform:scaley(-1);-ms-transform:scaley(-1);-moz-transform:scaley(-1);-webkit-transform:scaley(-1)}#growbar.mobile .gb-input-wrapper .gb-input-block input{display:block;margin:.25em auto}#growbar.regular{height:30px;font-size:14px;padding:.2em .5em}#growbar.regular .gb-logo-wrapper{font-size:9px}#growbar.regular .gb-cta-style-button{padding:3px 8px}#growbar.regular .gb-social-wrapper{vertical-align:bottom}#growbar.regular .gb-social-wrapper.gb-google-wrapper{height:24px;vertical-align:middle;margin:-1px 0}#growbar.regular .gb-input-wrapper .gb-input-block input{line-height:195%}#growbar.regular .gb-arrow-wrapper .gb-arrow{width:21px;height:21px}#growbar .gb-cta.wiggle{box-shadow:0 0 1px rgba(0,0,0,0);-moz-osx-font-smoothing:grayscale;backface-visibility:hidden;-o-backface-visibility:hidden;-ms-backface-visibility:hidden;-moz-backface-visibility:hidden;-webkit-backface-visibility:hidden;transform:translatez(0);-o-transform:translatez(0);-ms-transform:translatez(0);-moz-transform:translatez(0);-webkit-transform:translatez(0);animation-name:wiggle;-o-animation-name:wiggle;-ms-animation-name:wiggle;-moz-animation-name:wiggle;-webkit-animation-name:wiggle;animation-duration:5s;-o-animation-duration:5s;-ms-animation-duration:5s;-moz-animation-duration:5s;-webkit-animation-duration:5s;animation-timing-function:linear;-o-animation-timing-function:linear;-ms-animation-timing-function:linear;-moz-animation-timing-function:linear;-webkit-animation-timing-function:linear;animation-iteration-count:infinite;-o-animation-iteration-count:infinite;-ms-animation-iteration-count:infinite;-moz-animation-iteration-count:infinite;-webkit-animation-iteration-count:infinite;animation-play-state:running;-o-animation-play-state:running;-ms-animation-play-state:running;-moz-animation-play-state:running;-webkit-animation-play-state:running}#growbar:hover .gb-cta.wiggle{animation-play-state:paused;-o-animation-play-state:paused;-ms-animation-play-state:paused;-moz-animation-play-state:paused;-webkit-animation-play-state:paused}6%{-webkit-transform:translatex(3px) rotate(2deg);transform:translatex(3px) rotate(2deg)}18%{-webkit-transform:translatex(1px) rotate(0);transform:translatex(1px) rotate(0)}20%{-webkit-transform:translatex(-1px) rotate(0);transform:translatex(-1px) rotate(0)}#growbar_container.animated,#pull-down.animated{animation-duration:.25s;-o-animation-duration:.25s;-ms-animation-duration:.25s;-moz-animation-duration:.25s;-webkit-animation-duration:.25s;animation-fill-mode:forwards;-o-animation-fill-mode:forwards;-ms-animation-fill-mode:forwards;-moz-animation-fill-mode:forwards;-webkit-animation-fill-mode:forwards}0%{bottom:0;transform:none;-o-transform:none;-ms-transform:none;-moz-transform:none;-webkit-transform:none;opacity:1;height:100%;margin-top:0}60%{transform:translate3d(0,0,0);-o-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);-webkit-transform:translate3d(0,0,0)}90%{transform:translate3d(0,0,0);-o-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);-webkit-transform:translate3d(0,0,0)}100%{bottom:-500px;transform:translate3d(-200%,0,0);-o-transform:translate3d(-200%,0,0);-ms-transform:translate3d(-200%,0,0);-moz-transform:translate3d(-200%,0,0);-webkit-transform:translate3d(-200%,0,0);opacity:0;height:110%;margin-top:-5%}#growbar_container.Bar{top:0;left:0;width:100%;min-height:40px;max-height:40px}#growbar_container.Bar.large{min-height:58px;max-height:58px}#growbar_pusher{height:30px;overflow:hidden;position:relative}#growbar_pusher.large{height:50px}.growbar#pull-down{background-color:';

        if(!empty($growBar->background_color)){
            $content .=  "$growBar->background_color";
        }else{
            $content .=  "#eb593c";
        }
        $content .=' ;top:-4px;right:10px;z-index:16999;display:block;overflow:hidden;position:absolute;border:2px solid #fff;border-radius:0 0 5px 5px;transform:translatey(-40px);-o-transform:translatey(-40px);-ms-transform:translatey(-40px);-moz-transform:translatey(-40px);-webkit-transform:translatey(-40px);padding:6px}.growbar#pull-down .growbar_arrow{opacity:.3;cursor:pointer;filter:flipv;transform:scaley(-1);-o-transform:scaley(-1);-ms-transform:scaley(-1);-moz-transform:scaley(-1);-webkit-transform:scaley(-1);background-image:url(https://s3.amazonaws.com/hb-assets/arrow_white.png)}.growbar#pull-down.regular .growbar_arrow{width:21px;height:21px;background-size:21px 21px}.growbar#pull-down.large .growbar_arrow{width:28px;height:28px;background-size:28px 28px}.growbar#pull-down.bar-bottom{top:auto;bottom:-4px;position:fixed;border-radius:5px 5px 0 0;transform:translatey(40px);-o-transform:translatey(40px);-ms-transform:translatey(40px);-moz-transform:translatey(40px);-webkit-transform:translatey(40px)}.growbar#pull-down.bar-bottom .growbar_arrow{filter:none;transform:none;-o-transform:none;-ms-transform:none;-moz-transform:none;-webkit-transform:none}#growbar_container.Bar.remains_in_place{top:0;position:fixed;_position:absolute;_top:expression(eval(document.body.scrollTop))}#growbar_container.Bar.bar-bottom{top:auto;bottom:0;position:fixed;_position:absolute;_bottom:expression(eval(document.body.scrollTop))}#growbar_container.Bar.animated,.growbar#pull-down.animated{transform:translatey(-60px);-o-transform:translatey(-60px);-ms-transform:translatey(-60px);-moz-transform:translatey(-60px);-webkit-transform:translatey(-60px);animation-duration:1s;-o-animation-duration:1s;-ms-animation-duration:1s;-moz-animation-duration:1s;-webkit-animation-duration:1s}#growbar_container.Bar.animateIn,.growbar#pull-down.animateIn{animation-name:bounceindown;-o-animation-name:bounceindown;-ms-animation-name:bounceindown;-moz-animation-name:bounceindown;-webkit-animation-name:bounceindown}#growbar_container.Bar.animateOut,.growbar#pull-down.animateOut{animation-name:bounceoutup;-o-animation-name:bounceoutup;-ms-animation-name:bounceoutup;-moz-animation-name:bounceoutup;-webkit-animation-name:bounceoutup}#growbar_container.Bar.animated.bar-bottom,.growbar#pull-down.animated.bar-bottom{transform:translatey(60px);-o-transform:translatey(60px);-ms-transform:translatey(60px);-moz-transform:translatey(60px);-webkit-transform:translatey(60px);animation-duration:1s;-o-animation-duration:1s;-ms-animation-duration:1s;-moz-animation-duration:1s;-webkit-animation-duration:1s}#growbar_container.Bar.animateIn.bar-bottom,.growbar#pull-down.animateIn.bar-bottom{animation-name:bounceinup;-o-animation-name:bounceinup;-ms-animation-name:bounceinup;-moz-animation-name:bounceinup;-webkit-animation-name:bounceinup}#growbar_container.Bar.animateOut.bar-bottom,.growbar#pull-down.animateOut.bar-bottom{animation-name:bounceoutdown;-o-animation-name:bounceoutdown;-ms-animation-name:bounceoutdown;-moz-animation-name:bounceoutdown;-webkit-animation-name:bounceoutdown}.gb-content-wrapper,#growbar .gb-content-wrapper{text-align:center}.gb-input-wrapper .gb-input-block label,#growbar.mobile .gb-logo-wrapper,#growbar.mobile .gb-arrow-wrapper{display:none}4%,8%{-webkit-transform:translatex(-3px) rotate(-2deg);transform:translatex(-3px) rotate(-2deg)}10%,14%{-webkit-transform:translatex(2px) rotate(1deg);transform:translatex(2px) rotate(1deg)}12%,16%{-webkit-transform:translatex(-2px) rotate(-1deg);transform:translatex(-2px) rotate(-1deg)}75%,25%{transform:translate3d(10%,0,0);-o-transform:translate3d(10%,0,0);-ms-transform:translate3d(10%,0,0);-moz-transform:translate3d(10%,0,0);-webkit-transform:translate3d(10%,0,0)}" +
            "#growbar.regular .gb-headline-btn-holder{margin-top:-5px;display:inline-block;vertical-align:middle;}#growbar.regular.clock .gb-headline-btn-holder{margin-top:-10px;}#growbar_container{margin:0;padding:0;border:0;z-index:17000;overflow:hidden;position:absolute}#growbar_container.animated,#pull-down.animated{animation-duration:.25s;-o-animation-duration:.25s;-ms-animation-duration:.25s;-moz-animation-duration:.25s;-webkit-animation-duration:.25s;animation-fill-mode:forwards;-o-animation-fill-mode:forwards;-ms-animation-fill-mode:forwards;-moz-animation-fill-mode:forwards;-webkit-animation-fill-mode:forwards}@keyframes bounceindown{0%,60%,75%,90%,100%{transition-timing-function:cubic-bezier(.215,.61,.355,1);-o-transition-timing-function:cubic-bezier(.215,.61,.355,1);-ms-transition-timing-function:cubic-bezier(.215,.61,.355,1);-moz-transition-timing-function:cubic-bezier(.215,.61,.355,1);-webkit-transition-timing-function:cubic-bezier(.215,.61,.355,1)}0%{transform:translate3d(0,-3000px,0);-o-transform:translate3d(0,-3000px,0);-ms-transform:translate3d(0,-3000px,0);-moz-transform:translate3d(0,-3000px,0);-webkit-transform:translate3d(0,-3000px,0)}60%{transform:translate3d(0,0,0);-o-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);-webkit-transform:translate3d(0,0,0)}75%{transform:translate3d(0,-20px,0);-o-transform:translate3d(0,-20px,0);-ms-transform:translate3d(0,-20px,0);-moz-transform:translate3d(0,-20px,0);-webkit-transform:translate3d(0,-20px,0)}90%{transform:translate3d(0,0,0);-o-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);-webkit-transform:translate3d(0,0,0)}100%{transform:none;-o-transform:none;-ms-transform:none;-moz-transform:none;-webkit-transform:none}}@-moz-keyframes bounceindown{0%,60%,75%,90%,100%{-moz-transition-timing-function:cubic-bezier(.215,.61,.355,1)}0%{-moz-transform:translate3d(0,-3000px,0)}60%{-moz-transform:translate3d(0,0,0)}75%{-moz-transform:translate3d(0,-20px,0)}90%{-moz-transform:translate3d(0,0,0)}100%{-moz-transform:none}}@-webkit-keyframes bounceindown{0%,60%,75%,90%,100%{-webkit-transition-timing-function:cubic-bezier(.215,.61,.355,1)}0%{-webkit-transform:translate3d(0,-3000px,0)}60%{-webkit-transform:translate3d(0,0,0)}75%{-webkit-transform:translate3d(0,-20px,0)}90%{-webkit-transform:translate3d(0,0,0)}100%{-webkit-transform:none}}@keyframes bounceinup{0%,60%,75%,90%,100%{transition-timing-function:cubic-bezier(.215,.61,.355,1);-o-transition-timing-function:cubic-bezier(.215,.61,.355,1);-ms-transition-timing-function:cubic-bezier(.215,.61,.355,1);-moz-transition-timing-function:cubic-bezier(.215,.61,.355,1);-webkit-transition-timing-function:cubic-bezier(.215,.61,.355,1)}0%{transform:translate3d(0,3000px,0);-o-transform:translate3d(0,3000px,0);-ms-transform:translate3d(0,3000px,0);-moz-transform:translate3d(0,3000px,0);-webkit-transform:translate3d(0,3000px,0)}60%{transform:translate3d(0,0,0);-o-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);-webkit-transform:translate3d(0,0,0)}75%{transform:translate3d(0,20px,0);-o-transform:translate3d(0,20px,0);-ms-transform:translate3d(0,20px,0);-moz-transform:translate3d(0,20px,0);-webkit-transform:translate3d(0,20px,0)}90%{transform:translate3d(0,0,0);-o-transform:translate3d(0,0,0);-ms-transform:translate3d(0,0,0);-moz-transform:translate3d(0,0,0);-webkit-transform:translate3d(0,0,0)}100%{transform:none;-o-transform:none;-ms-transform:none;-moz-transform:none;-webkit-transform:none}}@-moz-keyframes bounceinup{0%,60%,75%,90%,100%{-moz-transition-timing-function:cubic-bezier(.215,.61,.355,1)}0%{-moz-transform:translate3d(0,3000px,0)}60%{-moz-transform:translate3d(0,0,0)}75%{-moz-transform:translate3d(0,20px,0)}90%{-moz-transform:translate3d(0,0,0)}100%{-moz-transform:none}}@-webkit-keyframes bounceinup{0%,60%,75%,90%,%100{-webkit-transition-timing-function:cubic-bezier(.215,.61,.355,1)}0%{-webkit-transform:translate3d(0,3000px,0)}60%{-webkit-transform:translate3d(0,0,0)}75%{-webkit-transform:translate3d(0,20px,0)}90%{-webkit-transform:translate3d(0,0,0)}100%{-webkit-transform:none}}@keyframes bounceoutup{0%,100%{transition-timing-function:ease-in;-o-transition-timing-function:ease-in;-ms-transition-timing-function:ease-in;-moz-transition-timing-function:ease-in;-webkit-transition-timing-function:ease-in}0%{transform:none;-o-transform:none;-ms-transform:none;-moz-transform:none;-webkit-transform:none}100%{transform:translate3d(0,-500px,0);-o-transform:translate3d(0,-500px,0);-ms-transform:translate3d(0,-500px,0);-moz-transform:translate3d(0,-500px,0);-webkit-transform:translate3d(0,-500px,0)}}@-moz-keyframes bounceoutup{0%,100%{-moz-transition-timing-function:ease-in}0%{-moz-transform:none}100%{-moz-transform:translate3d(0,-500px,0)}}@-webkit-keyframes bounceoutup{0%,100%{-webkit-transition-timing-function:ease-in}0%{-webkit-transform:none}100%{-webkit-transform:translate3d(0,-500px,0)}}@keyframes bounceoutdown{0%,100%{transition-timing-function:ease-in;-o-transition-timing-function:ease-in;-ms-transition-timing-function:ease-in;-moz-transition-timing-function:ease-in;-webkit-transition-timing-function:ease-in}0%{bottom:0}100%{bottom:-500px}}@-moz-keyframes bounceoutdown{0%,100%{-moz-transition-timing-function:ease-in}0%{bottom:0}100%{bottom:-500px}}@-webkit-keyframes bounceoutdown{0%,100%{-webkit-transition-timing-function:ease-in}0%{bottom:0}100%{bottom:-500px}}@keyframes bounceinleft{0%,75%,100%{transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-o-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-ms-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-moz-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-webkit-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{transform:translate3d(200%,0,0);-o-transform:translate3d(200%,0,0);-ms-transform:translate3d(200%,0,0);-moz-transform:translate3d(200%,0,0);-webkit-transform:translate3d(200%,0,0)}75%{transform:translate3d(-10%,0,0);-o-transform:translate3d(-10%,0,0);-ms-transform:translate3d(-10%,0,0);-moz-transform:translate3d(-10%,0,0);-webkit-transform:translate3d(-10%,0,0)}100%{transform:none;-o-transform:none;-ms-transform:none;-moz-transform:none;-webkit-transform:none}}@-moz-keyframes bounceinleft{0%,75%,100%{-moz-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{-moz-transform:translate3d(200%,0,0)}75%{-moz-transform:translate3d(-10%,0,0)}100%{-moz-transform:none}}@-webkit-keyframes bounceinleft{0%,75%,100%{-webkit-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{-webkit-transform:translate3d(200%,0,0)}75%{-webkit-transform:translate3d(-10%,0,0)}100%{-webkit-transform:none}}@keyframes bounceoutright{0%,25%,100%{transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-o-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-ms-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-moz-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-webkit-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{transform:none;-o-transform:none;-ms-transform:none;-moz-transform:none;-webkit-transform:none}25%{transform:translate3d(-10%,0,0);-o-transform:translate3d(-10%,0,0);-ms-transform:translate3d(-10%,0,0);-moz-transform:translate3d(-10%,0,0);-webkit-transform:translate3d(-10%,0,0)}100%{transform:translate3d(200%,0,0);-o-transform:translate3d(200%,0,0);-ms-transform:translate3d(200%,0,0);-moz-transform:translate3d(200%,0,0);-webkit-transform:translate3d(200%,0,0)}}@-moz-keyframes bounceoutright{0%,25%,100%{-moz-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{-moz-transform:none}25%{-moz-transform:translate3d(-10%,0,0)}100%{-moz-transform:translate3d(200%,0,0)}}@-webkit-keyframes bounceoutright{0%,25%,100%{-webkit-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{-webkit-transform:none}25%{-webkit-transform:translate3d(-10%,0,0)}100%{-webkit-transform:translate3d(200%,0,0)}}@keyframes bounceinright{0%,75%,100%{transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-o-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-ms-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-moz-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-webkit-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{transform:translate3d(-200%,0,0);-o-transform:translate3d(-200%,0,0);-ms-transform:translate3d(-200%,0,0);-moz-transform:translate3d(-200%,0,0);-webkit-transform:translate3d(-200%,0,0)}75%{transform:translate3d(10%,0,0);-o-transform:translate3d(10%,0,0);-ms-transform:translate3d(10%,0,0);-moz-transform:translate3d(10%,0,0);-webkit-transform:translate3d(10%,0,0)}100%{transform:none;-o-transform:none;-ms-transform:none;-moz-transform:none;-webkit-transform:none}}@-moz-keyframes bounceinright{0%,75%,100%{-moz-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{-moz-transform:translate3d(-200%,0,0)}75%{-moz-transform:translate3d(10%,0,0)}100%{-moz-transform:none}}@-webkit-keyframes bounceinright{0%,75%,100%{-webkit-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{-webkit-transform:translate3d(-200%,0,0)}75%{-webkit-transform:translate3d(10%,0,0)}100%{-webkit-transform:none}}@keyframes bounceoutleft{0%,25%,100%{transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-o-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-ms-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-moz-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255);-webkit-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{transform:none;-o-transform:none;-ms-transform:none;-moz-transform:none;-webkit-transform:none}25%{transform:translate3d(10%,0,0);-o-transform:translate3d(10%,0,0);-ms-transform:translate3d(10%,0,0);-moz-transform:translate3d(10%,0,0);-webkit-transform:translate3d(10%,0,0)}100%{transform:translate3d(-200%,0,0);-o-transform:translate3d(-200%,0,0);-ms-transform:translate3d(-200%,0,0);-moz-transform:translate3d(-200%,0,0);-webkit-transform:translate3d(-200%,0,0)}}@-moz-keyframes bounceoutleft{0%,25%,100%{-moz-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{-moz-transform:none}25%{-moz-transform:translate3d(10%,0,0)}100%{-moz-transform:translate3d(-200%,0,0)}}@-webkit-keyframes bounceoutleft{0%,25%,100%{-webkit-transition-timing-function:cubic-bezier(.65,-.25,.325,1.255)}0%{-webkit-transform:none}25%{-webkit-transform:translate3d(10%,0,0)}100%{-webkit-transform:translate3d(-200%,0,0)}}@keyframes fadein{0%,100%{transition-timing-function:ease-in;-o-transition-timing-function:ease-in;-ms-transition-timing-function:ease-in;-moz-transition-timing-function:ease-in;-webkit-transition-timing-function:ease-in}0%{opacity:0}100%{opacity:1}}@-moz-keyframes fadein{0%,100%{-moz-transition-timing-function:ease-in}0%{opacity:0}100%{opacity:1}}@-webkit-keyframes fadein{0%,100%{-webkit-transition-timing-function:ease-in}0%{opacity:0}100%{opacity:1}}@keyframes fadeout{0%,100%{transition-timing-function:ease-in;-o-transition-timing-function:ease-in;-ms-transition-timing-function:ease-in;-moz-transition-timing-function:ease-in;-webkit-transition-timing-function:ease-in}0%{opacity:1}100%{opacity:0}}@-moz-keyframes fadeout{0%,100%{-moz-transition-timing-function:ease-in}0%{opacity:1}100%{opacity:0}}@-webkit-keyframes fadeout{0%,100%{-webkit-transition-timing-function:ease-in}0%{opacity:1}100%{opacity:0}}@keyframes fadeindown{0%,100%{transition-timing-function:ease-in;-o-transition-timing-function:ease-in;-ms-transition-timing-function:ease-in;-moz-transition-timing-function:ease-in;-webkit-transition-timing-function:ease-in}0%{opacity:0;height:110%;margin-top:-5%}100%{opacity:1;height:100%;margin-top:0}}@-moz-keyframes fadeindown{0%,100%{-moz-transition-timing-function:ease-in}0%{opacity:0;height:110%;margin-top:-5%}100%{opacity:1;height:100%;margin-top:0}}@-webkit-keyframes fadeindown{0%,100%{-webkit-transition-timing-function:ease-in}0%{opacity:0;height:110%;margin-top:-5%}100%{opacity:1;height:100%;margin-top:0}}@keyframes fadeoutup{0%,100%{transition-timing-function:ease-in;-o-transition-timing-function:ease-in;-ms-transition-timing-function:ease-in;-moz-transition-timing-function:ease-in;-webkit-transition-timing-function:ease-in}0%{opacity:1;height:100%;margin-top:0}100%{opacity:0;height:110%;margin-top:-5%}}@-moz-keyframes fadeoutup{0%,100%{-moz-transition-timing-function:ease-in}0%{opacity:1;height:100%;margin-top:0}100%{opacity:0;height:110%;margin-top:-5%}}@-webkit-keyframes fadeoutup{0%,100%{-webkit-transition-timing-function:ease-in}0%{opacity:1;height:100%;margin-top:0}100%{opacity:0;height:110%;margin-top:-5%}}#growbar_container.Bar{top:0;left:0;width:100%;min-height:40px;max-height:40px}#growbar_container.Bar.large{min-height:58px;max-height:58px}#growbar_pusher{height:30px;overflow:hidden;position:relative}#growbar_pusher.large{height:50px}.growbar#pull-down{top:-4px;right:10px;padding:6px;z-index:16999;display:block;overflow:hidden;position:absolute;border:2px solid #fff;border-radius:0 0 5px 5px;transform:translatey(-40px);-o-transform:translatey(-40px);-ms-transform:translatey(-40px);-moz-transform:translatey(-40px);-webkit-transform:translatey(-40px)}.growbar#pull-down .growbar_arrow{opacity:.3;cursor:pointer;filter:flipv;transform:scaley(-1);-o-transform:scaley(-1);-ms-transform:scaley(-1);-moz-transform:scaley(-1);-webkit-transform:scaley(-1);background-image:url('.asset('/assets').'/images/arrow_white.png)}.growbar#pull-down.regular .growbar_arrow{width:21px;height:21px;background-size:21px 21px}.growbar#pull-down.large .growbar_arrow{width:28px;height:28px;background-size:28px 28px}.growbar#pull-down.bar-bottom{top:auto;bottom:-4px;position:fixed;border-radius:5px 5px 0 0;transform:translatey(40px);-o-transform:translatey(40px);-ms-transform:translatey(40px);-moz-transform:translatey(40px);-webkit-transform:translatey(40px)}.growbar#pull-down.bar-bottom .growbar_arrow{filter:none;transform:none;-o-transform:none;-ms-transform:none;-moz-transform:none;-webkit-transform:none}#growbar_container.Bar.remains_in_place{top:0;position:fixed;_position:absolute;_top:expression(eval(document.body.scrollTop))}#growbar_container.Bar.bar-bottom{top:auto;bottom:0;position:fixed;_position:absolute;_bottom:expression(eval(document.body.scrollTop))}#growbar_container.Bar.animated,.growbar#pull-down.animated{transform:translatey(-60px);-o-transform:translatey(-60px);-ms-transform:translatey(-60px);-moz-transform:translatey(-60px);-webkit-transform:translatey(-60px);animation-duration:1s;-o-animation-duration:1s;-ms-animation-duration:1s;-moz-animation-duration:1s;-webkit-animation-duration:1s}#growbar_container.Bar.animateIn,.growbar#pull-down.animateIn{animation-name:bounceindown;-o-animation-name:bounceindown;-ms-animation-name:bounceindown;-moz-animation-name:bounceindown;-webkit-animation-name:bounceindown}#growbar_container.Bar.animateOut,.growbar#pull-down.animateOut{animation-name:bounceoutup;-o-animation-name:bounceoutup;-ms-animation-name:bounceoutup;-moz-animation-name:bounceoutup;-webkit-animation-name:bounceoutup}#growbar_container.Bar.animated.bar-bottom,.growbar#pull-down.animated.bar-bottom{transform:translatey(60px);-o-transform:translatey(60px);-ms-transform:translatey(60px);-moz-transform:translatey(60px);-webkit-transform:translatey(60px);animation-duration:1s;-o-animation-duration:1s;-ms-animation-duration:1s;-moz-animation-duration:1s;-webkit-animation-duration:1s}#growbar_container.Bar.animateIn.bar-bottom,.growbar#pull-down.animateIn.bar-bottom{animation-name:bounceinup;-o-animation-name:bounceinup;-ms-animation-name:bounceinup;-moz-animation-name:bounceinup;-webkit-animation-name:bounceinup}#growbar_container.Bar.animateOut.bar-bottom,.growbar#pull-down.animateOut.bar-bottom{animation-name:bounceoutdown;-o-animation-name:bounceoutdown;-ms-animation-name:bounceoutdown;-moz-animation-name:bounceoutdown;-webkit-animation-name:bounceoutdown}@keyframes wiggle{2%{-webkit-transform:translatex(3px) rotate(2deg);transform:translatex(3px) rotate(2deg)}4%{-webkit-transform:translatex(-3px) rotate(-2deg);transform:translatex(-3px) rotate(-2deg)}6%{-webkit-transform:translatex(3px) rotate(2deg);transform:translatex(3px) rotate(2deg)}8%{-webkit-transform:translatex(-3px) rotate(-2deg);transform:translatex(-3px) rotate(-2deg)}10%{-webkit-transform:translatex(2px) rotate(1deg);transform:translatex(2px) rotate(1deg)}12%{-webkit-transform:translatex(-2px) rotate(-1deg);transform:translatex(-2px) rotate(-1deg)}14%{-webkit-transform:translatex(2px) rotate(1deg);transform:translatex(2px) rotate(1deg)}16%{-webkit-transform:translatex(-2px) rotate(-1deg);transform:translatex(-2px) rotate(-1deg)}18%{-webkit-transform:translatex(1px) rotate(0);transform:translatex(1px) rotate(0)}20%{-webkit-transform:translatex(-1px) rotate(0);transform:translatex(-1px) rotate(0)}}#gb-headline-counter-holder{height:20px;display:inline-block;width:';
        if(isset($range) && $range == "day"){
            $content .= 160;
        }else{
            $content .= 120;
        }

        $content .= 'px;position:relative;}#gb-headline-counter-holder.large>div{position:absolute !important;}#gb-headline-counter-holder.regular>div{position:absolute !important;top:4px !important;}";
            //GB.addCSS(styles);

            var gstyles = document.createElement("style");
            gstyles.type = "text/css";
            if (gstyles.styleSheet){
            gstyles.styleSheet.cssText = rawstyles;
            } else {
            gstyles.appendChild(document.createTextNode(rawstyles));
            }


            document.head.appendChild(gstyles);
            /******************************* Main Bar Created ********************************/
            /******************************* Pull Down Div ***********************************/
            var pulldownDiv = document.createElement("div");
            pulldownDiv.setAttribute("id", "pull-down");
            pulldownDiv.setAttribute("class", "'. $size.' growbar bar-'. $position.'");
            var pulldownArrowDiv = document.createElement("div");
            pulldownArrowDiv.setAttribute("class", "growbar_arrow");
            pulldownDiv.appendChild(pulldownArrowDiv);
            pulldownDiv.onclick = function(){
            GB.animateIn(document.getElementById("growbar_container"));GB.animateOut(document.getElementById("pull-down"));
            };
            /******************************* Pull Down Div ***********************************/';


//        if($growBar->push == '1'){
            $content .= '
            /******************************* GrowBar Pusher (Conditional) ***********************/
            var pusherDiv = document.createElement("div");
            pusherDiv.setAttribute("id", "growbar_pusher");
            pusherDiv.setAttribute("class", "'.$size.'");';
//        }

        $content .= 'window.onload = function(){';

        if($growBar->position == "Top"){
            $content .= '
                 containerDiv.appendChild(mainDiv);
                 document.body.insertBefore(pulldownDiv,document.body.childNodes[0]);
                 pulldownDiv.parentNode.insertBefore(containerDiv, pulldownDiv.nextSibling);
                 containerDiv.parentNode.insertBefore(pusherDiv, containerDiv.nextSibling);';
        }else {
            $content .= '
                 containerDiv.appendChild(mainDiv);
                 document.body.appendChild(pulldownDiv);
                 document.body.appendChild(containerDiv);
                 document.body.appendChild(pusherDiv);';
        }

        if($growBar->wiggle == '1') {
            $content .= 'GB.wiggleEventListeners(document.getElementById("growbar")); ';
        }

        if(stripos($growBar->headline,"[[gcdown]]") !== false) {
            $content .= ' var myCountdown4 = new Countdown({
                year: ' . $year . ',
                month:' . $month . ',
                day:' . $day . ',
                hour:' . $hour . ',
                minute:' . $minute . ',
                second:' . $second . ',
                //time:500,
                target:"gb-headline-counter-holder",
                rangeHi: "' . $range . '",
                rangeLo: "second",
                hideLine: 1,
                ';

            if ($range == "day") {
                $content .= ' width:"160",';
            } else {
                $content .= ' width:"120",';
            }

            if($size == 'large'){
                $content .= '
                    height:38,
                    labels : {
                    font   : "Arial",
                    color  : "'. $cdlc .'",
                    weight : "normal" // < - no comma on last item!
                },';
            } else {
                $content .= '
                height:24,
                hideLabels: true,';
            }
            $content .= '
                numbers: {

                    font	: "Arial",
                    color	: "'. $cdtxt .'",
                    bkgd	: "'. $cdbg .'",
                    fontSize : 150,
                    rounded	: 0.15,				// percentage of size
                    shadow	: {
                                x : 0,			// x offset (in pixels)
                                y : 3,			// y offset (in pixels)
                                s : 4,			// spread
                                c : "#000000",	// color
                                a : 0.4			// alpha	// <- no comma on last item!
                                }
                    }
                });';
        }


        echo $content.'}';die;

    }

    public function encode($string,$key) {
        $key = sha1($key);
        $strLen = strlen($string);
        $keyLen = strlen($key);
        $j=0;
        $hash = '';
        for ($i = 0; $i < $strLen; $i++) {
            $ordStr = ord(substr($string,$i,1));
            if ($j == $keyLen) { $j = 0; }
            $ordKey = ord(substr($key,$j,1));
            $j++;
            $hash .= strrev(base_convert(dechex($ordStr + $ordKey),16,36));
        }
        return $hash;
    }

    public function decode($string,$key) {
        $key = sha1($key);
        $strLen = strlen($string);
        $keyLen = strlen($key);
        $hash = '';
        $j=0;
        for ($i = 0; $i < $strLen; $i+=2) {
            $ordStr = hexdec(base_convert(strrev(substr($string,$i,2)),36,16));
            if ($j == $keyLen) { $j = 0; }
            $ordKey = ord(substr($key,$j,1));
            $j++;
            $hash .= chr($ordStr - $ordKey);
        }
        return $hash;
    }

    public function get_services()
    {
        $userServices = UserService::where('user_id', '=', \Auth::user()->id)->get();
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
}
