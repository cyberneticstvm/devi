<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'mrn',
        'branch_id',
        'purpose_of_visit',
        'doctor_id',
        'doctor_fee',
        'doctor_fee_payment_method',
        'appointment_id',
        'coupon_code',
        'advised_cataract_surgery',
        'surgery_urgent',
        'surgery_advised_on',
        'status',
        'created_by',
        'updated_by',
    ];

    public function patient(){
        return $this->belongsTo(Patient::class, 'patient_id', 'id');
    }

    public function doctor(){
        return $this->belongsTo(User::class, 'doctor_id', 'id');
    }

    public function visitpurpose(){
        return $this->belongsTo(ConsultationType::class, 'purpose_of_visit', 'id');
    }

    protected $casts = ['surgery_advised_on' => 'date'];
}
