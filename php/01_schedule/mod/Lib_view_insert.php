<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/Lib_com.php');
require_once(dirname(__FILE__) . '/Lib_insert.php');
require_once(dirname(__FILE__) . '/../common/DB.php');

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function view_insert(){

    // class name
    $LC_class_form = 'form';

    $LC_class_inshead      = 'inshead';
    $LC_class_inshead_flag = 'inshead_flag';

    // [Form] action, method
    $LC_form_action = 'Lib_insert.php';
    $LC_form_method = 'post';

    // [Form] id
    $LC_form_id_parent  = 'ins_parent';
    $LC_form_id_child   = 'ins_child';
    $LC_form_id_daily   = 'ins_daily';
    $LC_form_id_special = 'ins_special';
    $LC_form_id_litimp  = 'ins_littleimp';

    // SQL query
    select_all($LC_array_parent, 'p_task');
    select_all($LC_array_child , 'c_task');

    // ----------[head of insert]----------

    $LC_html = <<<EOF
    <div class="$LC_class_inshead">
        <div class="$LC_class_inshead_flag">
            <p>Parent</p>
        </div>
        <div class="$LC_class_inshead_flag">
            <p>Child</p>
        </div>
        <div class="$LC_class_inshead_flag">
            <p>Daily</p>
        </div>
        <div class="$LC_class_inshead_flag">
            <p>Special</p>
        </div>
        <div class="$LC_class_inshead_flag">
            <p>Little_impression</p>
        </div>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[insert parent]----------

    // Common 
    $LC_title = 'Insert parent';
    $LC_id    = $LC_form_id_parent;

    // [Input] name
    $LC_input_name_tag    = 'ins_tag';
    $LC_input_name_parent = 'ins_parent';

    $LC_html = <<<EOF
    <div class="$LC_class_form">
        <p>$LC_title</p>
        <form action="$LC_form_action" method="$LC_form_method" id="$LC_id">
            <input type="hidden" name="$LC_input_name_tag" value="$LC_id">
            <label>Parent:<input type="text" name="$LC_input_name_parent"></label>
            <br>
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[insert child]----------

    // Common 
    $LC_title = 'Insert child';
    $LC_id    = $LC_form_id_child;

    // [Input] name
    //$LC_input_name_tag    = 'ins_tag';
    //$LC_input_name_parent = 'ins_parent';
    $LC_input_name_child = 'ins_child';
    $LC_input_name_start = 'ins_start';
    $LC_input_name_end   = 'ins_end';
    $LC_input_name_goal  = 'ins_goal';

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
            <label>Child:<input type="text" name="$LC_input_name_child"></label>
            <br>
            <label>Start:<input type="date" name="$LC_input_name_start"></label>
            <label>End  :<input type="date" name="$LC_input_name_end"></label>
            <br>
            <label>Goal :<input type="text" name="$LC_input_name_goal"></label>
            <br>
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[insert daily]----------

    // Common 
    $LC_title = 'Insert daily';
    $LC_id    = $LC_form_id_daily;

    // [Input] name
    //$LC_input_name_tag    = 'ins_tag';
    //$LC_input_name_parent = 'ins_parent';
    //$LC_input_name_child  = 'ins_child';
    $LC_input_name_todo   = 'ins_todo';
    $LC_input_name_status = 'ins_status';
    $LC_input_name_pri    = 'ins_pri';
    $LC_input_name_todo_start = 'ins_todo_start';
    $LC_input_name_todo_end   = 'ins_todo_end';

    $LC_input_name_mon_start = 'ins_mon_start';
    $LC_input_name_mon_end   = 'ins_mon_end';
    $LC_input_name_tue_start = 'ins_tue_start';
    $LC_input_name_tue_end   = 'ins_tue_end';
    $LC_input_name_wed_start = 'ins_wed_start';
    $LC_input_name_wed_end   = 'ins_wed_end';
    $LC_input_name_thu_start = 'ins_thu_start';
    $LC_input_name_thu_end   = 'ins_thu_end';
    $LC_input_name_fri_start = 'ins_fri_start';
    $LC_input_name_fri_end   = 'ins_fri_end';
    $LC_input_name_sat_start = 'ins_sat_start';
    $LC_input_name_sat_end   = 'ins_sat_end';
    $LC_input_name_sun_start = 'ins_sun_start';
    $LC_input_name_sun_end   = 'ins_sun_end';

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
            <label>Todo :<input type="text" name="$LC_input_name_todo"></label>
            <br>
            <label>Status:
                <select name="$LC_input_name_status">
                    <option value="inqueue">Inqueue</option>
                    <option value="working">Working</option>
                    <option value="done">Done</option>
                </select>
            </label>
            <br>
            <label>Priority:
                <select name="$LC_input_name_pri">
                    <option value="1">Low</option>
                    <option value="2">Mid</option>
                    <option value="3">High</option>
                </select>
            </label>
            <br>
            <label>Todo_Start:<input type="date" name="$LC_input_name_todo_start"></label>
            <label>Todo_End  :<input type="date" name="$LC_input_name_todo_end"></label>
            <br>
            <label>Mon_Start:<input type="time" name="$LC_input_name_mon_start"></label>
            <label>Mon_End  :<input type="time" name="$LC_input_name_mon_end"></label>
            <br>
            <label>Tue_Start:<input type="time" name="$LC_input_name_tue_start"></label>
            <label>Tue_End  :<input type="time" name="$LC_input_name_tue_end"></label>
            <br>
            <label>Wed_Start:<input type="time" name="$LC_input_name_wed_start"></label>
            <label>Wed_End  :<input type="time" name="$LC_input_name_wed_end"></label>
            <br>
            <label>Thu_Start:<input type="time" name="$LC_input_name_thu_start"></label>
            <label>Thu_End  :<input type="time" name="$LC_input_name_thu_end"></label>
            <br>
            <label>Fri_Start:<input type="time" name="$LC_input_name_fri_start"></label>
            <label>Fri_End  :<input type="time" name="$LC_input_name_fri_end"></label>
            <br>
            <label>Sat_Start:<input type="time" name="$LC_input_name_sat_start"></label>
            <label>Sat_End  :<input type="time" name="$LC_input_name_sat_end"></label>
            <br>
            <label>Sun_Start:<input type="time" name="$LC_input_name_sun_start"></label>
            <label>Sun_End  :<input type="time" name="$LC_input_name_sun_end"></label>
            <br>
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[insert special]----------

    // Common 
    $LC_title = 'Insert special';
    $LC_id    = $LC_form_id_special;

    // [Input] name
    //$LC_input_name_tag    = 'ins_tag';
    //$LC_input_name_parent = 'ins_parent';
    //$LC_input_name_child  = 'ins_child';
    //$LC_input_name_todo   = 'ins_todo';
    //$LC_input_name_status = 'ins_status';
    //$LC_input_name_pri    = 'ins_pri';
    $LC_input_name_todo_start_ts = 'ins_todo_start_ts';
    $LC_input_name_todo_end_ts   = 'ins_todo_end_ts';

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
            <label>Todo :<input type="text" name="$LC_input_name_todo"></label>
            <br>
            <label>Status:
                <select name="$LC_input_name_status">
                    <option value="inqueue">Inqueue</option>
                    <option value="working">Working</option>
                    <option value="done">Done</option>
                </select>
            </label>
            <br>
            <label>Priority:
                <select name="$LC_input_name_pri">
                    <option value="1">Low</option>
                    <option value="2">Mid</option>
                    <option value="3">High</option>
                </select>
            </label>
            <br>
            <label>Todo_Start:<input type="datetime-local" name="$LC_input_name_todo_start_ts"></label>
            <label>Todo_End  :<input type="datetime-local" name="$LC_input_name_todo_end_ts"></label>
            <br>
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[insert little_impression]----------

    // Common 
    $LC_title = 'Insert Little_impression';
    $LC_id    = $LC_form_id_litimp;

    // [Input] name
    //$LC_input_name_tag    = 'ins_tag';
    //$LC_input_name_parent = 'ins_parent';
    //$LC_input_name_child  = 'ins_child';
    $LC_input_name_title  = 'ins_title';
    $LC_input_name_litimp = 'ins_litimp';

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
            <label>Title:<input type="text" name="$LC_input_name_title"></label>
            <br>
            <label>Little_impression:<input type="text" name="$LC_input_name_litimp"></label>
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
