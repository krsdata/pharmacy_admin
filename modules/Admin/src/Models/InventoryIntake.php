<?php
namespace  Modules\Admin\Models; 

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InventoryIntake extends Model
{
    
     /**
     * The database table used by the model.
     *
     * @var string
     */
    
    protected $table = 'inventory_intake';

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

    protected $fillable = ['inventory_ndc','inventory_qty_type','inventory_qty','inventory_lot','inventory_exp_date']; 
    /*--User--*/
    // public function user() 
    // {
    //     return $this->belongsTo('Modules\Admin\Models\User','role','id');
    // }
    /*--Syllabus--*/
    

}
