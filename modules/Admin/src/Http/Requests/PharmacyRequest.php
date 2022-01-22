<?php

namespace Modules\Admin\Http\Requests;
 
use Illuminate\Foundation\Http\FormRequest;

use Input; 

class PharmacyRequest  extends FormRequest {

    /**
     * The metric validation rules.
     *
     * @return array    
     */
    public function rules() { 
 
         return [
                    'name'      => 'required|min:3',
                    'zipcode'   => "required", 
                    'email'     => "required|email|unique:users,email"

                ];
    }

    /**
     * The
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

}
