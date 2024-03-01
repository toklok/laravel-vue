<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedCalculations extends Model
{
    use HasFactory;

    protected $fillable = ['actual_calculation', 'name', 'inputs'];
}
