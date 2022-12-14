<style type="text/css">
    table {
  border-collapse: collapse;
}

table, th, td {
  border: 1px solid black;
}
</style>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
    <div class="row">
    <div class="col-md-12">
    <!-- BEGIN EXAMPLE TABLE PORTLET-->
    <div class="portlet light portlet-fit">
      <!-- 
    <div>Contest Name : {{$contest_name}}</div>
    <div>Entry fees : {{$contest->entry_fees}}</div>
    <div>First Prize : {{$contest->first_prize}}</div>
    <div>Total Spot : {{$contest->total_spots}}</div>
    <div>Filled Spot : {{$contest->filled_spot}}</div> -->

    <table class="" style="width: 100%" cellpadding="2" cellspacing="2">
        <thead>
        <tr>
            <td>Contest Name</td>
            <td> {{$contest_name}}</td>
        </tr>
        <tr>
            <td>Entry fees</td>
            <td> {{ $contest->entry_fees}} INR</td>
        </tr>
        <tr>
            <td>First Prize</td>
            <td> {{ $contest->first_prize}}</td>
        </tr>
        <tr>
            <td>Total Spot</td>
            <td> {{ $contest->total_spots}}</td>
        </tr>
        <tr>
            <td>Filled Spot</td>
            <td> {{ $contest->filled_spot}}</td>
        </tr>
        <tr>
            <td>Match ID</td>
            <td> {{ $contest->match_id}}</td>
        </tr>
        <tr>
            <td>Total Collection</td>
            <td> {{ ($contest->filled_spot*$contest->entry_fees)}} INR </td>
        </tr>
         <tr>
            <td>Total Bonus Used</td>
            <td> {{ ($contest->filled_spot*$contest->entry_fees)*($contest->usable_bonus/100)}} INR </td>
        </tr>
        <tr>
            <td>Total Winning Prize</td>
            <td> {{ $contest->total_winning_prize}} INR </td>
        </tr>

        
        </thead>
    </table>  
    <p> <b> {{strip_tags($contest_name)}} </b> </p>
    <table class="table table-striped table-hover table-bordered" border="1" cellspacing="2" cellpadding="2">
        <thead>
        <tr>
            <td>Sno.</td>
        @foreach($tables as $col_name)
        <th> {{  \Str::replaceFirst('_'," ",ucfirst($col_name)) }}</th> 
        @endforeach
        </tr>
        </thead>

        @if($matchTeams->count()==0)
        <div class="alert alert-danger"><h2> Team not created yet! <h2> </div>
        @endif
        <tbody>
         @foreach($matchTeams as $key => $result)
        <tr>
            <td>{{++$key}}</td>
            @foreach($tables as $col_name)
                   <td>  {!!$result->$col_name!!} </td>
            @endforeach
                
        </tr>
       @endforeach
        
      </tbody>
    </table>
    
                </div>
                <!-- END EXAMPLE TABLE PORTLET-->
            </div>
        </div>
        <!-- END PAGE BASE CONTENT -->
    </div>
    <!-- END CONTENT BODY -->
</div> 