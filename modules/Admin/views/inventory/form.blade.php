<div class="form-body">
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button> Please fill the required field! </div>
 
    <div class="form-group {{ $errors->first('name', ' has-error') }}">
        <label class="control-label col-md-3">Name<span class="required"> * </span></label>
        <div class="col-md-4"> 
            {!! Form::text('name',$inventory->name, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('name', ':message') }}</span>
        </div>
    </div>  

    <div class="form-group {{ $errors->first('phone', ' has-error') }}">
        <label class="control-label col-md-3">Phone<span class="required"> * </span></label>
        <div class="col-md-4"> 
            {!! Form::text('phone',$inventory->phone, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('phone', ':message') }}</span>
        </div>
    </div>  

    <div class="form-group {{ $errors->first('contact', ' has-error') }}">
        <label class="control-label col-md-3">Contact Person<span class="required"> * </span></label>
        <div class="col-md-4"> 
            {!! Form::text('contact',$inventory->contact, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('contact', ':message') }}</span>
        </div>
    </div>  


</div>
<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}


            <a href="{{route('inventory')}}">
                {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>
</div>

