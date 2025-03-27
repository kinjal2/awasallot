<?php 

namespace App;

use Illuminate\Database\Eloquent\Model;

class MQuarter extends Model
{
    protected $table = 'master.m_quarters'; // Specify the table name if it's not the plural form
    protected $primaryKey = ['officecode', 'building_no']; // Define composite primary key (if applicable)

    public $incrementing = false; // Because we are using a composite primary key, Laravel doesn't automatically handle increments.

    public function area()
    {
        return $this->belongsTo(MArea::class, 'areacode', 'areacode');
    }
}
