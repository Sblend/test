<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UsersExport;
use App\Jobs\UploadJob;

class UploadController extends Controller
{
    
	public function uploadFile(Request $request){

			$request->validate([
					'file'=>'required|mimes:xls,xlsx'
			]);
			
			$data = Excel::toCollection(new UsersExport(), $request->file('file'));

			foreach($data[0] as $user){
					
					// $gender = rand(0,1) ? 'Male' : 'Female';
					// $new_fname = $this->formatFirstname($user[1]);
					// $new_lname = $this->formatLastname($user[2]);
					$email = $this->lowerCase($user[0]);
					$new_uname = $this->formatUsername($user[3]);

					$user_data = [
						'password'=>'Ca12345678@',
						'email'=>$email,
						'firstname'=>$user[1],
						'lastname'=>$user[2],
						'username'=>$new_uname,
						'dateOfBirth'=>date('Y-m-d', strtotime(now())),
						'gender'=>strtolower($user[4]),
						'phonenumber'=>(string)$user[5],
						'street'=>$user[6],
						'city'=>$user[7],
						'state'=>$user[8],
						'country'=>$user[9],
					];
					$data = new UploadJob($user_data);

					dispatch($data);
			}

		return response()->json('All records have been uploaded successfully', 200);
	}

	public function formatUsername($uname){
					
			$firstChar = ['/'];
			$secondChar = ['~'];
			$firstString = str_replace($firstChar,'',$uname);
			$secondString = str_replace($secondChar, '-', $firstString);
			
			if(strpos($uname, '~') !== false){
					return $secondString;
			}else{
					return $firstString;
			}

	}

	public function formatFirstname($fname){

			$getFirstInArray = explode(' ', $fname)[0]; 
			return $getFirstInArray;
	}


	public function formatNewUsername($fname){

			$getFirstInArray = explode(' ', $fname)[0]; 
			$uuname =  $getFirstInArray.Str::random(3) ;
			return strtolower($uuname);
	}

	public function formatLastname($fname){

			$getFirstInArray = explode(' ', $fname)[1]; 
			if($getFirstInArray){
					return $getFirstInArray;
			}else{
					return "Lastname";
			}
	}

	public function lowerCase($value){
			return strtolower($value);
	}


}
