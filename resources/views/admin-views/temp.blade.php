<!DOCTYPE html>
<html lang="en">
<head>
  <title>Live Tracks</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    @php
            $total = DB::table('temp_locations')->count();
       
     @endphp
  <h2> Live Entries  (Total = {{($total)}})</h2>
  <p>Entries are in descending order!</p>
  <!-- <a href="/temp-entries-view/remove-all" class="text-danger">Remove All Entries</a> -->
  {{$data->render()}}
          
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>

        <th>User</th>
        <th>Latitude</th>
        <th>Longitude</th>
        <th>Player id</th>
        <th>Status</th>
        <th>App State</th>

        <th>Time</th>
        <th>Spent Time</th>
        <th>Date</th>


      </tr>
    </thead>
    <tbody>
        @foreach($data as $d)
        @php $user = DB::table('users')->where('id',$d->user)->select('f_name','l_name')->first(); @endphp
        <tr>
            <td>{{$d->id}}</td>
            <td> <a href="http://maps.google.com/maps?z=12&t=m&q=loc:{{$d->lat}}+{{$d->long}}" target="_blank" >{{@$user->f_name}} {{@$user->l_name}} - View On Map</a></td>

            <td>{{$d->lat}}</td>
            <td>{{$d->long}}</td>

            <td>{{$d->player_id}}</td>
            <td>{{$d->status}}</td>
            <td>{{$d->app_state}}</td>

            <td>{{$d->time}}</td>
            <td>{{$d->spent_time}}</td>
            <td>{{$d->created_at}}</td>
            
        </tr>
        @endforeach
        
    </tbody>
  </table>
  {{$data->render()}}
</div>

</body>
</html>
