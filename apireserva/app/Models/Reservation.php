<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reservations';

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
                  'reservation_date',
                  'detail',
                  'patient_id',
                  'clinic_id'
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
     * Get the Patient for this model.
     *
     * @return App\Models\Patient
     */
    public function Patient()
    {
        return $this->belongsTo('App\Models\Patient','patient_id','id');
    }

    /**
     * Get the Clinic for this model.
     *
     * @return App\Models\Clinic
     */
    public function Clinic()
    {
        return $this->belongsTo('App\Models\Clinic','clinic_id','id');
    }

    /**
     * Get the horary for this model.
     *
     * @return App\Models\Horary
     */
    public function horary()
    {
        return $this->hasOne('App\Models\Horary','reservation_id','id');
    }


}
