<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Horary extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'horaries';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
//    public $incrementing = false;


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'reservation_id',
                  'doctor_id'
              ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * Get the Reservation for this model.
     *
     * @return App\Models\Reservation
     */
    public function Reservation()
    {
        return $this->belongsTo('App\Models\Reservation','reservation_id','id');
    }

    /**
     * Get the Doctor for this model.
     *
     * @return App\Models\Doctor
     */
    public function Doctor()
    {
        return $this->belongsTo('App\Models\Doctor','doctor_id','id');
    }




}
