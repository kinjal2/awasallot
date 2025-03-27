<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;

    // Specify the table name (if it differs from the plural form of the model name)
    protected $table = 'master.districts';

    // Disable automatic timestamping if not needed (since your table doesn't have created_at/updated_at)
    public $timestamps = false;

    // Define the primary key
    protected $primaryKey = 'dcode';

    // Specify the fillable attributes
    protected $fillable = [
        'dcode',
        'name_g',
        'name_e',
        'zone_id',
        'state_code',
    ];
}
