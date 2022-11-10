<?php

namespace App\Http\Controllers;

use App\CentralLogics\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use App\Models\BusinessSetting;

class UpdateController extends Controller
{
    public function update_software_index(){
        return view('update.update-software');
    }

    public function update_software(Request $request)
    {
        Helpers::setEnvironmentValue('SOFTWARE_ID','MzM1NzE3NTA=');
        Helpers::setEnvironmentValue('BUYER_USERNAME',$request['username']);
        Helpers::setEnvironmentValue('PURCHASE_CODE',$request['purchase_key']);
        Helpers::setEnvironmentValue('APP_MODE','live');
        Helpers::setEnvironmentValue('SOFTWARE_VERSION','4.0');

        $data = Helpers::requestSender();
        if (!$data['active']) {
            return redirect(base64_decode('aHR0cHM6Ly82YW10ZWNoLmNvbS9zb2Z0d2FyZS1hY3RpdmF0aW9u'));
        }

        Artisan::call('migrate', ['--force' => true]);
        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        $map_api_key_server=BusinessSetting::where(['key'=>'map_api_key'])->first();
        $map_api_key_server=$map_api_key_server?$map_api_key_server->value:null;

        Helpers::insert_business_settings_key('free_delivery_over');
        Helpers::insert_business_settings_key('app_minimum_version_ios');
        Helpers::insert_business_settings_key('app_minimum_version_android');
        Helpers::insert_business_settings_key('app_url_ios');
        Helpers::insert_business_settings_key('app_url_android');
        Helpers::insert_business_settings_key('dm_maximum_orders',1);
        Helpers::insert_business_settings_key('order_confirmation_model','deliveryman');
        Helpers::insert_business_settings_key('popular_food',1);
        Helpers::insert_business_settings_key('popular_restaurant',1);
        Helpers::insert_business_settings_key('new_restaurant',1);
        Helpers::insert_business_settings_key('map_api_key_server', $map_api_key_server);
        Helpers::insert_business_settings_key('flutterwave',
        json_encode([
            'status'        => 1,
            'public_key'     => '',
            'secret_key'     => '',
            'hash'    => '',
        ]));
        
        Helpers::insert_business_settings_key('mercadopago',
        json_encode([
            'status'        => 1,
            'public_key'     => '',
            'access_token'     => '',
        ]));

        return redirect('/admin/auth/login');
    }
}
