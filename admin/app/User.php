<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
//Namespace configuration for morpic relation map

Relation::morphMap([
    'Admin'=>'Api\v1\User\Models\Admin',
]);
class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'dob',
        'mobile',
        'password',
        'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = ['age'];

    /**
     * Set the Hash  Password When create a new user  .
     *
     * @param  string  $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }


    public static function boot()
    {
        parent::boot();
        static::creating(function(){
            //you can save any field value on inserting data into a table
            //for example $model->created_by=Auth::user()->id
        });

        static::updating(function(){
            //you can save any field value on updating data into a table
            //for example $model->updated_by=Auth::user()->id
        });

        static::deleting(function($user){
            $user->tokens()->delete();
        });
    }



    public function userable()
    {
        return $this->morphTo();
    }

    public function getAgeAttribute(){

        $date1 = $this->dob;
        $date2 = date("Y-m-d");
        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
        return $years.'.'.$months ;
    }

    // public function getImageFileAttribute(){
    //     return $this->image ;
    // }
}
