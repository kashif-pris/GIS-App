<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zone;
use Brian2694\Toastr\Facades\Toastr;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use App\CentralLogics\Helpers;
use Auth;
use Carbon\Carbon;
use DB;
class ZoneController extends Controller
{
    public function index()
    {
    
        $user = auth('admin')->user();
        $zones = Zone::latest()->paginate(config('default_pagination'));
        return view('admin-views.zone.index', compact('zones' , 'user'));

    }

    public function store(Request $request)
    {
        
        // dd($request->all());
        $request->validate([
            'name' => 'required|unique:zones',
            'coordinates' => 'required',
            'attendance_time' => 'required',
            'attendance_time_out' => 'required',
            'break_from' => 'required',
            'break_to' => 'required',
            'business_logo' => 'required',
            'timezone' =>'required',
            
        ]);
        $value = $request->coordinates; 
        foreach(explode('),(',trim($value,'()')) as $index=>$single_array){
            if($index == 0)
            {
                $lastcord = explode(',',$single_array);
            }
            $coords = explode(',',$single_array);
            $polygon[] = new Point($coords[0], $coords[1]);
        }
        $zone_id=Zone::all()->count() + 1;
        $polygon[] = new Point($lastcord[0], $lastcord[1]);
        $profile_pic = $request->business_logo;
        $ProfilePic = rand() . '.' . $profile_pic->getClientOriginalName();
        $destinationPath = public_path('/Business_Logo/');
        $profile_pic->move($destinationPath, $ProfilePic);


        $zone = new Zone();
        $zone->name = $request->name;
        $zone->attendance_time = $request->attendance_time;
        $zone->attendance_time_out = $request->attendance_time_out;
        $zone->break_from = $request->break_from;
        $zone->break_to = $request->break_to;
        $zone->business_logo = $ProfilePic;
        $zone->coordinates = new Polygon([new LineString($polygon)]);
        $zone->restaurant_wise_topic =  'zone_'.$zone_id.'_restaurant';
        $zone->customer_wise_topic = 'zone_'.$zone_id.'_customer';
        $zone->deliveryman_wise_topic = 'zone_'.$zone_id.'_delivery_man';
        $zone->timezone = $request->timezone;
        $zone->save();

        Toastr::success(trans('messages.zone_added_successfully'));
        return back();
    }

    public function edit($id)
    {
        $user = auth('admin')->user();
        if(env('APP_MODE')=='demo' && $id == 1)
        {
            Toastr::warning(trans('messages.you_can_not_edit_this_zone_please_add_a_new_zone_to_edit'));
            return back();
        }
        $zone=Zone::selectRaw("*,ST_AsText(ST_Centroid(`coordinates`)) as center")->findOrFail($id);
        // dd($zone->coordinates);
        return view('admin-views.zone.edit', compact('zone' , 'user'));
    }

    public function update(Request $request, $id)
    {
        $user = auth('admin')->user();
        $request->validate([
            'name' => 'required|unique:zones,name,'.$id,
            'coordinates' => 'required',
        ]);
        $value = $request->coordinates; 
        foreach(explode('),(',trim($value,'()')) as $index=>$single_array){
            if($index == 0)
            {
                $lastcord = explode(',',$single_array);
            }
            $coords = explode(',',$single_array);
            $polygon[] = new Point($coords[0], $coords[1]);
        }
        $polygon[] = new Point($lastcord[0], $lastcord[1]);
        $zone=Zone::findOrFail($id);
        if($request->business_logo != ''){
            $profile_pic = $request->business_logo;
            $ProfilePic = rand() . '.' . $profile_pic->getClientOriginalName();
            $destinationPath = public_path('/Business_Logo/');
            $profile_pic->move($destinationPath, $ProfilePic);

            $zone->business_logo = $ProfilePic;
        }else{
            $zone->business_logo = $zone->business_logo;
        }

        $zone->name = $request->name;

        $zone->attendance_time = $request->attendance_time;
        $zone->attendance_time_out = $request->attendance_time_out;
        $zone->break_from = $request->break_from;
        $zone->break_to = $request->break_to;
        $zone->business_logo = $ProfilePic;
        $zone->timezone =$request->timezone;

       if($user->role_id == '1' && $user->id == '1')
        {
            $zone->coordinates = new Polygon([new LineString($polygon)]);
        }else{
        $zone->coordinates = $zone->coordinates;
        }
        $zone->restaurant_wise_topic =  'zone_'.$id.'_restaurant';
        $zone->customer_wise_topic = 'zone_'.$id.'_customer';
        $zone->deliveryman_wise_topic = 'zone_'.$id.'_delivery_man';
        $zone->save();
        Toastr::success(trans('messages.zone_updated_successfully'));
        return redirect()->route('admin.zone.home');
    }

    public function destroy(Zone $zone)
    {
        if(env('APP_MODE')=='demo' && $zone->id == 1)
        {
            Toastr::warning(trans('messages.you_can_not_delete_this_zone_please_add_a_new_zone_to_delete'));
            return back();
        }
        $zone->delete();
        Toastr::success(trans('messages.zone_deleted_successfully'));
        return back();
    }

    public function status(Request $request)
    {
        if(env('APP_MODE')=='demo' && $request->id == 1)
        {
            Toastr::warning('Sorry!You can not inactive this zone!');
            return back();
        }
        $zone = Zone::find($request->id);
        $zone->status = $request->status;
        $zone->save();
        Toastr::success(trans('messages.zone_status_updated'));
        return back();
    }

    public function search(Request $request){
        $key = explode(' ', $request['search']);
        $zones=Zone::where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })->limit(50)->get();
        return response()->json([
            'view'=>view('admin-views.zone.partials._table',compact('zones'))->render(),
            'total'=>$zones->count()
        ]);
    }

    public function get_coordinates($id){
        $zone=Zone::selectRaw("*,ST_AsText(ST_Centroid(`coordinates`)) as center")->findOrFail($id);
        $data = Helpers::format_coordiantes($zone->coordinates[0]);
        $center = (object)['lat'=>(float)trim(explode(' ',$zone->center)[1], 'POINT()'), 'lng'=>(float)trim(explode(' ',$zone->center)[0], 'POINT()')];
        return response()->json(['coordinates'=>$data, 'center'=>$center]);
    }

    public function zone_filter($id)
    {
        if($id == 'all')
        {
            if(session()->has('zone_id')){
                session()->forget('zone_id');
            }
        }
        else{
            session()->put('zone_id', $id);
        }
        
        return back();
    }

    public function get_all_zone_cordinates($id = 0)
    {
        $zones = Zone::where('id', '<>', $id)->active()->get();
        $data = [];
        foreach($zones as $zone)
        {
            $data[] = Helpers::format_coordiantes($zone->coordinates[0]);
        }
        return response()->json($data,200);
    }
}
