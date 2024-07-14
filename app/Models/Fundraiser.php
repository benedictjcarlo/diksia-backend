<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Donation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fundraiser extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'status'
    ];

    public function donation()
    {
        return $this->hasMany(Donation::class);
    }
    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }
}
