<div class="tab-pane active" id="tab_1_1"> 
<div class="portlet light bordered">
 <div class="portlet-title">
            <div class="caption">
                <i class="icon-social-dribbble font-green"></i>
                <span class="caption-subject font-green bold uppercase">Personel Info
                </span>
            </div> 
        </div>
    
    <div class="form-group {{ $errors->first('name', ' has-error') }}" >
        <label class="control-label">Full Name</label>
        <input type="text" placeholder="Name" class="form-control" name="name" value="{{ ($user->name)?$user->name:old('name')}}">  
    </div>
     <div class="form-group {{ $errors->first('email', ' has-error') }}">
        <label class="control-label ">Email</label>
        <input type="email" placeholder="Email" class="form-control" name="email" value="{{ ($user->email)?$user->email:old('email')}}"> 
    </div>
     
     <div class="form-group {{ $errors->first('password', ' has-error') }}">
        <label class="control-label ">Password</label>
        <input type="password" placeholder="password" class="form-control" name="password" value="{{ ($user->password)?$user->password:old('password')}}"> 
    </div>
    

    @if($user->role_type==3)
     <div class="form-group {{ $errors->first('password', ' has-error') }}">
        <label class="control-label">Role Type</label>
          <select name="role_type" class="form-control select2me">
               <option value="">Select Roles...</option>
                 <option value="3" selected="selected">Customer</option>
                
                </select>
                <span class="help-block">{{ $errors->first('role_type', ':message') }}</span>
    </div>

    @else
     <div class="form-group {{ $errors->first('role_type', ' has-error') }}">
        <label class="control-label">Role Type</label>
          <select name="role_type" class="form-control select2me">
               <option value="">Select Roles...</option>
                @foreach($roles as $key=>$value)
                
                <option value="{{$value->id}}" {{($value->id ==$role_id)?"selected":"selected"}}>{{ $value->name }}</option>
                @endforeach
                </select>
                <span class="help-block">{{ $errors->first('role_type', ':message') }}</span>
    </div>

    @endif 
   
     <div class="form-group {{ $errors->first('mobile_number', ' has-error') }}">
        <label class="control-label">Mobile Number</label>
        <input type="text" placeholder="Mobile or Phone" class="form-control phone" name="mobile_number"  value="{{ ($user->mobile_number)?$user->mobile_number:old('mobile_number')}}"> </div> 
 <!-- 

        <div class="form-group {{ $errors->first('user_name', ' has-error') }}">
        <label class="control-label">User Name</label>
        <input type="text" placeholder="" class="form-control" name="user_name"  value="{{ ($user->user_name)?$user->user_name:old('user_name')}}"> </div> -->
 <!-- 

        <div class="form-group {{ $errors->first('dateOfBirth', ' has-error') }}">
        <label class="control-label">Date of birth</label>
        <input type="text" placeholder="DOB" class="form-control " name="dateOfBirth"  value="{{ ($user->dateOfBirth)?$user->dateOfBirth:old('dateOfBirth')}}"> </div> -->

        <div class="form-group {{ $errors->first('state', ' has-error') }}">
        <label class="control-label">State</label>
        <input type="text" placeholder="" class="form-control " name="state"  value="{{ ($user->state)?$user->state:old('state')}}"> </div>
    
    
      @if($user->role_type==3)
      
@endif
    @if($user->role_type==3)
     
 
    @endif
     <div class="margin-top-10">

                <button type="submit" class="btn green" value="personelInfo" name="submit"> Save </button>
                 <a href="{{url(URL::previous())}}">
{!! Form::button('Cancel', ['class'=>'btn btn-warning text-white']) !!} </a>
            </div>  
</div>
</div>