<?php

/**
 * Created by PhpStorm.
 * User: pruthvi
 * Date: 15/7/15
 * Time: 5:20 PM
 */

namespace Focalworks\Audit\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use App\Blog;
use Focalworks\Audit\Audit;

class TestController extends Controller
{

    public function create()
    {
         $blog = Blog::find(1);
         Audit::makeVersion($blog);

         $blog = Blog::find(2);
         Audit::makeVersion($blog);
    }
    
    public function pre()
    {
        $user = User::find(1);//->attributesToArray();
       // dd(User::find(1)->attributesToArray());
        // $rs = Audit::getHistory($user);
        // $rs = Audit::diff($user);
        $rs = Audit::currentVersion($user);
        dd($rs);
    }

    public function demo()
    {
        $blog = Blog::find(1);
        $data = Audit::diff($blog);
        return view('audit::diff')->with('data', $data);
    }

    public function diff($id, $type)
    {
        $data = Audit::getDiff($id, $type);
        return view('audit::diff')->with('data', $data);
    }

    public function history($display = null)
    {
        if($display == 'all') {
            $data = Audit::getHistory();
        } else {
            $blog = Blog::find(1);
            $data = Audit::getContentHistory($blog);
        }
       
        return view('audit::history')->with('historyData', $data);
    }

}