<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'clinics';

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
                  'name',
                  'address',
                  'phone',
                  'image'
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
     * Get the doctor for this model.
     *
     * @return App\Models\Doctor
     */
    public function doctor()
    {
        return $this->hasOne('App\Models\Doctor','clinic_id','id');
    }

    /**
     * Get the reservation for this model.
     *
     * @return App\Models\Reservation
     */
    public function reservation()
    {
        return $this->hasOne('App\Models\Reservation','clinic_id','id');
    }



}
