<?php

namespace Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
//use Modules\Admin\Models\AdminLogin;

class AdminLogin extends BaseModel {

    /**
     * The metrics table.
     * 
     * @var string
     */
    protected $table = 'admin';
    protected $guarded = ['created_at' , 'updated_at' , 'id' ];
    protected $fillable = ['email','password','name'];

    // Return user record
    public function getUserDetail($id=null)
    {
        if($id){
            return AdminLogin::find($id); 
        }
        return AdminLogin::all();
    }


}


