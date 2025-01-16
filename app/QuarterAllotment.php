<?php 
namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuarterAllotment extends Model
{
    use HasFactory;

    // Define the table name (if it's not the plural of the model name)
    protected $table = 'master.t_quarter_allotment';

    // Define the primary key (if it's not the default 'id')
    protected $primaryKey = 'qaid';

    // Specify if the primary key is not auto-incrementing
    public $incrementing = false;

    // Define the fillable attributes to protect against mass-assignment vulnerabilities
    protected $fillable = [
        'officecode', 'requestid', 'rivision_id', 'uid', 'request_type', 
        'areacode', 'quartertype', 'block_no', 'unitno', 'building_no', 
        'renttypeid', 'isoccupied', 'pancard', 'occupancy_date', 'vacant_date',
        'updatedby', 'approved_by', 'updatedon', 'approved_on', 'allotment_date', 
        'allotment_order_no'
    ];

    // Define the relationship with the RentType model
    public function rentType()
    {
        return $this->belongsTo(RentType::class, 'renttypeid', 'renttypeid');
    }

    // Define the relationship with the Area model
    public function area()
    {
        return $this->belongsTo(Area::class, 'areacode', 'areacode');
    }

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class, 'uid', 'id');
    }

    // Optionally define custom logic for vacancy updates (e.g., triggering actions when the quarter is vacated)
    public static function boot()
    {
        parent::boot();

        static::deleting(function ($quarter) {
            // Call some function, e.g., to handle vacancy logic
            // Example: $quarter->vacate();
        });
    }
}
