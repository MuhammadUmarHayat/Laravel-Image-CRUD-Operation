<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;


use Illuminate\Support\Facades\File; 

class StudentController extends Controller
{
    
	public function index()
	{
		
		$student =Student::all();
		
		
		
	return view('student.index',compact('student'));//folder name page name	
		
	}
	
	
	public function create()
	{
	return view('student.create');//folder name page name	
		
	}
	public function store(Request $request)
    {
        $student = new Student;
        $student->name = $request->input('name');
		 $student->email = $request->input('email');
		  $student->course= $request->input('course');

        if($request->hasfile('profile_image'))
        {
            $file = $request->file('profile_image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/students/', $filename);
            $student->profile_image = $filename;
        }

        $student->save();
       return redirect()->back()->with('message','Student Image Upload Successfully');
		//return view('student.index');//folder name page name	
    }
	
		public function edit($id)
    {
		$student =Student::find($id);
		
		return view('student.edit',compact('student'));//folder name page name	and value
	}
	
	public function update(Request $request,$id)
    {
		
		$student =Student::find($id);
		 $student->name = $request->input('name');
		 $student->email = $request->input('email');
		  $student->course= $request->input('course');

        if($request->hasfile('profile_image'))
        {
			//delete the previous file
			$destination ='uploads/students/'.$request->profile_image;
			if(File::exists($destination))
			{
				
			File::delete($destination);	
				
			}
			
            $file = $request->file('profile_image');
            $extenstion = $file->getClientOriginalExtension();
            $filename = time().'.'.$extenstion;
            $file->move('uploads/students/', $filename);
            $student->profile_image = $filename;
        }

        $student->update();
		
		
		
		 return redirect()->back()->with('message','Student info is updated Successfully');
		
		
		
		
	}
	
	
			public function destroy($id)
    {
		$student =Student::find($id);
		
		$destination ='uploads/students/'.$student->profile_image;
			if(File::exists($destination))
			{
				
			File::delete($destination);	
				
			}
		
		 $student->delete();
		
		
		return redirect()->back()->with('message','Student info is deleted Successfully');
	}
	
}
