<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'gender',
        'place',
        'mobile',
        'doctor_id',
        'branch_id',
        'appointment_date',
        'appointment_time',
        'created_by',
        'updated_by',
    ];

    public function doctor(){
        return $this->hasOne(User::class, 'id', 'doctor_id');
    }

    protected $casts = ['appointment_time' => 'datetime'];
}
