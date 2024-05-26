<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseApplication;
use App\Models\JobType;
use App\Models\Job;
use App\Models\SavedCourse;
use Illuminate\Support\Facades\Auth;


class CourseController extends Controller
{
    public function index(Request $request){
     $categories=Category::where('status',1)->get();
     
    $courses=Course::where('status',1);

        //search using keyword    
       if(!empty($request->keyword)){
        $courses=$courses->where(function($query) use ($request){
            $query->orWhere('title','like','%'.$request->keyword.'%');
            $query->orWhere('keywords','like','%'.$request->keyword.'%');
        });
      
      }
       if(!empty($request->category)){
        $courses=$courses->where('category_id',$request->category);
       }

    $courses=$courses->orderBy('created_at','DESC')->paginate(9);

     return view('front.jobs',[
            'categories'=>$categories,
            
            'courses'=>$courses,
        ]);
    }




    public function detail($id){

        $course=Course::where([
            'id'=>$id,
            'status'=>1
        ])->first();
        //dd($job);

      if($course==null){
        abort(404);
      }

      $count=0;
      if(Auth::user()){
          $count=SavedCourse::where([
               'user_id'=>Auth::user()->id,
               'course_id'=>$id
          ]);
      }

      $apps=CourseApplication::where('course_id',$id)->with('user')->get();
    

          return view('front.jobDetail',[
            'course'=>$course,
            'count'=>$count,
            'apps'=>$apps
          ]);
    }



    public function apply(Request $request) {
      $id = $request->id;
  
      $course = Course::where('id', $id)->first();
  
      if ($course == null) {
          session()->flash('error', 'Course does not exist');
          return response()->json([
              'status' => false,
              'message' => 'Course does not exist'
          ]);
      }
  
      $t_id = $course->user_id;
  
      if ($t_id == Auth::user()->id) {
          session()->flash('error', 'You cannot buy your own course');
          return response()->json([
              'status' => false,
              'message' => 'You cannot buy your own course'
          ]);
      }
  
      // cannot apply for a job twice
      $jappCount = CourseApplication::where([
          'user_id' => Auth::user()->id,
          'course_id' => $id
      ])->count();
  
      if ($jappCount > 0) {
          session()->flash('error', 'You have already applied');
          return response()->json([
              'status' => false,
              'message' => 'You have already applied'
          ]);
      }
  
      $application = new CourseApplication();
      $application->course_id = $id;
      $application->user_id = Auth::user()->id;
      $application->t_id = $t_id;
      $application->applied_date = now();
      $application->save();
  
      session()->flash('success', 'Enrolled successfully');
  
      // Return JSON response indicating success and the route to redirect
      return response()->json([
          'status' => true,
          'message' => 'Enrolled successfully',
          'redirect_url' => route('checkout', [
            'price' => $course->price, 
            'title' => $course->title]
            )
      ]);
  }
  
  
    

     public function saveCourse(Request $request){
        $id= $request->id;
        $course=Course::find($id);
        if($course==null){
          session()->flash('error','Course not found');
          return response()->json([
            'status'=>false,
            
        ]);
        }
         
        $count=SavedCourse::where([
          'user_id'=>Auth::user()->id,
            'course_id'=>$id
        ])->count();

      if($count>0){
        session()->flash('error','You have already saved this course.');
        return response()->json([
          'status'=>false,
          
      ]);
      }

      $savedCourse = new SavedCourse();
      $savedCourse->user_id=Auth::user()->id;
      $savedCourse->course_id=$id;
      $savedCourse->save();

      session()->flash('success','Course saved successfully');
      return response()->json([
        'status'=>true,
        
    ]);

     }

     public function media($id){
         $course=Course::find($id);
         $capp=CourseApplication::where([
             'course_id'=>$id
         ])->first();
         if($course==null){
            return redirect()->back();
         }

         return view('front.media',[
          'course'=>$course,
          'capp'=>$capp
        ]);
  }
}


