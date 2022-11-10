<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\CentralLogics\Helpers;
use App\CentralLogics\SMS_module;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Models\BusinessSetting;
use App\Models\EmailVerifications;
use App\Models\User;
use App\Models\Zone;
use App\Models\TempEntries;
use App\Models\Product;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Config;
use Auth;
use DateTime;
class LocationController_1
{
    var $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?
 
    function pointLocation() {
    }
 
    function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;
 
        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array(); 
        foreach ($polygon as $vertex) {
            // dd($polygon);
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }

 
        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "vertex";
        }
 
        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);
        
        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "boundary";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "boundary";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        // dd($intersections);
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }

    /// Testing api for Ali Abdullah ///////

    public function dataEntryTest(Request $request)
    {
        $email = Product::where('email' , $request->email)->first();
        if($email == '')
        {
            $data = new Product;
            $data->name = $request->name;
            $data->email = $request->email;
            $data->password = $request->password;
            $data->address = $request->address;
            if($data->save())
            {
                return $data.'information saved to database';
            }else{
                return 'invalid information';
            }
        }else{
            return 'email already in use';
        }
    }

    public function testEntryget()
    {
        $data = Product::get();
        return json_encode(['message' => 'successfully run' , 'data' => $data]);
    }

    ////// End Test api ///////
 
    function pointOnVertex($point, $vertices) {
        // dd($point, $vertices);
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
 
    }
 
    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        // dd($coordinates[1]);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }

    // Tests

    function checking(Request $request) {
        // return $request->all();
        
       $user = User::where('id',$request->user_id)->first();
       
       $id = $user->id;
       $entyGap = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                            ->where('timestamp',$request->timestamp)
                            ->where('user',$id)
                            ->select('time')
                            ->orderBy('id','desc')
                            ->first();
  
   

        $point = $request->lat.' '.$request->long;
        $break_from=\App\Models\Zone::where('id',$user->zone_id)->first();
        $break_to=\App\Models\Zone::where('id',$user->zone_id)->first();
        $attendanceTime=\App\Models\Zone::where('id',$user->zone_id)->first();
        $checkOutTime=\App\Models\Zone::where('id',$user->zone_id)->first();


        $new_time = Carbon::now()->format('H:i');
        // date_default_timezone_set("Asia/Karachi");
        // // date("h:i:sa");
        // $new_time = Carbon::now('Asia/Karachi')->format('h:i A');
        $now = $new_time;
        $date1 = new DateTime($break_from->value);
        $date2 = new DateTime($break_to->value);

      
      
        $employeeTempEntry = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                        ->where('user',$id)
                        ->where('status','inside')
                        ->first();
        if($employeeTempEntry){
            $start = strtotime($employeeTempEntry->time);
            $end = strtotime($now);
            $mins = ($end - $start) / 60 ;
        }


        if($now >= $break_from->break_from && $now <= $break_to->break_to){
            return response()->json([
                'Info' =>"its break time ".$break_from->break_from.'============'.$break_to->break_to
            ], 200);
        }else{

            $pointLocation = new LocationController_1();
            $zone=Zone::where('id',$user->zone_id)->selectRaw("*,ST_AsText(ST_Centroid(`coordinates`)) as center")->first();
            
            foreach($zone->coordinates[0] as $key=>$coords){
                if(count($zone->coordinates[0]) != $key+1) {
                    $polygon[] = $coords->getLat().' '.$coords->getLng();
                }            
            }
          
                $todayOutSide = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                            ->where('status','outside')
                                            ->where('user',$id)
                                            ->select('user')
                                            ->groupBy('user')
                                            ->get();
                $todayInside = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                            ->where('status','inside')
                                            ->where('user',$id)
                                            ->select('user')
                                            ->groupBy('user')
                                            ->get();
              
                $new_time = Carbon::now()->format('H:i');
                $now = $new_time;
                $date1 = new DateTime($attendanceTime->attendance_time);
                // $date1->format('h:i A');
                $date2 = new DateTime($checkOutTime->attendance_time_out);
                // $date2->format('h:i A');
               
              
                    // check out entry
            
                if($now == $checkOutTime->attendance_time_out){

                            $employeeTempEntry = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                                        ->where('user',$id)
                                                        ->where('status','outside')
                                                        ->latest()->first();
                           
                          
                            $main = Attendance::where('employee_id',$id)->first();
                            if($main){
                              
                                $main->check_out = $employeeTempEntry->time;
                                $main->active_hours = $employeeTempEntry->spent_time;
                                $main->updated_at = Carbon::now();
                                $main->zone_id = $user->zone_id;
                                $main->save();
                                return response()->json([
                                    'Check-Out' =>"Check Out Successfully at ".$now
                                ], 200);
                            }else{
                                $timeIN = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                                    ->where('user',$id)
                                                    ->where('status','inside')
                                                    ->first();

                                    // total hours spent
                                $mins = $employeeTempEntry->spent_time;
                                $main = new Attendance();
                                $main->employee_id = $id;
                                $main->check_in = $timeIN->time;
                                $main->zone_id = $user->zone_id;
                                $main->check_out = $employeeTempEntry->time;
                                $main->active_hours = $employeeTempEntry->spent_time;
                                $main->updated_at = Carbon::now();
                                $main->save();
                                return response()->json([
                                    'Check-Out' =>"Check Out Successfully at ".$now
                                ], 200);
                            
                    }
                    \Log::info('Successfully check out.');
                            
                }else{
                    // The last point's coordinates must be the same as the first one's, to "close the loop"

                        $employeeTempEntry = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                            ->where('user',$id)
                                            ->where('status','inside')
                                            ->first();
                                        
                        $employeeOutside = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                            ->where('user',$id)
                                            ->where('status','outside')
                                            ->first();
                        $employeeOutside_2 = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                            ->where('user',$id)
                                            ->where('status','outside')
                                            ->latest()->first();
                                           
                        // inside time counter
                        if($employeeTempEntry){
                            $start = strtotime($employeeTempEntry->time);
                            $end = strtotime($now);
                            $mins = ($end - $start) / 60;
                            $spentTime = $mins / 60;
                        }else{
                            $spentTime = 0;
                        }
                        
                        // outside time counter
                        if($employeeOutside){
                            $start = strtotime($employeeOutside->time);
                            $end = strtotime($employeeOutside_2->time);
                            $mins = ($end - $start) / 60;
                            $outsideTime = $mins / 60;
                        }else{
                            $outsideTime = 0;
                        }
                            $status = $pointLocation->pointInPolygon($point, $polygon);
                            // if($request->player_id != 'undefined'){
                                DB::table('temp_locations')->insert([
                                    'lat'=>$request->lat,
                                    'long'=>$request->long,
                                    'user'=>$id,
                                    'player_id'=>$request->player_id,
                                    'status'=>$status,
                                    'app_state'=>$request->app_state,
                                    'time'=>date("h:i A"),
                                    'timestamp'=>$request->timestamp,
                                    'spent_time'=>(float)$spentTime,
                                    'out_side_time'=>(float)$outsideTime,
                                    'zone_id' =>$user->zone_id,
                                    'created_at'=>date('Y-m-d')

                                ]);
                            // }
                              
                             // Entry to main table scenarios
                            $employeeUser = User::where('id',$id)->select('employee_id','f_name','l_name')->first();
                            $name = $employeeUser->f_name.' '.$employeeUser->l_name;
                            $outSideEntry = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                                    ->where('user',$id)
                                                    ->where('status','outside')
                                                    ->latest()->first();
                            $timeIN = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                                    ->where('user',$id)
                                                    ->where('status','inside')
                                                    ->latest()->first();
                           
                            $main = Attendance::where('employee_id',$employeeUser->employee_id)
                                                ->where('date', Carbon::today()->format('Y-m-d'))
                                                ->first();
                             // if attendance of employee user already marked 
                            if($main){
                                  // system checks if the user has latest outside entry
                                if($outSideEntry){
                                     // system checks if the user is inside the zone then it updates total active hours in the zone
                                    //  most of execution will be performed here
                                    if($status == "inside"){
                                        $main->check_out = null;
                                        $main->active_hours = ($spentTime - $outsideTime); //calculation issue may occure / logically
                                        $main->updated_at = Carbon::now();
                                        $main->zone_id = $user->zone_id;
                                        $main->status = $status;
                                        $main->save();
                                        \Log::info('Attendance inside time updated successfully by employee  '.$name);
                                        return response()->json([
                                            'Message' =>"Attendance inside time updated successfully. ".$now
                                        ], 200);
                                    }else{
                                        // system checks if the user is outside the zone then it updates its outside attendance status
                                        if($main->check_out == null ){
                                            $main->check_out = $outSideEntry->time;
                                            $main->updated_at = Carbon::now();
                                            $main->zone_id = $user->zone_id;
                                            $main->status = $status;
                                            $main->save();
                                            \Log::info('Attendance checked-out successfully by employee '.$name);
                                            return response()->json([
                                                'Message' =>"Attendance checked-out successfully. ".$now
                                            ], 200);
                                        }else{
                                            return response()->json([
                                                'Message' =>"Already checked-out !. ".$now
                                            ], 200);
                                        }
                                       
                                    }
                                        
                                }else{
                                    $main->employee_id =$employeeUser->employee_id;
                                    $main->active_hours = $spentTime;
                                    $main->updated_at = Carbon::now();
                                    $main->zone_id = $user->zone_id;
                                    $main->status = $status;
                                    $main->save();
                                    \Log::info('Attendance inside time updated successfully by employee  '.$name);
                                    return response()->json([
                                        'Message' =>"Attendance inside time updated successfully.  23 ".$now.'---OutSide='.$outsideTime
                                    ], 200);
                               }
                                
                            }else{
                                      // system enters new record of attendance for new day / date, only one time per day
                                    if($status == "inside"){
                                        $main = new Attendance();
                                        $main->employee_id =$employeeUser->employee_id;
                                        $main->check_in = @$timeIN->time;
                                        $main->check_out = null;
                                        $main->active_hours = @$timeIN->spent_time;
                                        $main->zone_id = $user->zone_id;
                                        $main->updated_at = Carbon::now();
                                        $main->date = date('Y-m-d');
                                        $main->status = $status;
                                        $main->save();
                                        // removing outside entries
                                        TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                                    ->where('user',$id)
                                                    ->where('status','outside')
                                                    ->delete();
                                        \Log::info('Attendance checked-in successfully by employee '.$name);
                                        return response()->json([
                                            'Message' =>"Attendance checked-in successfully. ".$now
                                        ], 200);
                                    }
                                   
                              
                            }
                            return response()->json([
                                'Check-Out' =>"Location posted successfully ".$now
                            ], 200);
                    // }
                }

        }

        
    }

    public function checkInAttendance(Request $request)
    {
      
        
        $attendanceTime=\App\Models\BusinessSetting::where('key','attendance_time')->first();
        // $user = User::where('id',$request->user_id)->first();
        // $id = $user->id;
        $todayInside = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                    ->where('status','inside')
                                    // ->where('user',$id)
                                    ->select('user')
                                    ->groupBy('user')
                                    ->get();

            // return $todayInside;
            $insideCount = count($todayInside);
            for($i=0; $i<$insideCount; $i++)
            {
                $new_time = Carbon::now()->format('h:i A');
                $now = $new_time;
                $date1 = new DateTime($attendanceTime->value);
                $date1->format('h:i A');
                if($now == $date1->format('h:i A')){
                        
                   
                            $employeeTempEntry = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                                        ->where('user',$todayInside[$i]->user)
                                                        ->where('status','inside')
                                                        ->first();
                            $user_employeeTempEntry = User::where('id' , $employeeTempEntry->user)->first();
                            $start = strtotime($employeeTempEntry->time);
                            $end = strtotime($now);
                            $mins = ($end - $start) / 60;

                            $main = new Attendance();
                            $main->employee_id = $user_employeeTempEntry->employee_id;
                            $main->check_in = $employeeTempEntry->time;
                            $main->check_out = null;
                            $main->active_hours = $employeeTempEntry->spent_time;
                            $main->updated_at = Carbon::now();
                            $main->save();                
                    
                }
                            
            }

            $new_time = Carbon::now()->format('h:i A');
            $now = $new_time;
            $date1 = new DateTime($attendanceTime->value);
            $date1->format('h:i A');
            if($now == $date1->format('h:i A')){

            return response()->json([
                'Check-In' =>"Check In Successfully at ".$now 
            ], 200);
            }else{
                return response()->json([
                    'Check-In-Time-For-Attendance-Is-Out' =>"Check In failed because its not attendance time at ".$now 
                ], 200);
            }


    }

    public function checkOutAttendance(Request $request)
    {
      
            $checkOutTime=\App\Models\BusinessSetting::where('key','time_out')->first();
            // $user = User::where('id',$request->user_id)->first();
            // $id = $user->id;
            $todayOutSide = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                    ->where('status','outside')
                                    // ->where('user',$id)
                                    ->select('user')
                                    ->groupBy('user')
                                    ->get();
    
            // return $todayOutSide;
            $outsideCount = count($todayOutSide);
            for($i=0; $i<$outsideCount; $i++)
            {
                $new_time = Carbon::now()->format('h:i A');
                $now = $new_time;
                $date1 = new DateTime($checkOutTime->value);
                $date1->format('h:i A');
                if($now == $date1->format('h:i A')){
                        
                   
                  
                    $employeeTempEntry = TempEntries::where('created_at', Carbon::today()->format('Y-m-d'))
                                                        ->where('user',$todayOutSide[$i]->user)
                                                        ->where('status','inside')
                                                        ->first();
                           
                          
                            
                    $main = Attendance::where('employee_id',$employeeTempEntry->user)->first();
                            if($main){
                                
                                $main->check_out = $employeeTempEntry->time;
                                $main->active_hours = $employeeTempEntry->spent_time;
                                $main->updated_at = Carbon::now();
                                $main->save();    
                        }
                            
                }
            }
    
            $new_time = Carbon::now()->format('h:i A');
            $now = $new_time;
            $date1 = new DateTime($checkOutTime->value);
            $date1->format('h:i A');
            if($now == $date1->format('h:i A')){
    
            return response()->json([
                'Check-In' =>"Check In Successfully at ".$now 
            ], 200);
            }else{
                return response()->json([
                    'Check-In-Time-For-Attendance-Is-Out' =>"Check In not Successfully because its not attendance time at ".$now 
                ], 200);
            }
    
    
        
}




    public function checkOneSginal_1()
    {
        
        $player_ids = TempEntries::distinct('user')
                ->where('timestamp','>=',Carbon::now()->subMinutes(20))
                ->pluck('user')->toArray();
            
        $employees = User::where('role_id','!=','1')->pluck('id')->toArray();
        $result=array_diff($employees,$player_ids);
        $sendNotifications = TempEntries::distinct('user')
                ->whereIn('user',$result)
                ->whereNotNull('player_id')
                ->pluck('player_id')->toArray();

        // dd($player_ids,$employees,$result,$sendNotifications,Carbon::now()->subMinutes(5));
        

                    $content = array(
                        "en" => "Please open your Attendance Application",
                    );
                    
                    $fields = array(
                        'app_id'    =>  "36953ca9-3d84-4c9f-a804-4f347695969a",         
                        'include_player_ids' => $sendNotifications,
                        'contents' => $content
                    );
                    
                    $fields = json_encode($fields);
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                    curl_setopt($ch, CURLOPT_HEADER, FALSE);
                    curl_setopt($ch, CURLOPT_POST, TRUE);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);                    
                    $response = curl_exec($ch);
                    curl_close($ch); 
                    $string = '';
                    foreach($employees as $emp){
                        $name = User::where('id',$emp)->select('id','f_name','l_name')->first();
                        $string.= PHP_EOL.$name->f_name.' '.$name->l_name.' ====ID====== '.$emp;
                    }
                    \Log::info("Open Application Notification Employees  : ".$string);                   
                    return $response;
               
            
                function notifications(){
                    return response()->json([
                        'data' => []
                    ], 200);
                }
            }
        }
        


       
        

        // checkout broadcast users [playerid];


        // return $noti;


        //         $content = array(
        //             "en" => "Please open your App for checkin!",
        //         );
        //         print_r($noti) ; 
        //         $fields = array(
        //             'app_id'    =>  "36953ca9-3d84-4c9f-a804-4f347695969a",     
                    
        //             'include_player_ids' => $noti,
        // //          'data' => array("type" => $type),
        //             'contents' => $content
        //         );
                
        //         $fields = json_encode($fields);
        //         //return print("\nJSON sent:\n");
        //         //return print($fields);
                
        //         $ch = curl_init();
        //         curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        //         curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8'));
        //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //         curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //         curl_setopt($ch, CURLOPT_POST, TRUE);
        //         curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        //         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                
        //         $response = curl_exec($ch);
        //         curl_close($ch);
                
        //         return $response;
        // }

            // function notifications(){
            //     return response()->json([
            //         'data' => []
            //     ], 200);
            // }
        // }


        

    



