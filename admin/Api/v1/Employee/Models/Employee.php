<?php

namespace Api\v1\Employee\Models;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'basic_salary',
        'house_rent',
        'medical',
        'tax'
    ];
    protected $appends = ['monthlysalary'];

    public function getMonthlySalaryAttribute(){

        return $this->basic_salary+$this->house_rent+$this->medical;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($model){
            $model->basic_salary = $model->basic_salary - ($model->basic_salary * $model->tax)/100;
            //you can save any field value on inserting data into a table
            //for example $model->created_by=Auth::user()->id
        });

        static::updating(function($model){
            //you can save any field value on updating data into a table
            //for example $model->updated_by=Auth::user()->id
        });
    }
}
