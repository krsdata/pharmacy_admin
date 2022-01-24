<div class="col-md-12" style="background:#f4f4f4; padding: 20px;">
    <div class="alert alert-danger display-hide">
        <button class="close" data-close="alert"></button> Please fill the required field! </div>
   
    <div class="col-md-6">
    <div class="form-group {{ $errors->first('ndc', ' has-error') }}">
        <label class="control-label col-md-3">NDC#<span class="required"> * </span></label>
        <div class="col-md-6"> 
            {!! Form::text('ndc',$inventoryIntake->ndc, ['class' => 'form-control','data-required'=>1])  !!} 
            <span>Please scan or enter the NDC # of the item you want to return</span>
            <span class="help-block">{{ $errors->first('ndc', ':message') }}</span>
        </div>
    </div>  

    <div class="form-group {{ $errors->first('qty_type', ' has-error') }}">
        <label class="control-label col-md-3">Quantity Type</label>
        <div class="col-md-6"> 
             
                     <select class="form-control">
                         <option value="full">Full</option>
                         <option value="partial">Partial</option>
                     </select>
        </div>
    </div>  

    <div class="form-group {{ $errors->first('qty', ' has-error') }}">
        <label class="control-label col-md-3">Quantity<span class="required"> * </span></label>
        <div class="col-md-6"> 
            {!! Form::text('qty',$inventoryIntake->qty, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('qty', ':message') }}</span>
        </div>
    </div> 
    </div> 
     <div class="col-md-6">
    <div class="form-group {{ $errors->first('lot', ' has-error') }}">
        <label class="control-label col-md-3">Lot#<span class="required"> * </span></label>
        <div class="col-md-6"> 
            {!! Form::text('lot',$inventoryIntake->lot, ['class' => 'form-control','data-required'=>1])  !!} 

            <span class="help-block">{{ $errors->first('lot', ':message') }}</span>
        </div>
    </div>

    <div class="form-group {{ $errors->first('exp_date', ' has-error') }}">
        <label class="control-label col-md-3">Exp Date<span class="required"> * </span></label>
        <div class="col-md-6"> 
            {!! Form::date('exp_date',$inventoryIntake->exp_date, ['class' => 'form-control','data-required'=>1,'placeholder'=>'mm/dd/yyyy'])  !!} 

            <span class="help-block">{{ $errors->first('exp_date', ':message') }}</span>
        </div>
    </div>
</div>



<div class="form-actions">
    <div class="row">
        <div class="col-md-offset-3 col-md-9">
            {!! Form::submit(' Return Item ', ['class'=>'btn  btn-primary text-white','id'=>'saveBtn']) !!}


            <a href="{{url('admin/inventory-return')}}">
                {!! Form::button('Back', ['class'=>'btn btn-warning text-white']) !!} </a>
        </div>
    </div>
</div>
</div>



