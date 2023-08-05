<?php
function lang($phrase){
    static $lang=array(
        'HOME ADMIN'=>'Home',
        'CATEGORYES'=>'Categories',
        'ITEMS'=>'Items',
        'MEMBERS'=>'Members',
        'COMMENTS'=>'Comments'
        
    );
    return $lang[$phrase];
}

?>