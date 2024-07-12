<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Donation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'users_id', 'donations_id', 'amount',
        'method', 'status'
    ];
    
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function donation() {
        return $this->belongsTo(Donation::class, 'donations_id', 'id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
