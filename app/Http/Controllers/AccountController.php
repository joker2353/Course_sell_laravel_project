<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Mail\ResetPasswordEmail;
use App\Models\Category;
use App\Models\CourseApplication;
use Illuminate\Support\Facades\Mail;
use App\Models\Course;
use App\Models\SavedCourse;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Model;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class AccountController extends Controller
{
    public function register(){
        return view('front.account.register');
    }
    public function registerProcess(Request $request){
          $validator= Validator::make($request->all(),[
             'name'=>'required',
             'email'=>'required|email|unique:users,email',
             'password'=>'required|min:6',
             'confirm_password'=>'required|same:password',
             
          ]) ;
          if($validator->passes()){

           $user=new User();
           $user->name=$request->name;
           $user->email=$request->email;
           $user->designation='';
           $user->mobile='';
           $user->password=Hash::make($request->password);
           $user->save();
               
          session()->flash('success','You have registered successfully.');
            return response()->json([
                'status'=>true,
                'errors'=>[]
            ]);

          }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
          }
    }
    public function login(){
        return view('front.account.login');
    }

    public function auth(Request $request){
        $validator =Validator::make($request->all(),[
            'email'=>'required|email',
            'password'=>'required',
        ]);
        if($validator->passes()){
            if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
              return redirect()->route('account.profile');
            }
            else{
                return redirect()->route('account.login')->with('error','Either email or password is incorrect');  
            }
        }else{
            return redirect()->route('account.login')
            ->withErrors($validator)
            ->withInput($request->only('email'));
        }
    }
    public function profile(){
        $id=Auth::user()->id;
        $user=User::find($id);

        return view('front.account.profile',[
            'user'=>$user
        ]);
    }
    public function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function updateProfile(Request $request){
       $id=Auth::user()->id;
       $validator=Validator::make($request->all(),[
        'name'=>'required',
        'email'=>'required|email|unique:users,email,'.$id.',id',
       ]); 
       if($validator->passes()){
        $user=User::find($id);
        $user->name=$request->name;
        $user->email=$request->email;
        $user->mobile=$request->mobile;
        $user->designation=$request->designation;
        $user->save();
          
        session()->flash('success','Updated Successfully');

        return response()->json([
            'status'=>false,
            'errors'=>$validator->errors()
        ]);
       } else{
        return response()->json([
            'status'=>false,
            'errors'=>$validator->errors()
        ]);
       }
    }
    public function updateProPic( Request $request){
         //dd($request->all());

         $id=Auth::user()->id;
         $validator=Validator::make($request->all(),[
            'image'=>'required|image'
         ]);
         if($validator->passes()){
             
             $image=$request->file('image');
             $ext=$image->getClientOriginalExtension();
             $imageName=$id.'-'.time().'-'.$ext;
             $image->move(public_path('/profile_pic/'),$imageName);


             //create a thumbnail
             $sourcePath=public_path('/profile_pic/'.$imageName);
             $manager = new ImageManager(Driver::class);
$image = $manager->read($sourcePath); // 800 x 600

// crop down to fixed width
$image->cover(200,200);
$image->toPng()->save(public_path('/profile_pic/thumb/'.$imageName));
             
//delete old profile pic
File:: delete(public_path('/profile_pic/'.Auth::user()->image));
File:: delete(public_path('/profile_pic/thumb/'.Auth::user()->image));

            User::where('id',$id)->update(['image'=>$imageName]);
            //Auth::user()->refresh();
      session()->flash('success','Profile picture updated successfully.');
            return response()->json([
                'status'=>true,
                'errors'=>[]
            ]);

         }else{
            return response()->json([
                'status'=>false,
                'errors'=>$validator->errors()
            ]);
         }
    }
   
    //

         
    public function createCourse(){
        
        $categories=Category::orderBy('name','ASC')->where('status',1)->get();
        

        return view('front.account.course.create',[
            
            'categories'=>$categories,
            
        ]);
    }

    public function saveCourse(Request $request){
    
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
             $course=new Course();
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
             $course->status = 1; 
             $course->isFeatured = 0; 
             $course->save();
            

          session()->flash('success','Course created successfully.');   

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





//

    
    public function myCourses(){ 
        $courses=Course::where('user_id',Auth::user()->id)->orderBy('created_at','DESC')->paginate(10);

        return view('front.account.course.my-courses',[
            'courses'=>$courses
        ]);
    
    }


   



    public function editCourse($id){
        $categories=Category::orderBy('name','ASC')->where('status',1)->get();
        
           
          $course=Course::where([
            'id'=>$id,
            'user_id'=>Auth::user()->id
          ])->first();
          if($course==null){
            abort(404);
          }

        return view('front.account.course.edit',[

            'categories'=>$categories,
            'course'=>$course
        ]);
        
    }

    


    public function updateCourse(Request $request,$id){
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
             $course->status = 1; 
             $course->isFeatured = 0; 
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



   
    
    
    public function deleteCourse(Request $request){
        $course=Course::where([
            'user_id'=>Auth::user()->id,
            'id'=>$request->courseId
        ])->first();

        if($course==null){
            session()->flash('error','Either job deleted or not found');
            return response()->json([
                'status'=>true
            ]);
           
        }
        Course::where('id',$request->courseId)->delete();
        session()->flash('success','Course deleted successfully');
        return response()->json([
            'status'=>true
        ]);
    }


    
    


    public function enrollment(){
        $enroll=CourseApplication::where('user_id',Auth::user()->id)
        ->with(['course','course.applications'])
        ->orderBy('created_at','DESC')
        ->paginate(10);
        //dd($jobapps);


        return view('front.account.course.enrollments',[
            'enrolls'=>$enroll
        ]);
    }

    

    public function removeApp(Request $request){
        $japp=CourseApplication::where([
            'user_id'=>Auth::user()->id,
            'id'=>$request->id
        ])->first();

        if($japp==null){
            session()->flash('success','Application not found');
        return response()->json([
            'status'=>false
        ]);
        }
        CourseApplication::where('id',$request->id)->delete();

        session()->flash('success','Application removed successfully');
        return response()->json([
            'status'=>true
        ]);
    }


    public function removeEnroll(Request $request){
        $japp=CourseApplication::where([
            'user_id'=>Auth::user()->id,
            'id'=>$request->id
        ])->first();

        if($japp==null){
            session()->flash('success','Not Enrolled');
        return response()->json([
            'status'=>false
        ]);
        }
        CourseApplication::where('id',$request->id)->delete();

        session()->flash('success','Removed enrollment');
        return response()->json([
            'status'=>true
        ]);
    }





    public function savedCourse(){

        //$jobapps=CourseApplication::where(
            // 'user_id',Auth::user()->id)
            // ->with(['job','job.jobType','job.applications'])
            // ->paginate(10);
        //dd($jobapps);
        $savedCourses= SavedCourse::where([
            'user_id'=>Auth::user()->id
        ])->with(['course','course.applications'])
        ->orderBy('created_at','DESC')
        ->paginate(10);
          
        return view('front.account.course.savedCourses',[
            'savedCourses'=>$savedCourses
        ]);


        
    }

    public function removesavedApp(Request $request){
        $sapp=SavedCourse::where([
            'user_id'=>Auth::user()->id,
            'id'=>$request->id
        ])->first();

        if($sapp==null){
            session()->flash('error','Application not found');
        return response()->json([
            'status'=>false
        ]);
        }
        SavedCourse::where('id',$request->id)->delete();

        session()->flash('success','Application removed successfully');
        return response()->json([
            'status'=>true
        ]);
    }

    public function updatePass(Request $request){
       $validator=Validator::make($request->all(),[
        'old_password'=>'required',
        'new_password'=>'required|min:6',
        'confirm_password'=>'required|same:new_password'

       ]);

       if($validator->fails()){
        
        return response()->json([
            'status'=>false,
            'errors'=>$validator->errors()
        ]);
      }

          if(Hash::check($request->old_password,Auth::user()->password)==false){
            session()->flash('error','Your old password is incorrect');
        return response()->json([
            'status'=>true
        ]);
    }

         $user=User::find(Auth::user()->id);
         $user->password=Hash::make($request->new_password);
         $user->save();

         session()->flash('success','Password updated successfully');
        return response()->json([
            'status'=>true
        ]);

   }

   public function pubReq(){
    $id=Auth::user()->id;
    // $user=User::find($id);
    // $user->changeRole=1;
    // $user->save();

   User::where('id', $id) // Add conditions as needed
    ->update(['changeRole' => 1]);
       
    session()->flash('success','Request Sent successfully');
    return redirect()->route('account.profile')->with('success', 'Request Sent successfully');
    
   }

   public function forgotPassword(){
    return view('front.account.forgot-password');
   }

   public function processForgotPassword(Request $request){
    $validator=Validator::make($request->all(),[
        'email'=>'required|email| exists:users,email'
    ]);
    if($validator->fails()){
        return redirect()->route('account.forgotPassword')->withInput()->withErrors($validator);
    }
    $token=Str::random(50);
    \DB::table('password_reset_tokens')->where('email',$request->email)->delete();
     \DB::table('password_reset_tokens')->insert([
        'email'=>$request->email,
        'token'=>$token,
        'created_at'=>now()
     ]);
    //send mail
    $user =User::where('email',$request->email)->first();
    $mailData=[
        'token'=>$token,
        'user'=>$user,
        'subject'=>'You have requested to change your password'
    ];

    Mail::to($request->email)->send(new ResetPasswordEmail($mailData));
     
    return redirect()->route('account.forgotPassword')->with('success','Reset password email has been sent to your inbox.');
   }

   public function resetPassword($tokenString){
     $token = \DB::table('password_reset_tokens')->where('token',$tokenString)->first();
     if($token==null){
        return redirect()->route('account.forgotPassword')->with('error','Invalid token');
   }
   return view('front.account.reset-password',[
    'tokenString'=>$tokenString
   ]);
       
}

public function processResetPassword(Request $request){

    $token = \DB::table('password_reset_tokens')->where('token',$request->token)->first();
    if($token==null){
       return redirect()->route('account.forgotPassword')->with('error','Invalid token');
  }


 
    $validator=Validator::make($request->all(),[
        'new_password'=>'required|min:6',
        'confirm_password'=>'required|same:new_password',
    ]);
    if($validator->fails()){
        return redirect()->route('account.resetPassword',$request->token)->withErrors($validator);
    }  
    
    User::where('email',$token->email)->update([
        'password'=>Hash::make($request->new_password)
    ]);
    return redirect()->route('account.login')->with('success','Password Changed Successfully.');
}

}
