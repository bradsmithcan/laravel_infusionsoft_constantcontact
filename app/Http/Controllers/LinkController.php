<?php

namespace App\Http\Controllers;

use App\Models\Clicks;
use App\Models\Conversions;
use Doctrine\Instantiator\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\Snips;
use App\Models\SnipLayouts;
use App\Models\Profile;
use App\User;
use Mockery\Exception;
use Monolog\Handler\Curl;
use App\Models\Domains;
use App\Models\Api;

class LinkController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {

        $final_array = array();

        $get_child_profiles = array();

        $user_id = \Auth::user()->id;

        $snips = Snips::leftJoin('snip_layouts', 'snip_layouts.snip_id', '=', 'snips.id')
            ->leftjoin('child_profiles','child_profiles.id','=','snips.user_id')
            ->leftjoin('domains','domains.id','=','snips.domain_id')
            ->select('domains.name as service_name','snips.*','snips.user_id as user_id','child_profiles.child_name','child_profiles.child_home_url','child_profiles.child_pic','child_profiles.child_pic_resize')
            ->where('snips.parent_id', $user_id)
            ->orderby('snips.id','DESC')
            ->get()
            ->toArray();

        if(is_array($snips)){

            foreach($snips as $count=>$peritem){

                $countclicksTotal = Clicks::
                select("*")
                    ->where('clicks.snip_id', $peritem['id'])
                    ->count();

                $countConversionsTotal = Conversions::
                select("*")
                    ->where('conversions.snip_id', $peritem['id'])
                    ->count();

                $final_array[$count]                = $peritem;
                $final_array[$count]['clicks']      = $countclicksTotal;
                $final_array[$count]['conversions'] = $countConversionsTotal;

            }

        }

        return view('link.index')->with('links', $final_array);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {

        $UserObj = \Auth::user();
        $users = array();

        $users[\Auth::user()->id] = \Auth::user()->name;

        $users_arr = Profile::select('id', 'parent_id', 'child_name')->where('parent_id', $UserObj->id)->orWhere('parent_id', $UserObj->parent_user)->get();
        foreach ($users_arr as $key => $val) {
            $users[$val->id] = $val->child_name;
        }
        $users['addprofile'] = 'Add Profile';
        $domains = array();
        $domains_arr = Domains::select('id','name')->get();
        foreach ($domains_arr as $key => $val) {
            $domains[$val->id] = $val->name;
        }
        $email_services = array();
        $email_services_arr = Api::select('id','name')->get();
        foreach ($email_services_arr as $key => $val) {
            $email_services[$val->id] = $val->name;
        }

        $feed_type = array('Page_url' => 'PAGE URL', 'RSS_feed' => 'RSS FEED URL', 'Trap.it feed' => 'Trap.it RSS FEED');
        $themes = array('Social' => 'Social', 'Candy' => 'Candy', 'Big-Candy' => 'Big Candy', 'Bean' => 'Bean', 'Full-Width' => 'Full Width');
        $position = array('Top_Left' => 'Top Left', 'Top_Right' => 'Top Right', 'Bottom_Left' => 'Bottom Left', 'Bottom_Right' => 'Bottom Right');
        $timestamp = time();
        $hash = md5('unique_salt' . $timestamp);
        $child_profile = array(
            'name' => \Auth::user()->name,
            'url' => '',
            'image' => ""
        );
        $snip_data = array('theme' => 'Social');
        $user_type = $UserObj->type;
        $position_theme = 'bottom-left-div';

        return view('link.create')->with(compact('users', 'feed_type', 'themes', 'timestamp', 'hash', 'position', 'snip_data', 'domains', 'email_services', 'child_profile', 'user_type', 'position_theme'));
    }

