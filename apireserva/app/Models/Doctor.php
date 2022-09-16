<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
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
    protected $table = 'doctors';

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
                  'lastname',
                  'phone',
                  'turn',
                  'specialty_id',
                  'users_id',
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
     * Get the Specialty for this model.
     *
     * @return App\Models\Specialty
     */
    public function Specialty()
    {
        return $this->belongsTo('App\Models\Specialty','specialty_id','id');
    }

    /**
     * Get the User for this model.
     *
     * @return App\Models\User
     */
    public function User()
    {
        return $this->belongsTo('App\Models\User','users_id','id');
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
        return $this->hasOne('App\Models\Horary','doctor_id','id');
    }



}
