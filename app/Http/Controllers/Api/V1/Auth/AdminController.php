<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\CentralLogics\Helpers;
use App\CentralLogics\SMS_module;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Models\BusinessSetting;
use App\Models\EmailVerifications;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use DateTime;
use Carbon\Carbon;
use Auth;
class AdminController extends Controller
{
    public function verify_phone(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:11|max:14',
            'otp'=>'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }
        $user = User::where('phone', $request->phone)->first();
        if($user)
        {
            if($user->is_phone_verified)
            {
                return response()->json([
                    'message' => 'Phone number is already verified'
                ], 200);

            }

            if(env('APP_MODE')=='demo')
            {
                if($request['otp']=="1234")
                {
                    $user->is_phone_verified = 1;
                    $user->save();
                    
                    return response()->json([
                        'message' => 'Phone number is successfully verified!',
                        'otp' => 'inactive'
                    ], 200);
                }
                return response()->json([
                    'message' => 'Phone number and otp not matched!'
                ], 404);
            }

            $data = DB::table('phone_verifications')->where([
                'phone' => $request['phone'],
                'token' => $request['otp'],
            ])->first();

            if($data)
            {
                DB::table('phone_verifications')->where([
                    'phone' => $request['phone'],
                    'token' => $request['otp'],
                ])->delete();

                $user->is_phone_verified = 1;
                $user->save();

                return response()->json([
                    'message' => 'Phone number is successfully verified!',
                    'otp' => 'inactive'
                ], 200);
            }
            else{
                return response()->json([
                    'message' => 'Phone number and otp not matched!'
                ], 404);
            }
        }
        return response()->json([
            'message' => trans('messages.not_found')
        ], 404);

    }

    public function check_email(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }


        if (BusinessSetting::where(['key'=>'email_verification'])->first()->value){
            $token = rand(1000, 9999);
            DB::table('email_verifications')->insert([
                'email' => $request['email'],
                'token' => $token,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            Mail::to($request['email'])->send(new EmailVerification($token));

            return response()->json([
                'message' => 'Email is ready to register',
                'token' => 'active'
            ], 200);
        }else{
            return response()->json([
                'message' => 'Email is ready to register',
                'token' => 'inactive'
            ], 200);
        }
    }

    public function storeLeave(Request $request)
    {

        // return response()->json(['data' => $request->all()], 200);

        $validator = Validator::make($request->all(), [
            'date_from' => 'required',
            'date_to' => 'required',
            'reason' => 'required',
        ], [
            'date_from.required' => 'The from date field is required.',
            'date_to.required' => 'The to date field is required.',
            'reason.required' => 'The reason field is required.',

        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        $tdate = $request->date_to;
        $fdate = $request->date_from;
        $date1 = new DateTime($fdate);
        $date2 = new DateTime($tdate);
        $interval = $date1->diff($date2);
        $days = $interval->format('%a');

        $newDate = [];
        $inicialDate = Carbon::parse($request->date_from);
        // $date = Carbon::now();
    
        for($i = 1 ; $i < $days; $i++){
      
            $newDate[$i] = $inicialDate->addDay(1);

            if($newDate[$i]->format('l') == "Sunday") 
            {
                $newDate[$i] = $inicialDate->addDay(1);
            }

           

        }

        // return $days ;

        $leaveRequest = DB::table('hr_leave_requests')->insert([
            'employee_id' => $request->user_id,
            'date_from' => $request->date_from,
            'date_to' => $request->date_to,
            'days' => $days,
            'authorized_days' => 0,
            'reason' => $request->reason,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return response()->json(['Success' => "Leave request posted successfully", ], 200);
    }


    function setups(){
        $timeIn = DB::table('business_settings')->where(['key' => 'time_in'])->first();
        $timeOut = DB::table('business_settings')->where(['key' => 'time_out'])->first();
        $breakT = DB::table('business_settings')->where(['key' => 'break_to'])->first();        
        $breakF = DB::table('business_settings')->where(['key' => 'break_from'])->first();


        return response()->json([
            'time_in' => $timeIn->value,
            'time_out' => $timeOut->value,
            'break_start' => $breakT->value,
            'break_end' => $breakF->value,

        ], 200);
    }
    
}
