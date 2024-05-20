<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $users=User::orderBy('created_at','DESC')->paginate(10);
        return view('admin.user.list',[
            'users'=>$users
        ]);
    }

    public function edit($id){
        $user=User::findOrFail($id);

        return view('admin.user.edit',[
            'user'=>$user
        ]);
    }
    public function update($id, Request $request){
        
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
          
        session()->flash('success','User info updated Successfully');

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
   

    public function destroy(Request $request){
        $id=$request->id;
        $user=User::find($id);
      

        if($user==null){
            session()->flash('error','User not found');

            return response()->json([
                'status'=>false,
                
            ]);
        }

        $user->delete();

        session()->flash('success','User deleted Successfully');

        return response()->json([
            'status'=>true,
            
        ]);
    }
        
    public function pubReqlist()
    {
        $users=User::orderBy('created_at','DESC')->paginate(10);
        return view('admin.enrollments.pubreq',[
            'users'=>$users
        ]);
    }

    public function pubRequest($id){
      
        $user=User::find($id);
        $user->changeRole=0;
        $user->save();
    
       User::where('id', $id) // Add conditions as needed
        ->update(['role' => 'publisher']);
           
        session()->flash('success','Request Sent successfully');
        return redirect()->route('admin.pubReqlist')->with('success', 'Accepted successfully.');
        
       }
       public function remRequest($id){
      
        $user=User::find($id);
        $user->changeRole=0;
        $user->save();
    
           
        session()->flash('success','Request Sent successfully');
        return redirect()->route('admin.pubReqlist')->with('success', 'Removed successfully.');
        
       }

}
