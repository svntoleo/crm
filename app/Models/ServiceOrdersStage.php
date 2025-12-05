<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceOrdersStage extends Model
{
    use HasFactory;

    protected $table = 'service_orders_stages';
    protected $fillable = ['order', 'label', 'color', 'is_default'];
}
