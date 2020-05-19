<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * 页面控制器
 * Class PageController
 * @package App\Http\Controllers
 */
class PageController extends Controller
{
    /**
     * 主页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(  ) {
        return view('pages.index');
    }

}
