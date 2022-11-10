<?php

namespace App\Http\Controllers\Api\V1\Auth;
use Illuminate\Http\Request;
use App\Models\Zone;
use Brian2694\Toastr\Facades\Toastr;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Grimzy\LaravelMysqlSpatial\Types\Polygon;
use Grimzy\LaravelMysqlSpatial\Types\LineString;
use App\CentralLogics\Helpers;
use DB;
class LocationController extends Controller
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
       
        $point = $request->lat.' '.$request->long;
        return response()->json([
            'Info' => $point 
        ], 200);
        
        $pointLocation = new LocationController();
        $points = array(
            $point        
        );
        $zone=Zone::selectRaw("*,ST_AsText(ST_Centroid(`coordinates`)) as center")->findOrFail(1);
        
        foreach($zone->coordinates[0] as $key=>$coords){
            if(count($zone->coordinates[0]) != $key+1) {
                $polygon[] = $coords->getLat().' '.$coords->getLng();
            }
        
        }
        // The last point's coordinates must be the same as the first one's, to "close the loop"
        foreach($points as $key => $point) {
            DB::table('temp_locations')->insert([
                    'lat'=>$request->lat,
                    'long'=>$request->long,
                    'status'=>$pointLocation->pointInPolygon($point, $polygon),
                    'app_state'=>$request->app_state
                ]);
            return response()->json([
                'Info' => $pointLocation->pointInPolygon($point, $polygon) 
            ], 200);
        }
    }



    public function tempEntries(Request $request){
        $data = DB::table('temp_locations')->paginate(50);

        return view('admin-views.temp',compact('data'));
    }


        


}
