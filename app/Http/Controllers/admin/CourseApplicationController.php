<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\CourseApplication;
use Illuminate\Http\Request;

class CourseApplicationController extends Controller
{
    public function index(){
        $apps=CourseApplication::orderBy('created_at','DESC')
        ->with('course','user','creator')
        ->paginate(10);
         return view('admin.enrollments.list',[
            'apps'=>$apps
         ]);
   }

   public function destroy(Request $request){
         $id= $request->id;
         $app=CourseApplication::find($id);

         if($app==null){
            session()->flash('error','Either not enrolled or not found');
            return response()->json([
                'status'=>false
            ]);
         }

         $app->delete(); 
         session()->flash('success','Enrollment Removed Successfully');
            return response()->json([
                'status'=>true
            ]);   
   }
}