<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TQuarterRequestaView extends Model
{
    use HasFactory;
    use HasFactory;protected $table = 'public.v_tquarterrequestauserdetails';
    protected $primaryKey = 'id'; // Adjust if your view has a different primary key
    public $incrementing = false; // Adjust if your view uses non-incrementing primary key
}
