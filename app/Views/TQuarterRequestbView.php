<?php

namespace App\Views;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TQuarterRequestbView extends Model
{
    use HasFactory;
    use HasFactory;protected $table = 'public.tquarter_requestb_view';
    protected $primaryKey = 'id'; // Adjust if your view has a different primary key
    public $incrementing = false; // Adjust if your view uses non-incrementing primary key
}
