<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'gstin',
        'address',
        'email',
        'mobile',
        'invoice_starts_with',
        'created_by',
        'updated_by',
    ];
}
