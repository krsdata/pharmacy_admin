<style>
.control-label{font-weight:bold;text-align:left !important;}
</style>
<div class="form-body">
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button> Please fill the required field! </div>
    <!--   <div class="alert alert-success display-hide">
          <button class="close" data-close="alert"></button> Your form validation is successful! </div>
    -->
    <div class="col-md-6">
    <div class="form-group {{ $errors->first('ndc', ' has-error') }}">
        <label class="control-label col-md-3">NDC<span class="required"> * </span></label>
        <div class="col-md-8"> 
            {!! Form::text('name',$boxlist->ndc, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('ndc', ':message') }}</span>
        </div>
    </div>  
    </div>
    <div class="col-md-6">
    <div class="form-group {{ $errors->first('package_size', ' has-error') }}">
        <label class="control-label col-md-3">Package Size<span class="required"> * </span></label>
        <div class="col-md-6"> 
            {!! Form::text('package_size',$boxlist->package_size, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('package_size', ':message') }}</span>
        </div>
    </div>  
    </div>
    <div class="col-md-6">
    <div class="form-group {{ $errors->first('unit_size', ' has-error') }}">
        <label class="control-label col-md-3">Unit Size<span class="required"> * </span></label>
        <div class="col-md-8"> 
            {!! Form::text('unit_size',$boxlist->unit_size, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('unit_size', ':message') }}</span>
        </div>
    </div>  
    </div>
    <div class="col-md-6">
       <div class="form-group {{ $errors->first('class', ' has-error') }}">
        <label class="control-label col-md-3">Class<span class="required"> * </span></label>
        <div class="col-md-4"> 
            {!! Form::text('class',$boxlist->class, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('class', ':message') }}</span>
        </div>
    </div> 
    </div>
    <div class="col-md-6">
    <div class="form-group {{ $errors->first('package_unit', ' has-error') }}">
        <label class="control-label col-md-3">Package Unit<span class="required"> * </span></label>
        <div class="col-md-4"> 
            {!! Form::text('package_unit',$boxlist->unit_size, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('package_unit', ':message') }}</span>
        </div>
    </div> 
    </div>
    <div class="col-md-6">
    <div class="form-group {{ $errors->first('full_value', ' has-error') }}">
        <label class="control-label col-md-3">Full Value<span class="required"> * </span></label>
        <div class="col-md-4"> 
            {!! Form::text('full_value',$boxlist->full_value, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('full_value', ':message') }}</span>
        </div>
    </div> 
    </div>
    <div class="col-md-6">
    <div class="form-group {{ $errors->first('exp_date', ' has-error') }}">
        <label class="control-label col-md-3">Exp Date<span class="required"> * </span></label>
        <div class="col-md-4"> 
            {!! Form::text('exp_date',$boxlist->exp_date, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('exp_date', ':message') }}</span>
        </div>
    </div> 
    </div>
    <div class="col-md-6">
    <div class="form-group {{ $errors->first('total', ' has-error') }}">
        <label class="control-label col-md-3">Total<span class="required"> * </span></label>
        <div class="col-md-4"> 
            {!! Form::text('total',$boxlist->total, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('total', ':message') }}</span>
        </div>
    </div> 
    </div>
    <div class="col-md-6">
    <div class="form-group {{ $errors->first('qty', ' has-error') }}">
        <label class="control-label col-md-3">Quantity<span class="required"> * </span></label>
        <div class="col-md-4"> 
            {!! Form::text('qty',$boxlist->qty, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('qty', ':message') }}</span>
        </div>
    </div> 
    </div>
    <div class="col-md-6">
    <div class="form-group {{ $errors->first('lot', ' has-error') }}">
        <label class="control-label col-md-3">Lot#<span class="required"> * </span></label>
        <div class="col-md-4"> 
            {!! Form::text('lot',$boxlist->lot, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('lot', ':message') }}</span>
        </div>
    </div> 
</div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(' Save ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}


            <a href="{{route('boxList')}}">
                {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>
</div>

