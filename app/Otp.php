<?php

// app/Models/Otp.php
namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Otp extends Model
{
    use HasFactory;

    protected $table = 'userschema.otps';  // Specify schema if needed

    protected $fillable = [
        'user_id', 
        'mobile_no', 
        'otp', 
        'created_at', 
        'updated_at', 
        'attempts', 
        'blocked_until', 
        'expires_at',
    ];

    // Set the timestamp fields to true
    public $timestamps = true;
}
