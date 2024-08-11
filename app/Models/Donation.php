<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Fundraiser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'donationAmount', 'donationNeed', 'deadline',
        'description', 'donationList', 'picturePath',
        'types', 'fundraiser_id'
    ];

    protected $casts = [
        'news' => 'string'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }

    public function fundraisers()
    {
        return $this->belongsTo(Fundraiser::class, 'fundraiser_id');
    }

    public function getCreatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function getUpdatedAtAttribute($value){
        return Carbon::parse($value)->timestamp;
    }

    public function toArray()
    {
        $toArray = parent::toArray();
        $toArray['picturePath'] = $this->picturePath;
        return $toArray;
    }

    public function getPicturePathAttribute(){
        return url('') . Storage::url($this->attributes['picturePath']);
    }

    public function fundraiser() {
        return $this->hasOne(Fundraiser::class, 'id', 'fundraiser_id');
    }
}