    public function get_backgrounds()
    {
        $backgrounds = Background::all();

        return $backgrounds;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request) {

        $snip_user = \Auth::user()->id;
        $token = $request->ajax() ? $request->header('X-CSRF-Token') : $request->input('_token');
        $remarketing = $request->input('remarketing');
        $pageurls = $request->input('pageurl');
        $user_id = $request->input('user_id');
        $domain_id = $request->input('domain_id');
        $email_service_id = $request->input('email_service_id');
        $button = $request->input('create_button_snip_code');
        $message = $request->input('message');
        $buttontext = $request->input('buttontext');
        $buttonurl = $request->input('buttonurl');
        $bg_gcolor = $request->input('bg_gcolor');
        $textcolor = $request->input('textcolor');
        $actioncolor = $request->input('actioncolor');
        $action_textcolor = $request->input('action_textcolor');
        $action_type = $request->input('action_type');
        $themetype = $request->input('themetype');
        $posttext = $request->input('posttext');
        $upload_path = $request->input('upload_path');
        $feed_type = strtolower(html_entity_decode($request->input('feedtype')));
        $short_option = $request->input('short_option');
        $short_link = $request->input('short_link');

        /*
         * Getting Domain name for short link routing
         */
        $domain_name = 'http://trkn.co';
        $domainObj = Domains::select('name')->where('id',$domain_id)->get()->toArray();
        if(is_array($domainObj) && sizeof($domainObj)>0){
            foreach($domainObj as $key=>$val){
                $domain_name = $val['name'];
            }
        }

        if ($feed_type == 'trap.it feed') {

            $content = file_get_contents($pageurls);
            $x = new \SimpleXmlElement($content);

            $counter = 0;

            foreach ($x->entry as $entry) {

                $page_url = $entry->link['href'][0];

                $arrrr = htmlentities($remarketing, ENT_QUOTES);
                $html = $this->file_get_contents_curl($page_url, array());

                $title =  '';
                if(!empty($html)){
                    $doc = new \DOMDocument();
                    @$doc->loadHTML($html);
                    $nodes = $doc->getElementsByTagName('title');
                    $title = addslashes($nodes->item(0)->nodeValue);
                }
                $date = date('Y-m-d h:i:s');

                //============Snips Creation=================//

                $snipObj = new Snips();
                $snipObj->user_id = $user_id;
                $snipObj->domain_id = $domain_id;
                $snipObj->service_id = $email_service_id;
                $snipObj->parent_id = $snip_user;
                $snipObj->page_url = $page_url;
                $snipObj->title = $title ;
                $snipObj->snip_type = $action_type;
                $snipObj->message = $message;
                $snipObj->snip_remarketing_code = $arrrr;
                $snipObj->button_text = $buttontext;
                $snipObj->button_url = $buttonurl;
                $snipObj->upload_path = $upload_path;
                $snipObj->date_created = $date;
                $snipObj->custom_short_link = $short_link;
                $snipObj->is_custom_short_link = $short_option;
                $snipObj->save();
                $current_id = $snipObj->id;
                if ($current_id) {
                    $snip = array("snip_id" => $current_id, "user_id" => $user_id, "background_color" => $bg_gcolor, "text_color" => $textcolor, "action_color" => $actioncolor, "action_text_color" => $action_textcolor, "theme" => $themetype, "position" => $posttext);
                    $layout_id = SnipLayouts::insert($snip);
                }

                if($short_option == 2)
                    $links['data'][] = $domain_name."/g/"  . $short_link;
                else
                    $links['data'][] = $domain_name."/g/"  . $current_id;
            }

            echo json_encode($links['data']);
            die;
        }


        if ($feed_type == "rss_feed") {

            $links = array();
            $pageurls = $_POST['pageurl'];

            $content = file_get_contents($pageurls);
            $x = new \SimpleXMLElement($content);


            foreach ($x->channel->item as $entry) {

                $page_url = $entry->link;

                $arrrr = htmlentities($remarketing, ENT_QUOTES);
                $html = $this->file_get_contents_curl($page_url, array());
                $title =  '';
                if(!empty($html)){
                    $doc = new \DOMDocument();
                    @$doc->loadHTML($html);
                    $nodes = $doc->getElementsByTagName('title');
                    $title = addslashes($nodes->item(0)->nodeValue);
                }

                $date = date('Y-m-d h:i:s');

                //============Snips Creation=================//

                $snipObj = new Snips();
                $snipObj->user_id = $user_id;
                $snipObj->domain_id = $domain_id;
                $snipObj->service_id = $email_service_id;
                $snipObj->parent_id = $snip_user;
                $snipObj->page_url = $page_url;
                $snipObj->title = $title;
                $snipObj->snip_type = $action_type;
                $snipObj->message = $message;
                $snipObj->snip_remarketing_code = $arrrr;
                $snipObj->button_text = $buttontext;
                $snipObj->button_url = $buttonurl;
                $snipObj->upload_path = $upload_path;
                $snipObj->date_created = $date;
                $snipObj->custom_short_link = $short_link;
                $snipObj->is_custom_short_link = $short_option;
                $snipObj->save();
                $current_id = $snipObj->id;
                if ($current_id) {

                    $snip = array("snip_id" => $current_id, "user_id" => $user_id, "background_color" => $bg_gcolor, "text_color" => $textcolor, "action_color" => $actioncolor, "action_text_color" => $action_textcolor, "theme" => $themetype, "position" => $posttext);
                    $layout_id = SnipLayouts::insert($snip);
                }

                $links['data'][] = $domain_name."/g/"  . $current_id;

            }

            echo json_encode($links['data']);
            die;

        } else {

            $url = parse_url($pageurls);

            if (count($url) > 1) {

                $host = $url['scheme'] . "://";
                $page_url = $host . $url['host'];

                if (isset($url['path'])) {
                    $page_url .= $url['path'];
                }
            } else {

                $path = $url['path'];
                $page_url = "http://" . $path;
            }
            $arrrr = htmlentities($remarketing, ENT_QUOTES);
            $title = '';

            $html = $this->file_get_contents_curl($page_url, array());

            if(!empty($html)){
                $doc = new \DOMDocument();
                @$doc->loadHTML($html);
                $nodes = $doc->getElementsByTagName('title');

                if(isset($nodes->item(0)->nodeValue)){
                    $title = addslashes($nodes->item(0)->nodeValue);
                }else{
                    $title = "";
                }

            }

            $date = date('Y-m-d h:i:s');

            //============Snips Creation=================//

            $snipObj = new Snips();
            $snipObj->user_id = $user_id;
            $snipObj->domain_id = $domain_id;
            $snipObj->service_id = $email_service_id;
            $snipObj->parent_id = $snip_user;
            $snipObj->page_url = $page_url;
            $snipObj->title = $title;
            $snipObj->snip_type = $action_type;
            $snipObj->message = $message;
            $snipObj->snip_remarketing_code = $arrrr;
            $snipObj->button_text = $buttontext;
            $snipObj->button_url = $buttonurl;
            $snipObj->upload_path = $upload_path;
            $snipObj->date_created = $date;
            $snipObj->custom_short_link = $short_link;
            $snipObj->is_custom_short_link = $short_option;
            $snipObj->save();

            if ($snipObj->id) {

                $current_id = $snipObj->id;

                if ($current_id) {

                    $snip = array("snip_id" => $snipObj->id, "user_id" => $user_id, "background_color" => $bg_gcolor, "text_color" => $textcolor, "action_color" => $actioncolor, "action_text_color" => $action_textcolor, "theme" => $themetype, "position" => $posttext);
                    $layout_id = SnipLayouts::insert($snip);

                }
            }

            if($short_option == 2)
                $links['data'][] = $domain_name."/g/"  . $short_link;
            else
                $links['data'][] = $domain_name."/g/"  . $snipObj->id;

            echo json_encode($links['data']);
            die;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {

        $UserObj = \Auth::user();

        $snip_data = Snips::join('snip_layouts', 'snip_layouts.snip_id', '=', 'snips.id')->where('snips.id',$id)->get()->toArray();

        $users = array();

        $users[''] = 'Select Profile';
        $users[\Auth::user()->id] = \Auth::user()->name;

        if(isset($snip_data[0])){
            $snip_data = $snip_data[0];
        }

        $profile_arr = Profile::select('id', 'parent_id', 'child_name', 'child_pic')->where('id', $snip_data['user_id'])->get()->toArray();

        $child_profile = array(
            'name' => '',
            'url' => '',
            'image' => ""
        );

        foreach ($profile_arr as $key => $val) {
            $child_profile = array(
                'name' => $val['child_name'],
                'image' => "/images/profiles/".$val['child_pic']
            );
        }

        $users_arr = Profile::select('id', 'parent_id', 'child_name')->where('parent_id', $UserObj->id)->get();

        foreach ($users_arr as $key => $val) {
            $users[$val->id] = $val->child_name;
        }

        $users['addprofile'] = 'Add Profile';

        $domains = array();
        $domains_arr = Domains::select('id','name')->get();

        foreach ($domains_arr as $key => $val) {
            $domains[$val->id] = $val->name;
        }

        $email_services = array();
        $email_services_arr = Api::select('id','name')->get();
        foreach ($email_services_arr as $key => $val) {
            $email_services[$val->id] = $val->name;
        }


        $feed_type  = array('Page_url' => 'PAGE URL', 'RSS_feed' => 'RSS FEED URL', 'Trap.it feed' => 'Trap.it RSS FEED');
        $themes     = array('Social' => 'Social', 'Candy' => 'Candy', 'Big-Candy' => 'Big Candy', 'Bean' => 'Bean', 'Full-Width' => 'Full Width');
        $position   = array('Top_Left' => 'Top Left', 'Top_Right' => 'Top Right', 'Bottom_Left' => 'Bottom Left', 'Bottom_Right' => 'Bottom Right');


        $position_theme = 'bottom-left-div';

        if(isset($snip_data['position'])&& $snip_data['position']=='Top_Left'){
            $position_theme =  'top-left-div';
        }elseif(isset($snip_data['position'])&& $snip_data['position']=='Top_Right'){
            $position_theme =  'top-right-div';
        }elseif(isset($snip_data['position'])&& $snip_data['position']=='Bottom_Left'){
            $position_theme =  'bottom-left-div';
        }elseif(isset($snip_data['position'])&& $snip_data['position']=='Bottom_Right'){
            $position_theme =  'bottom-right-div';
        }

        $timestamp = time();
        $hash = md5('unique_salt' . $timestamp);
        $user_type = $UserObj->type;
        return view('link.edit')->with(compact('users', 'feed_type', 'themes', 'timestamp', 'hash', 'position', 'snip_data', 'domains', 'email_services', 'child_profile', 'position_theme', 'user_type'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {

        $snip_user = \Auth::user()->id;
        $token = $request->ajax() ? $request->header('X-CSRF-Token') : $request->input('_token');
        $remarketing = $request->input('remarketing');
        $pageurls = $request->input('pageurl');
        $user_id = $request->input('user_id');
        $domain_id = $request->input('domain_id');
        $email_service_id = $request->input('email_service_id');
        $button = $request->input('create_button_snip_code');
        $message = $request->input('message');
        $buttontext = $request->input('buttontext');
        $buttonurl = $request->input('buttonurl');
        $bg_gcolor = $request->input('bg_gcolor');
        $textcolor = $request->input('textcolor');
        $actioncolor = $request->input('actioncolor');
        $action_textcolor = $request->input('action_textcolor');
        $action_type = $request->input('action_type');
        $themetype = $request->input('themetype');
        $posttext = $request->input('posttext');
        $upload_path = $request->input('upload_path');
        $feed_type = $request->input('feedtype');

        $short_option = $request->input('short_option');
        $short_link = $request->input('short_link');

        /*
 * Getting Domain name for short link routing
 */
        $domain_name = 'http://trkn.co';
        $domainObj = Domains::select('name')->where('id',$domain_id)->get()->toArray();
        if(is_array($domainObj) && sizeof($domainObj)>0){
            foreach($domainObj as $key=>$val){
                $domain_name = $val['name'];
            }
        }

        if ($feed_type == 'trap.it feed') {

            $content = file_get_contents($pageurls);
            $x = new \SimpleXmlElement($content);

            $counter = 0;

            foreach ($x->entry as $entry) {

                $page_url = $entry->link['href'][0];

                $arrrr = htmlentities($remarketing, ENT_QUOTES);
                $html = $this->file_get_contents_curl($page_url, array());

                $title =  '';
                if(!empty($html)){
                    $doc = new \DOMDocument();
                    @$doc->loadHTML($html);
                    $nodes = $doc->getElementsByTagName('title');
                    $title = addslashes($nodes->item(0)->nodeValue);
                }
                $date = date('Y-m-d h:i:s');

                //============Snips Creation=================//

                $snipObj = Snips::findOrNew($id);
                $snipObj->user_id = $user_id;
                $snipObj->domain_id = $domain_id;
                $snipObj->service_id = $email_service_id;
                $snipObj->parent_id = $snip_user;
                $snipObj->page_url = $page_url;
                $snipObj->title = $title ;
                $snipObj->snip_type = $action_type;
                $snipObj->message = $message;
                $snipObj->snip_remarketing_code = $arrrr;
                $snipObj->button_text = $buttontext;
                $snipObj->button_url = $buttonurl;
                $snipObj->upload_path = $upload_path;
                $snipObj->date_created = $date;
                $snipObj->custom_short_link = $short_link;
                $snipObj->is_custom_short_link = $short_option;
                $current_id = $snipObj->update();

                echo $snipObj->id;
                die;

                if ($current_id) {

                    $snip = array(
                        "background_color" => $bg_gcolor,
                        "text_color" => $textcolor,
                        "action_color" => $actioncolor,
                        "action_text_color" => $action_textcolor,
                        "theme" => $themetype,
                        "position" => $posttext
                    );

                    $layout_id = SnipLayouts::where("snip_id", $id )->update($snip);

                }

                if($short_option==2)
                    $links['data'][] = $domain_name."/g/"  . $short_link;
                else
                    $links['data'][] = $domain_name."/g/" . $id;

            }

            echo json_encode($links['data']);
            die;
        }


        if ($feed_type == "rss feed") {

            $links = array();
            $pageurls = $_POST['pageurl'];

            $content = file_get_contents($pageurls);
            $x = new \SimpleXMLElement($content);


            foreach ($x->channel->item as $entry) {

                $page_url = $entry->link;

                $arrrr = htmlentities($remarketing, ENT_QUOTES);
                $html = $this->file_get_contents_curl($page_url, array());
                $title =  '';
                if(!empty($html)){
                    $doc = new \DOMDocument();
                    @$doc->loadHTML($html);
                    $nodes = $doc->getElementsByTagName('title');
                    $title = addslashes($nodes->item(0)->nodeValue);
                }

                $date = date('Y-m-d h:i:s');

                //============Snips Creation=================//

                $snipObj = Snips::findOrNew($id);
                $snipObj->user_id = $user_id;
                $snipObj->domain_id = $domain_id;
                $snipObj->service_id = $email_service_id;
                $snipObj->parent_id = $snip_user;
                $snipObj->page_url = $page_url;
                $snipObj->title = $title;
                $snipObj->snip_type = $action_type;
                $snipObj->message = $message;
                $snipObj->snip_remarketing_code = $arrrr;
                $snipObj->button_text = $buttontext;
                $snipObj->button_url = $buttonurl;
                $snipObj->upload_path = $upload_path;
                $snipObj->date_created = $date;
                $snipObj->custom_short_link = $short_link;
                $snipObj->is_custom_short_link = $short_option;
                $current_id = $snipObj->update();
                if ($current_id) {

                    $snip = array("snip_id" => $id, "user_id" => $user_id, "background_color" => $bg_gcolor, "text_color" => $textcolor, "action_color" => $actioncolor, "action_text_color" => $action_textcolor, "theme" => $themetype, "position" => $posttext);
                    $layout_id = SnipLayouts::where("snip_id", $id )->update($snip);
                }

                if($short_option==2)
                    $links['data'][] = $domain_name."/g/"  . $short_link;
                else
                    $links['data'][] = $domain_name."/g/" . $id;

            }

            echo json_encode($links['data']);
            die;
        } else {

            $url = parse_url($pageurls);

            if (count($url) > 1) {

                $host = $url['scheme'] . "://";
                $page_url = $host . $url['host'];

                if (isset($url['path'])) {
                    $page_url .= $url['path'];
                }
            } else {

                $path = $url['path'];
                $page_url = "http://" . $path;
            }
            $arrrr = htmlentities($remarketing, ENT_QUOTES);
            $title = '';
            $html = $this->file_get_contents_curl($page_url, array());
            if(!empty($html)){
                $doc = new \DOMDocument();
                @$doc->loadHTML($html);
                $nodes = $doc->getElementsByTagName('title');
                $title = addslashes($nodes->item(0)->nodeValue);
            }
            $date = date('Y-m-d h:i:s');

            //============Snips Creation=================//

            $snipObj = Snips::findOrNew($id);
            $snipObj->user_id = $user_id;
            $snipObj->domain_id = $domain_id;
            $snipObj->service_id = $email_service_id;
            $snipObj->parent_id = $snip_user;
            $snipObj->page_url = $page_url;
            $snipObj->title = $title;
            $snipObj->snip_type = $action_type;
            $snipObj->message = $message;
            $snipObj->snip_remarketing_code = $arrrr;
            $snipObj->button_text = $buttontext;
            $snipObj->button_url = $buttonurl;
            $snipObj->upload_path = $upload_path;
            $snipObj->date_created = $date;
            $snipObj->custom_short_link = $short_link;
            $snipObj->is_custom_short_link = $short_option;
            $current_id = $snipObj->update();

            if ($current_id) {

                $snip = array(
                    "snip_id" => $id,
                    "user_id" => $user_id,
                    "background_color" => $bg_gcolor,
                    "text_color" => $textcolor,
                    "action_color" => $actioncolor,
                    "action_text_color" => $action_textcolor,
                    "theme" => $themetype,
                    "position" => $posttext
                );

                $layout_id = SnipLayouts::where("snip_id", $snipObj->id )->update($snip);

            }

            if($short_option == 2)
                $links['data'][] = $domain_name."/g/"  . $short_link;
            else
                $links['data'][] = $domain_name."/g/" . $snipObj->id;

            echo json_encode($links['data']);
            die;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        Snips::destroy($id);
        return redirect('link');

    }

    /**
     * Checking Page Url .
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxUrlChecking(Request $request) {

        $id = $request->get('id');
        $action = strtolower(html_entity_decode($request->get('action')));

        /*
         * profile functionality
         */

        if ($action == 'trap.it feed') {

            $content = @file_get_contents($id);

            try{

                $x = new \SimpleXmlElement($content);

            }catch (\Exception $ex){
                echo 'invalid';
                die;
            }

            if (empty($content)) {
                echo 'invalid';
                die;
            }

            $counter = 0;

            foreach ($x->entry as $entry) {

                if ($entry->link['href'][0]) {
                    $counter++;
                }
            }

            if ($counter > 0) {
                echo 'valid';
            } else {
                echo 'invalid';
            }

            die;
        }


        if ($action == 'rss_feed') {

            $content = @file_get_contents($id);

            if (empty($content)) {
                echo 'invalid';
                die;
            }

            try{

                $x = new \SimpleXmlElement($content);

                if(isset($x->channel->item)){

                    $counter = 0;
                    foreach ($x->channel->item as $entry) {
                        $counter++;
                    }

                    if ($counter > 0) {
                        echo 'valid';
                    } else {
                        echo 'invalid';
                    }

                    die;

                }

            }catch (\Exception $ex){
                echo 'invalid';
                die;
            }


        }

        if ($action == 'profile') {

            $get_profile_info = Profile::select()->where('id', $id)->get()->toArray();
            $data_array = array();


            if (empty($get_profile_info)) {

                $get_profile_info = User::select()->where('id', $id)->get()->toArray();
                foreach ($get_profile_info as $key => $val) {
                    $data_array = array(
                        'name' => $val['name'],
                        'url' => $val['homeurl'],
                        'pic' => "/images/profiles/".$val['image']
                    );
                }
            } else {

                foreach ($get_profile_info as $key => $val) {
                    $data_array = array(
                        'name' => $val['child_name'],
                        'url' => $val['child_home_url'],
                        'pic' => "/images/profiles/".$val['child_pic']
                    );
                }
            }

            echo json_encode($data_array);
        }
    }


    /**
     * Checking Page Url .
     *
     * @return \Illuminate\Http\Response
     */
    public function ajaxCheckShortLink(Request $request) {

        $link = $request->get('short_link');



        $get_link_info = Snips::select()->where('custom_short_link', $link)->get()->toArray();
        $data_array = array();


        if (empty($get_link_info)) {

            $data_array = array(
                'class' => 'alert alert-success',
                'msg' => 'Link Was available.',
            );

        } else {

            $data_array = array(
                'class' => 'alert alert-danger',
                'msg' => 'This short link was not available.'
            );

        }

        echo json_encode($data_array);
    }

    /**
     * Making CURL Call
     */
    public function file_get_contents_curl($url,$params) {

        $string = '';
        foreach ($params as $key => $value) {
            $string .= $key . '=' . $value . '&';
        }
        rtrim($string, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($params));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($ch);
        $curl_error = curl_error($ch);
        if (!empty($curl_error)) {
            echo curl_error($ch);
            exit;
        }
        curl_close($ch);
        return $data;
    }

    /*
     * Multi Array Sorting
     */
    public function unique_multidim_array($array, $key){
        $temp_array = array();
        $i = 0;
        $key_array = array();

        foreach($array as $val){
            if(!in_array($val[$key],$key_array)){
                $key_array[$i] = $val[$key];
                $temp_array[$i] = $val;
            }
            $i++;
        }
        return $temp_array;
    }

    function cmp($a,$b){
        return strtotime($a['created_at'])<strtotime($b['created_at'])?1:-1;
    }


}
