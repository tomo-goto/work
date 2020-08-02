<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/
require_once(dirname(__FILE__) . '/Lib_com.php');
require_once(dirname(__FILE__) . '/Lib_update.php');
require_once(dirname(__FILE__) . '/../common/DB.php');

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function view_update(){

    // class name
    $LC_class_form = 'form';

    $LC_class_head      = 'updhead';
    $LC_class_head_flag = 'updhead_flag';

    // [Form] action, method
    $LC_form_action = 'Lib_update.php';
    $LC_form_method = 'post';

    // [Form] id
    $LC_form_id_parent  = 'upd_parent';
    $LC_form_id_child   = 'upd_child';
    $LC_form_id_daily   = 'upd_daily';
    $LC_form_id_special = 'upd_special';
    $LC_form_id_litimp  = 'upd_littleimp';

    // Read DB record
    select_all($LC_array_parent,'p_task');
    select_all($LC_array_child ,'c_task');
    select_all($LC_array_todo_d,'todo_daily');
    select_all($LC_array_todo_s,'todo_special');
    //select_all($LC_array_litimp, 'little_impression');

    // ----------[head of update]----------

    $LC_html = <<<EOF
    <div class="$LC_class_head">
        <div class="$LC_class_head_flag">
            <p>Parent</p>
        </div>
        <div class="$LC_class_head_flag">
            <p>Child</p>
        </div>
        <div class="$LC_class_head_flag">
            <p>Daily</p>
        </div>
        <div class="$LC_class_head_flag">
            <p>Special</p>
        </div>
        <div class="$LC_class_head_flag">
            <p>Little_impression</p>
        </div>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[update parent]----------

    // Common 
    $LC_title = 'Update parent';
    $LC_id    = $LC_form_id_parent;

    // [Input] name
    $LC_input_name_tag        = 'upd_tag';
    $LC_input_name_parent     = 'upd_parent';
    $LC_input_name_new_parent = 'upd_new_parent';

    $LC_html = <<<EOF
    <div class="$LC_class_form">
        <p>$LC_title</p>
        <form action="$LC_form_action" method="$LC_form_method" id="$LC_id">
            <input type="hidden" name="$LC_input_name_tag" value="$LC_id">
            <label>Parent:
EOF;
echo $LC_html . "\n";

    // Parent select
    view_select($LC_array_parent, $LC_input_name_parent, 'big_task', NULL);

    $LC_html = <<<EOF
            </label>
            <br>
            <label>(New)Parent:<input type="text" name="$LC_input_name_new_parent"></label>
            <br>
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[update child]----------

    // Common 
    $LC_title = 'Update child';
    $LC_id    = $LC_form_id_child;

    // [Input] name
    //$LC_input_name_tag    = 'upd_tag';
    //$LC_input_name_parent = 'upd_parent';
    $LC_input_name_child     = 'upd_child';
    $LC_input_name_new_child = 'upd_new_child';
    $LC_input_name_new_start = 'upd_new_start';
    $LC_input_name_new_end   = 'upd_new_end';
    $LC_input_name_new_goal  = 'upd_new_goal';
    $LC_input_name_new_comp  = 'upd_new_comp';

    $LC_html = <<<EOF
    <div class="$LC_class_form">
        <p>$LC_title</p>
        <form action="$LC_form_action" method="$LC_form_method" id="$LC_id">
            <input type="hidden" name="$LC_input_name_tag" value="$LC_id">
            <label>Parent:
EOF;
echo $LC_html . "\n";

    // Parent select
    view_select($LC_array_parent, $LC_input_name_parent, 'big_task', NULL);

    $LC_html = <<<EOF
            </label>
            <label>Child:
EOF;
echo $LC_html . "\n";

    // Child select
    view_select($LC_array_child, $LC_input_name_child, 'little_task', 'big_task');

    $LC_html = <<<EOF
            </label>
            <br>
            <label>(New)Child:<input type="text" name="$LC_input_name_new_child"></label>
            <br>
            <label>(New)Start:<input type="date" name="$LC_input_name_new_start"></label>
            <label>(New)End  :<input type="date" name="$LC_input_name_new_end"></label>
            <br>
            <label>(New)Goal :<input type="text" name="$LC_input_name_new_goal"></label>
            <br>
            <label>(New)Completion Impression:<input type="text" name="$LC_input_name_new_comp"></label>
            <br>
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[update daily]----------

    // Common 
    $LC_title = 'Update daily';
    $LC_id    = $LC_form_id_daily;

    // [Input] name
    //$LC_input_name_tag    = 'upd_tag';
    //$LC_input_name_parent = 'upd_parent';
    //$LC_input_name_child  = 'upd_child';
    $LC_input_name_todo       = 'upd_todo';
    $LC_input_name_new_todo   = 'upd_new_todo';
    $LC_input_name_new_obs    = 'upd_new_obs';
    $LC_input_name_new_status = 'upd_new_status';
    $LC_input_name_new_pri    = 'upd_new_pri';
    $LC_input_name_new_todo_start = 'upd_new_todo_start';
    $LC_input_name_new_todo_end   = 'upd_new_todo_end';

    $LC_input_name_new_mon_start = 'upd_new_mon_start';
    $LC_input_name_new_mon_end   = 'upd_new_mon_end';
    $LC_input_name_new_tue_start = 'upd_new_tue_start';
    $LC_input_name_new_tue_end   = 'upd_new_tue_end';
    $LC_input_name_new_wed_start = 'upd_new_wed_start';
    $LC_input_name_new_wed_end   = 'upd_new_wed_end';
    $LC_input_name_new_thu_start = 'upd_new_thu_start';
    $LC_input_name_new_thu_end   = 'upd_new_thu_end';
    $LC_input_name_new_fri_start = 'upd_new_fri_start';
    $LC_input_name_new_fri_end   = 'upd_new_fri_end';
    $LC_input_name_new_sat_start = 'upd_new_sat_start';
    $LC_input_name_new_sat_end   = 'upd_new_sat_end';
    $LC_input_name_new_sun_start = 'upd_new_sun_start';
    $LC_input_name_new_sun_end   = 'upd_new_sun_end';

    $LC_html = <<<EOF
    <div class="$LC_class_form">
        <p>$LC_title</p>
        <form action="$LC_form_action" method="$LC_form_method" id="$LC_id">
            <input type="hidden" name="$LC_input_name_tag" value="$LC_id">
            <label>Parent:
EOF;
echo $LC_html . "\n";

    // Parent select
    view_select($LC_array_parent, $LC_input_name_parent, 'big_task', NULL);

    $LC_html = <<<EOF
            </label>
            <br>
            <label>Child:
EOF;
echo $LC_html . "\n";

    // Child select
    view_select($LC_array_child, $LC_input_name_child, 'little_task', 'big_task');

    $LC_html = <<<EOF
            </label>
            <br>
            <label>Daily:
EOF;
echo $LC_html . "\n";

    // Daily select
    view_select($LC_array_todo_d, $LC_input_name_todo, 'todo_name', 'little_task');

    $LC_html = <<<EOF
            </label>
            <br>
            <label>(New)Todo :<input type="text" name="$LC_input_name_new_todo"></label>
            <br>
            <label>(New)Obstacle :<input type="text" name="$LC_input_name_new_obs"></label>
            <br>
            <label>(New)Status:
                <select name="$LC_input_name_new_status">
                    <option value="inqueue">Inqueue</option>
                    <option value="working">Working</option>
                    <option value="done">Done</option>
                </select>
            </label>
            <br>
            <label>(New)Priority:
                <select name="$LC_input_name_new_pri">
                    <option value="1">Low</option>
                    <option value="2">Mid</option>
                    <option value="3">High</option>
                </select>
            </label>
            <br>
            <label>(New)Todo_Start:<input type="date" name="$LC_input_name_new_todo_start"></label>
            <label>(New)Todo_End  :<input type="date" name="$LC_input_name_new_todo_end"></label>
            <br>
            <label>(New)Mon_Start:<input type="time" name="$LC_input_name_new_mon_start"></label>
            <label>(New)Mon_End  :<input type="time" name="$LC_input_name_new_mon_end"></label>
            <br>
            <label>(New)Tue_Start:<input type="time" name="$LC_input_name_new_tue_start"></label>
            <label>(New)Tue_End  :<input type="time" name="$LC_input_name_new_tue_end"></label>
            <br>
            <label>(New)Wed_Start:<input type="time" name="$LC_input_name_new_wed_start"></label>
            <label>(New)Wed_End  :<input type="time" name="$LC_input_name_new_wed_end"></label>
            <br>
            <label>(New)Thu_Start:<input type="time" name="$LC_input_name_new_thu_start"></label>
            <label>(New)Thu_End  :<input type="time" name="$LC_input_name_new_thu_end"></label>
            <br>
            <label>(New)Fri_Start:<input type="time" name="$LC_input_name_new_fri_start"></label>
            <label>(New)Fri_End  :<input type="time" name="$LC_input_name_new_fri_end"></label>
            <br>
            <label>(New)Sat_Start:<input type="time" name="$LC_input_name_new_sat_start"></label>
            <label>(New)Sat_End  :<input type="time" name="$LC_input_name_new_sat_end"></label>
            <br>
            <label>(New)Sun_Start:<input type="time" name="$LC_input_name_new_sun_start"></label>
            <label>(New)Sun_End  :<input type="time" name="$LC_input_name_new_sun_end"></label>
            <br>
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[update special]----------

    // Common 
    $LC_title = 'Update special';
    $LC_id    = $LC_form_id_special;

    // [Input] name
    //$LC_input_name_tag    = 'upd_tag';
    //$LC_input_name_parent = 'upd_parent';
    //$LC_input_name_child  = 'upd_child';
    //$LC_input_name_todo   = 'upd_todo';
    //$LC_input_name_new_todo   = 'upd_new_todo';
    //$LC_input_name_new_obs    = 'upd_new_obs';
    //$LC_input_name_new_status = 'upd_new_status';
    //$LC_input_name_new_pri    = 'upd_new_pri';
    $LC_input_name_new_todo_start_ts = 'upd_new_todo_start_ts';
    $LC_input_name_new_todo_end_ts   = 'upd_new_todo_end_ts';

    $LC_html = <<<EOF
    <div class="$LC_class_form">
        <p>$LC_title</p>
        <form action="$LC_form_action" method="$LC_form_method" id="$LC_id">
            <input type="hidden" name="$LC_input_name_tag" value="$LC_id">
            <label>Parent:
EOF;
echo $LC_html . "\n";

    // Parent select
    view_select($LC_array_parent, $LC_input_name_parent, 'big_task', NULL);

    $LC_html = <<<EOF
            </label>
            <br>
            <label>Child:
EOF;
echo $LC_html . "\n";

    // Child select
    view_select($LC_array_child, $LC_input_name_child, 'little_task', 'big_task');

    $LC_html = <<<EOF
            </label>
            <br>
            <label>Daily:
EOF;
echo $LC_html . "\n";

    // Special select
    view_select($LC_array_todo_s, $LC_input_name_todo, 'todo_name', 'little_task');

    $LC_html = <<<EOF
            </label>
            <br>
            <label>(New)Todo :<input type="text" name="$LC_input_name_new_todo"></label>
            <br>
            <label>(New)Obstacle :<input type="text" name="$LC_input_name_new_obs"></label>
            <br>
            <label>(New)Status:
                <select name="$LC_input_name_new_status">
                    <option value="inqueue">Inqueue</option>
                    <option value="working">Working</option>
                    <option value="done">Done</option>
                </select>
            </label>
            <br>
            <label>(New)Priority:
                <select name="$LC_input_name_new_pri">
                    <option value="1">Low</option>
                    <option value="2">Mid</option>
                    <option value="3">High</option>
                </select>
            </label>
            <br>
            <label>(New)Todo_Start:<input type="datetime-local" name="$LC_input_name_new_todo_start_ts"></label>
            <label>(New)Todo_End  :<input type="datetime-local" name="$LC_input_name_new_todo_end_ts"></label>
            <br>
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[update little_impression]----------

    // Common 
    $LC_title = 'Update Little_impression';
    $LC_id    = $LC_form_id_litimp;

    // [Input] name
    //$LC_input_name_tag    = 'upd_tag';
    //$LC_input_name_parent = 'upd_parent';
    //$LC_input_name_child  = 'upd_child';
    $LC_input_name_title      = 'upd_title';
    $LC_input_name_new_title  = 'upd_new_title';
    $LC_input_name_new_litimp = 'upd_new_litimp';

    $LC_html = <<<EOF
    <div class="$LC_class_form">
        <p>$LC_title</p>
        <form action="$LC_form_action" method="$LC_form_method" id="$LC_id">
            <input type="hidden" name="$LC_input_name_tag" value="$LC_id">
            <label>Parent:
EOF;
echo $LC_html . "\n";

    // Parent select
    view_select($LC_array_parent, $LC_input_name_parent, 'big_task', NULL);

    $LC_html = <<<EOF
            </label>
            <br>
            <label>Child:
EOF;
echo $LC_html . "\n";

    // Child select
    view_select($LC_array_child, $LC_input_name_child, 'little_task', 'big_task');

    $LC_html = <<<EOF
            </label>
            <br>
            <label>Little_impression title:
EOF;
echo $LC_html . "\n";

    // Little_impression title select
    view_select($LC_array_litimp, $LC_input_name_title, 'little_impression_name', 'little_task');

    $LC_html = <<<EOF
            </label>
            <br>
            <label>(New)Title:<input type="text" name="$LC_input_name_new_title"></label>
            <br>
            <label>(New)Little_impression:<input type="text" name="$LC_input_name_new_litimp"></label>
            <br>
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[insert END]----------

    return;
}

?>
