<div class="bottom_form bottom_form2 bean glink-bg {{$position_theme}}" id="candy" style="display: {!! ((isset($snip_data['theme'])&& $snip_data['theme']=='Candy')?'block':'none') !!};{!! ((isset($snip_data['background_color']))?'background:#'.$snip_data['background_color']:'') !!};">
    <div class="profile_pic">
        <img src="{!! URL::asset('') !!}<?php
        if (!empty($child_profile['image'])) {
            echo $child_profile['image'];
        } else {
        ?>assets/images/user.png<?php } ?>" width="" height="80">
    </div>
    <div class="profile_info">
        <form action="" method="post">
            <ul>
                <li><span class="profile_left name">
                                <a href="#"
                                   style="{!! ((isset($snip_data['text_color']))?'color:#'.$snip_data['text_color']:'') !!};"> <?php
                                    if (!empty($child_profile['name'])) {
                                        echo ucfirst($child_profile['name']);
                                    }
                                    ?>
                                </a></span> <span class="profile_right close">
                                    @if($user_type==2)
                            <span class="company_name">UserGrow</span> <a href="#">X</a>
                        @endif
                                </span>
                </li>
                <li><span class="profile_left msg" id="profile_left_msg3" style="{!! ((isset($snip_data['text_color']))?'color:#'.$snip_data['text_color']:'') !!};">{!! (isset($snip_data['message'])?$snip_data['message']:'Enter your message') !!} </span>
                            <span id="button-Candy" class="profile_right">
                                <input type="submit" class="btn btn-theme snip_click" id="snip_click" name="submit_btn"
                                       style="{!! ((isset($snip_data['action_color']))?'background:#'.$snip_data['action_color'].';':'') !!}{!! ((isset($snip_data['action_text_color']))?'color:#'.$snip_data['action_text_color'].';':'') !!};"
                                       value="{!! (isset($snip_data['button_text'])?$snip_data['button_text']:'Button Text') !!}">
                            </span>
                    <div id="form-Candy"
                         style="display: {!! ((isset($snip_data['snip_type'])&& $snip_data['snip_type']=='form')?'block':'none') !!};">
                        <div class="form-group">
                            <input type="email" placeholder="Email Address" required class="form-control"
                                   id="email-Candy" name="email">
                        </div>
                        <div class="form-group">
                            <input type="submit" class="btn btn-sm btn-theme" value="Submit">
                        </div>
                    </div>
                </li>
            </ul>
        </form>
    </div>
    <div class="clear"></div>
</div>