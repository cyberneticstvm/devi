<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Consultation extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function status(){
        return ($this->deleted_at) ? "<span class='badge badge-danger'>Deleted</span>" : "<span class='badge badge-success'>Active</span>";
    }

    public function patient(){
        return $this->belongsTo(Patient::class, 'patient_id', 'id')->withTrashed();
    }

    public function doctor(){
        return $this->belongsTo(Doctor::class, 'doctor_id', 'id')->withTrashed();
    }
}
