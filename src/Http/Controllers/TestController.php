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
//    public function book()
//    {
//        $book = (object)[];
//        $book->name = "I too had a dream";
//        $book->author = "Kurien Varghese";
//        $book->published = "Jan 17, 2012";
//        $book->isbn = '8174364072';
//        $book->description = "Architect of 'Operation Flood', the largest dairy development programme in the world, Dr Verghese Kurien has enabled India to become the largest milk producer in the world. A man with a rare vision, Dr Kurien has devoted a lifetime to realizing his dream - empowering the farmers of India. He has engineered the milk cooperative movement in India. It was a sheer quirk of fate that landed him in Anand where a small group of farmers were forming a cooperative, Kaira District Cooperative Milk Producers'Union Limited (better known as Amul), to sell their milk. Intrigued by the integrity and commitment of their leader, Tribhuvandas Patel, Dr Kurien joined them. Since then there has been no looking back. The 'Anand pattern of cooperatives'were so successful that, at the request of the Government of India, he set up the National Dairy Development Board to replicate it across India. He also established the Gujarat Cooperative Milk Marketing Federation to market its products. In these memoirs, Dr Verghese Kurien, popularly known as the 'father of the white revolution', recounts, with customary candour, the story of his life and how he shaped the dairy industry. Profoundly inspiring, these memoirs help up comprehend the magnitude of his contributions and his multifaceted personality. ";
//
//        Audit::makeVersion($book);
//    }

    public function create()
    {
//        $user = User::find(2);//->attributesToArray();
//        Audit::makeVersion($user);

         $blog = Blog::find(1);
         Audit::makeVersion($blog);

         $blog = Blog::find(2);
         Audit::makeVersion($blog);
    }
    
    public function pre()
    {
        $book = (object)[];
        $book->name = "I too had a dream";
        $book->author = "Kurien Varghese";
        $book->published = "Jan 17, 2012";
        $book->isbn = '8174364072';
        $book->description = "Architect of 'Operation Flood', the largest dairy development programme in the world, Dr Verghese Kurien has enabled India to become the largest milk producer in the world. A man with a rare vision, Dr Kurien has devoted a lifetime to realizing his dream - empowering the farmers of India. He has engineered the milk cooperative movement in India. It was a sheer quirk of fate that landed him in Anand where a small group of farmers were forming a cooperative, Kaira District Cooperative Milk Producers'Union Limited (better known as Amul), to sell their milk. Intrigued by the integrity and commitment of their leader, Tribhuvandas Patel, Dr Kurien joined them. Since then there has been no looking back. The 'Anand pattern of cooperatives'were so successful that, at the request of the Government of India, he set up the National Dairy Development Board to replicate it across India. He also established the Gujarat Cooperative Milk Marketing Federation to market its products. In these memoirs, Dr Verghese Kurien, popularly known as the 'father of the white revolution', recounts, with customary candour, the story of his life and how he shaped the dairy industry. Profoundly inspiring, these memoirs help up comprehend the magnitude of his contributions and his multifaceted personality. ";

//        Audit::preVersion($book);

//        Audit::rollBackToVersion('ver55a776d72a990');
        $user = User::find(1);//->attributesToArray();
       // dd(User::find(1)->attributesToArray());
        // $rs = Audit::getHistory($user);
        // $rs = Audit::diff($user);
        $rs = Audit::currentVersion($user);
        dd($rs);
    }

    public function demo()
    {
//        $user = User::find(1);
//        $data = Audit::diff($user);
        $blog = Blog::find(2);
        $data = Audit::diff($blog);
//        echo "<pre>";
//        print_r($data);
//        dd($data);
        return view('audit::diff')->with('data', $data);
    }

    public function diff($id, $type)
    {
//        $user = User::find(1);
//        $data = Audit::diff($user);
//        $blog = Blog::find($id);
//        $data = Audit::diff($blog);
//        echo "<pre>";
//        print_r($data);
//        dd($data);

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