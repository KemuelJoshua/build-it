<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakDown extends Model
{
    use HasFactory;
    protected $table = 'breakdowns';
    protected $fillable = [
        'budget',
        'sqm',
        'created_at',
        'updated_at',
    ];
}
