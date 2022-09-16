<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

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
                  'email',
                  'email_verified_at',
                  'password',
                  'remember_token',
                  'rol_id'
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
     * Get the Rol for this model.
     *
     * @return App\Models\Rol
     */
    public function Rol()
    {
        return $this->belongsTo('App\Models\Rol','rol_id','id');
    }

    /**
     * Get the doctor for this model.
     *
     * @return App\Models\Doctor
     */
    public function doctor()
    {
        return $this->hasOne('App\Models\Doctor','users_id','id');
    }

    /**
     * Get the patient for this model.
     *
     * @return App\Models\Patient
     */
    public function patient()
    {
        return $this->hasOne('App\Models\Patient','users_id','id');
    }

}
