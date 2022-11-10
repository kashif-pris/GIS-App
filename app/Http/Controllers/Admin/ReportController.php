<?php

namespace App\Http\Controllers\Admin;

use App\CentralLogics\Helpers;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\Zone;
use App\Models\Admin;
use App\Models\Restaurant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Auth;

class ReportController extends Controller
{
    public function order_index()
    {
        if (session()->has('from_date') == false) {
            session()->put('from_date', date('Y-m-01'));
            session()->put('to_date', date('Y-m-30'));
        }
        return view('admin-views.report.order-index');
    }

    public function day_wise_report(Request $request)
    {
        if (session()->has('from_date') == false) {
            session()->put('from_date', date('Y-m-01'));
            session()->put('to_date', date('Y-m-30'));
        }
        $user = auth('admin')->user();
        // dd($user->zone_id);
        if($user->role_id == '1' && $user->id == '1')
        {
          
            $zone_id = $request->query('zone_id', 'all');
            $employee = Admin::all();
        }else{
          
            $zone_id = $request->query('zone_id', $user->zone_id);
            $employee = Admin::where('zone_id' ,$user->zone_id)->get();
            // dd($employee);

        }
       
        $zone = is_numeric($zone_id)?Zone::findOrFail($zone_id):null;
    //    dd($zone);
        // dd($employee);

        return view('admin-views.report.day-wise-report', compact('zone','employee' , 'user'));
    }

    public function food_wise_report(Request $request)
    {
        if (session()->has('from_date') == false) {
            session()->put('from_date', date('Y-m-01'));
            session()->put('to_date', date('Y-m-30'));
        }
        $from = session('from_date');
        $to = session('to_date');
        dd('fuck');

        $zone_id = $request->query('zone_id', 'all');
        $restaurant_id = $request->query('restaurant_id', 'all');
        $zone = is_numeric($zone_id)?Zone::findOrFail($zone_id):null;
        $restaurant = is_numeric($restaurant_id)?Restaurant::findOrFail($restaurant_id):null;
        $foods = \App\Models\Food::withoutGlobalScopes()->withCount([
            'orders as order_count' => function($query)use($from, $to) {
                $query->whereBetween('created_at', [$from, $to]);
            },
        ])
        ->when(isset($zone), function($query)use($zone){
            return $query->whereIn('restaurant_id', $zone->restaurants->pluck('id'));
        })
        ->when(isset($restaurant), function($query)use($restaurant){
            return $query->where('restaurant_id', $restaurant->id);
        })
        ->paginate(config('default_pagination'))->withQueryString();

        return view('admin-views.report.food-wise-report', compact('zone', 'restaurant', 'foods'));
    }

    public function order_transaction()
    {
        $order_transactions = OrderTransaction::latest()->paginate(config('default_pagination'));
        return view('admin-views.report.order-transactions', compact('order_transactions'));
    }


    public function set_date(Request $request)
    {
        session()->put('from_date', date('Y-m-d', strtotime($request['from'])));
        session()->put('to_date', date('Y-m-d', strtotime($request['to'])));
        session()->put('type', $request['type']);
        session()->put('employee', $request['employee']);

        return back();
    }

    public function food_search(Request $request){
        $key = explode(' ', $request['search']);

        $from = session('from_date');
        $to = session('to_date');

        $zone_id = $request->query('zone_id', 'all');
        $restaurant_id = $request->query('restaurant_id', 'all');
        $zone = is_numeric($zone_id)?Zone::findOrFail($zone_id):null;
        $restaurant = is_numeric($restaurant_id)?Restaurant::findOrFail($restaurant_id):null;
        $foods = \App\Models\Food::withoutGlobalScopes()->withCount([
            'orders as order_count' => function($query)use($from, $to) {
                $query->whereBetween('created_at', [$from, $to]);
            },
        ])
        ->when(isset($zone), function($query)use($zone){
            return $query->whereIn('restaurant_id', $zone->restaurants->pluck('id'));
        })
        ->when(isset($restaurant), function($query)use($restaurant){
            return $query->where('restaurant_id', $restaurant->id);
        })
        ->where(function ($q) use ($key) {
            foreach ($key as $value) {
                $q->orWhere('name', 'like', "%{$value}%");
            }
        })
        ->limit(25)->get();

        return response()->json(['count'=>count($foods),
            'view'=>view('admin-views.report.partials._food_table',compact('foods'))->render()
        ]);
    }
}
