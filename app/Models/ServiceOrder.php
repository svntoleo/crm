<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'number','user_id','customer_id','assigned_to','stage_id',
        'title','notes','total','position','scheduled_datetime'
    ];

    protected $casts = [
        'scheduled_datetime' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function stage()
    {
        return $this->belongsTo(ServiceOrdersStage::class, 'stage_id');
    }

    public function items()
    {
        return $this->hasMany(ServiceOrderItem::class);
    }
}
