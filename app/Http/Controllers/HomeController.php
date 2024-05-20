<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use App\Models\Job;

class HomeController extends Controller
{
    
    public function homepage(){
        $categories=Category::where('status',1)->orderBy('name','ASC')->take(8)->get();

        $newcategories=Category::where('status',1)->orderBy('name','ASC')->get();

        $featuredCourses=Course::where('status',1)->where('isfeatured',0)->orderBy('created_at','DESC')->take(6)->get();
        $latestCourses=Course::where('status',1)->orderBy('created_at','DESC')->take(6)->get();
        return view('front.home',[
            'categories'=>$categories,
            'featuredCourses'=>$featuredCourses,
            'latestCourses'=>$latestCourses,
            'newcategories'=>$newcategories
        ]);
    }
}
