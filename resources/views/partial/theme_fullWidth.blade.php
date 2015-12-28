<div class="bottom_form bottom_form4 glink-bg {{$position_theme}}" id="full_width"
     style="display: {!! ((isset($snip_data['theme'])&& $snip_data['theme']=='Full-Width')?'block':'none') !!};">

    <div class="profile_info" style="background:{!! ((isset($snip_data['background_color']))?$snip_data['background_color']:'none') !!};">

        <form action="" method="post">
            <ul>
                <li style="line-height: 4;">
                                
                            <span class="full-width">
                                <span class="" id="profile_left_img"></span>
                                <span class="msg" id="profile_left_msg2"
                                      style="{!! ((isset($snip_data['text_color']))?'color:#'.$snip_data['text_color']:'') !!};">
                                    {!! (isset($snip_data['message'])?$snip_data['message']:'Enter your message') !!} 
                                </span>
                                <span id="button-Full-Width">
                                    <input type="submit" class="btn btn-theme snip_click" id="snip_click"
                                           name="submit_btn"
                                           style="{!! ((isset($snip_data['action_color']))?'background:#'.$snip_data['action_color'].';':'') !!}{!! ((isset($snip_data['action_text_color']))?'color:#'.$snip_data['action_text_color'].';':'') !!};"
                                           value="{!! (isset($snip_data['button_text'])?$snip_data['button_text']:'Button Text') !!}">
                                </span>
                                <span id="form-Full-Width"
                                      style="display: {!! ((isset($snip_data['snip_type'])&& $snip_data['snip_type']=='form')?'block':'none') !!};">
                                    <span class="btn">
                                        <input type="email" placeholder="Email Address" required class="form-control"
                                               id="email-Full-Width" name="email">
                                    </span>
                                    <span class="form-group">
                                        <input type="submit" class="btn btn-sm btn-theme" value="Submit">
                                    </span>

                                </span>
                            </span>
                            <span class="profile_right close">
                                @if($user_type==2)
                                    <span class="company_name">UserGrow</span> <a href="#">X</a>
                                @endif
                            </span>
                </li>
            </ul>
        </form>
    </div>
    <!-- profile info-->
    <div class="clear"></div>
</div>