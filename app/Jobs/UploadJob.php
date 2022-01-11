<?php

namespace App\Jobs;

use App\Mail\SendEnrolleeEmail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Mail;


class UploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $timeout = 900;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user_d = $this->data;

        if($user_d['email'] && $user_d['email'] !== "retailenrollee2@hygeiahmo.com" 
            && $user_d['email'] !== "accesscustomer@healthxtra.com" 
            && $user_d['email'] !== "dummy@hygeiahmo.com"){
            Mail::to($user_d['email'])->send(new SendEnrolleeEmail($user_d));
        }
        $link = 'https://account.careclick.healthcare/api/register';

        // $response = Http::post($link, [

				// 	'username'=>strtolower($this->user_data['username']),
				// 	'email'=> $this->user_data['email'] ? $this->user_data['email'] : 'hygeia@careclick.healthcare',
				// 	'firstname'=>$this->user_data['firstname'],
				// 	'lastname'=>$this->user_data['lastname'],
				// 	'gender'=>$this->user_data['gender'],
				// 	'dob'=>$this->user_data['dateOfBirth'],
				// 	'phonenumber'=>substr($this->user_data['phonenumber'], 0, 1) == '0' ? $this->user_data['phonenumber'] : 'NULL',
				// 	'account'=>'hygeiahmo',
				// 	'user_identifier'=>$user_d['hmo_id'] ?? 'hygeiahmo-63'

        // ]);

    }
}
