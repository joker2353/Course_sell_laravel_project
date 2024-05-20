<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class CourseControllers extends Controller
{
    public function index(){
        $course=Course::orderBy('created_at','DESC')->with('user','applications')->paginate(10);
        return view('admin.courses.list',[
             'courses'=>$course
        ]);
    }

    public function editCourse($id){
      $categories=Category::orderBy('name','ASC')->get();
      $course=Course::findOrFail($id);
     
      return view('admin.courses.edit',[
        'course'=>$course,
        'categories'=>$categories,
        
      ]);
    }

    public function update(Request $request,$id){
         
      $rules=[
         'title'=>'required',
         'category'=>'required',
         'author'=>'required',
         'description'=>'required',
         'seat'=>'required|integer',
         'duration'=>'required',
      ]; 
      $validator=Validator::make($request->all(),$rules); 
   
       if($validator->passes()){
          $course=Course::find($id);
          $course->title=$request->title;
          $course->category_id=$request->category;
          $course->author=$request->author;
          $course->user_id=Auth::user()->id;
          $course->seat=$request->seat;
          $course->price=$request->price;
          $course->duration=$request->duration;
          $course->description=$request->description;
          $course->benefits=$request->benefits;
          $course->prerequisite=$request->prerequisite;
          $course->link=$request->link;
          $course->keywords=$request->keywords;
          $course->experience=$request->experience;
          $course->status=$request->status;
             
          $course->isFeatured = $request->has('isFeatured') ? 0 : 1;
          $course->save();

      session()->flash('success','Course updated successfully.');   

         return response()->json([
            'status'=>true,
            'errors'=>[]
         ]);
      }
      else{
        return response()->json([
            'status'=>false,
            'errors'=>$validator->errors()
        ]);
      }
    }
     public function destroy(Request $request){
               $id=$request->id;
               $course=Course::find($id);
               if($course==null){
                session()->flash('error','Either Course deleted or not found');   

                return response()->json([
                   'status'=>false,
                   
                ]);
               }
               
               $course->delete();
               session()->flash('success','Course deleted successfully.');   

               return response()->json([
                  'status'=>true,
                  
               ]);
     }  

}
