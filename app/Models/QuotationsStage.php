<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationsStage extends Model
{
    use HasFactory;

    protected $table = 'quotations_stages';
    protected $fillable = ['order', 'label', 'color', 'is_default'];
}
