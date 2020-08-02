<?php

# You may use sample format below.
/*
function XXXX($XX, $YY) {
     return ZZZ;
}
*/

require_once(dirname(__FILE__) . '/../common/DB.php');
require_once(dirname(__FILE__) . '/Lib_com.php');
require_once(dirname(__FILE__) . '/Lib_delete.php');

/**************************************************************************
FUNCTION_NAME :
DISCRIPTION   :
          IN  :
          OUT : (int)
**************************************************************************/
function view_delete(){

    // class name
    $LC_class_form = 'form';

    $LC_class_head      = 'delhead';
    $LC_class_head_flag = 'delhead_flag';

    // [Form] action, method
    $LC_form_action = 'Lib_delete.php';
    $LC_form_method = 'post';

    // [Form] id
    $LC_form_id_parent  = 'del_parent';
    $LC_form_id_child   = 'del_child';
    $LC_form_id_daily   = 'del_daily';
    $LC_form_id_special = 'del_special';
    $LC_form_id_litimp  = 'del_littleimp';

    // Read DB record
    select_all($LC_array_parent, 'p_task');
    select_all($LC_array_child , 'c_task');
    select_all($LC_array_todo_d, 'todo_daily');
    select_all($LC_array_todo_s, 'todo_special');
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

    // ----------[delete parent]----------

    // Common 
    $LC_title = 'Delete parent';
    $LC_id    = $LC_form_id_parent;

    // [Input] name
    $LC_input_name_tag    = 'del_tag';
    $LC_input_name_parent = 'del_parent';

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
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[delete child]----------

    // Common 
    $LC_title = 'Delete child';
    $LC_id    = $LC_form_id_child;

    // [Input] name
    //$LC_input_name_tag    = 'del_tag';
    //$LC_input_name_parent = 'del_parent';
    $LC_input_name_child = 'del_child';

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
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[delete daily]----------

    // Common 
    $LC_title = 'Delete daily';
    $LC_id    = $LC_form_id_daily;

    // [Input] name
    //$LC_input_name_tag    = 'del_tag';
    //$LC_input_name_parent = 'del_parent';
    //$LC_input_name_child  = 'del_child';
    $LC_input_name_todo   = 'del_todo';

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
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[delete special]----------

    // Common 
    $LC_title = 'Delete special';
    $LC_id    = $LC_form_id_special;

    // [Input] name
    //$LC_input_name_tag    = 'del_tag';
    //$LC_input_name_parent = 'upd_parent';
    //$LC_input_name_child  = 'upd_child';
    //$LC_input_name_todo   = 'upd_todo';

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
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[delete little_impression]----------

    // Common 
    $LC_title = 'Delete Little_impression';
    $LC_id    = $LC_form_id_litimp;

    // [Input] name
    //$LC_input_name_tag    = 'del_tag';
    //$LC_input_name_parent = 'del_parent';
    //$LC_input_name_child  = 'del_child';
    $LC_input_name_title  = 'del_title';

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
            <input type="submit" value="Shoot!">
        </form>
    </div>
EOF;
echo $LC_html . "\n";

    // ----------[insert END]----------

    return;
}

?>
