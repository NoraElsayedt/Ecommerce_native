<?php
function lang($phrase){
    static $lang=array(
        'MESSAGE'=>'اهلا',
        'ADMIN'=>'مدير'
    );
    return $lang[$phrase];
}

?>