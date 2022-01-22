<?php
namespace  Modules\Admin\Models; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PharmacyList extends Model
{
    
     /**
     * The database table used by the model.
     *
     * @var string
     */
    
    protected $table = 'pharmacy_list';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     /**
     * The primary key used by the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';
 
    protected $guarded = ['created_at' , 'updated_at' , 'id' ];

    protected $fillable = [
                    'name',
                    'contact',
                    'phone',
                    'dba_name',
                    'address',
                    'city',
                    'state',
                    'zipcode',
                    'fax_number',
                    'mobile_number',
                    'email',
                    'state_license_number',
                    'state_license_exp',
                    'dea_license_number',
                    'dea_license_exp'
               ]; 
    
    

}
