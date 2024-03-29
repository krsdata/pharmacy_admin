<div class="form-group{{ $errors->first('name', ' has-error') }}">
    <label class="control-label col-md-3"> Name 
      <span class="required">*</span>
      </label>
    <div class="col-md-4"> 
        {!! Form::text('name',$dashboardusers->name, ['class' => 'form-control'])  !!} 
          <span class="label label-danger">{{ $errors->first('name', ':message') }}</span>
    </div>
  </div> 

   <div class="form-group{{ $errors->first('email', ' has-error') }}">
    <label class="control-label col-md-3"> Email <span class="required">*</span></label>
    <div class="col-md-4"> 
        {!! Form::text('email',$dashboardusers->email, ['class' => 'form-control '])  !!} 
          <span class="label label-danger">{{ $errors->first('email', ':message') }}</span>
    </div>
  </div> 
   <div class="form-group{{ $errors->first('password', ' has-error') }}">
    <label class="control-label col-md-3"> Password <span class="required">*</span></label>
    <div class="col-md-4"> 
        {!! Form::text('password',null, ['class' => 'form-control ','placeholder'=>'******'])  !!} 
          <span class="label label-danger">{{ $errors->first('password', ':message') }}</span>
    </div>
  </div> 
  <div class="form-group {{ $errors->first('role_type', ' has-error') }}">
        <label class="control-label col-md-3">Role Type</label>
         <div class="col-md-4"> 
          <select name="role_type" class="form-control select2me">
               <option value="">Select Roles...</option>
                @foreach($roles as $key=>$value)
                
                <option value="{{$value->id}}" {{($value->id ==$role_id)?"selected":"selected"}}>{{ $value->name }}</option>
                @endforeach
                </select>
                <span class="label label-danger">{{ $errors->first('role_type', ':message') }}</span>
                </div>
    </div>
  <div class="form-group">
      <label class="control-label col-md-3"></label>
      <div class="col-md-4">
          {!! Form::submit('Update', ['class'=>'btn btn-primary text-white']) !!}
          <a href="{{ url('admin') }}" 
          {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!}
          </a>
      </div>
  </div> 
