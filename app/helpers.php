<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */

function route_class(){
    return str_replace('.','-',Route::currentRouteName());
}
