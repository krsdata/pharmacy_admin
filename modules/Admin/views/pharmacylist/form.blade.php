<div class="row">
   
    <div class="col-md-6">

        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button> Please fill the required field! </div>

        <div class="form-group {{ $errors->first('name', ' has-error') }}">
            <label class="control-label col-md-3">Pharmacy Name<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('name',$pharmacylist->name, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('name', ':message') }}</span>
            </div>
        </div> 

        <div class="form-group {{ $errors->first('contact', ' has-error') }}">
            <label class="control-label col-md-3">Contact Person<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('contact',$pharmacylist->contact, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('contact', ':message') }}</span>
            </div>
        </div>  
        <div class="form-group {{ $errors->first('email', ' has-error') }}">
            <label class="control-label col-md-3">Email<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::email('email',null, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('email', ':message') }}</span>
            </div>
        </div>  
     

        <div class="form-group {{ $errors->first('phone', ' has-error') }}">
            <label class="control-label col-md-3">Phone number<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('phone',$pharmacylist->phone, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
            </div>
        </div>  

         <div class="form-group {{ $errors->first('mobile_number', ' has-error') }}">
            <label class="control-label col-md-3">Mobile number<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('mobile_number',$pharmacylist->mobile_number, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('mobile_number', ':message') }}</span>
            </div>
        </div>  

        

         <div class="form-group {{ $errors->first('address', ' has-error') }}">
            <label class="control-label col-md-3">Address<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('address',$pharmacylist->address, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('address', ':message') }}</span>
            </div>
        </div>

        <div class="form-group {{ $errors->first('city', ' has-error') }}">
            <label class="control-label col-md-3">City<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('city',$pharmacylist->city, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('city', ':message') }}</span>
            </div>
        </div>

        <div class="form-group {{ $errors->first('state', ' has-error') }}">
            <label class="control-label col-md-3">State<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('state',$pharmacylist->state, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('state', ':message') }}</span>
            </div>
        </div>
    </div>
    <div class="col-md-6">

        <div class="form-group {{ $errors->first('zipcode', ' has-error') }}">
            <label class="control-label col-md-3">Zipcode<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('zipcode',null, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('zipcode', ':message') }}</span>
            </div>
        </div>  

        <div class="form-group {{ $errors->first('fax_number', ' has-error') }}">
            <label class="control-label col-md-3">Fax number<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('fax_number',$pharmacylist->fax_number, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('fax_number', ':message') }}</span>
            </div>
        </div> 

        <div class="form-group {{ $errors->first('dba_name', ' has-error') }}">
            <label class="control-label col-md-3">DBA Name<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('dba_name',$pharmacylist->dba_name, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('dba_name', ':message') }}</span>
            </div>
        </div> 


        <div class="form-group {{ $errors->first('dea_license_number', ' has-error') }}">
            <label class="control-label col-md-3">DEA License No<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('dea_license_number',$pharmacylist->dea_license_number, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('dea_license_number', ':message') }}</span>
            </div>
        </div> 

        <div class="form-group {{ $errors->first('dea_license_exp', ' has-error') }}">
            <label class="control-label col-md-3">DEA License Exp<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('dea_license_exp',$pharmacylist->dea_license_exp, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('dea_license_exp', ':message') }}</span>
            </div>
        </div> 


        

        <div class="form-group {{ $errors->first('state_license_number', ' has-error') }}">
            <label class="control-label col-md-3">State License No<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('state_license_number',$pharmacylist->state_license_number, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('state_license_number', ':message') }}</span>
            </div>
        </div>  

        <div class="form-group {{ $errors->first('state_license_exp', ' has-error') }}">
            <label class="control-label col-md-3">State License Exp.<span class="required"> * </span></label>
            <div class="col-md-6"> 
                {!! Form::text('contstate_license_expact',$pharmacylist->state_license_exp, ['class' => 'form-control','data-required'=>1])  !!} 

                <span class="help-block">{{ $errors->first('state_license_exp', ':message') }}</span>
            </div>
        </div>  

    </div>
</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}


            <a href="{{route('pharmacyList')}}">
                {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>
</div>

