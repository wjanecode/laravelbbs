<?php
/**
 *
 * @author woojuan
 * @email woojuan163@163.com
 * @copyright GPL
 * @version
 */

/**
 * 获取当前路由名并转成 - 分隔的类以便css样式使用
 * @return mixed
 */
function route_class(){
    return str_replace('.','-',Route::currentRouteName());
}
function make_excerpt(String $str,$length=200){
    //取前面200个,空格换行等换成空格
    $excerpt = trim(preg_replace('/\r\n|\r|\n+/', ' ', strip_tags($str)));
    return Str::limit($excerpt, $length);
}

