<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MQtCategoryAreaMapping extends Model
{
    use HasFactory;
    protected $table ='master.m_qt_category_area_mapping';
   
     protected $fillable = [
        'officecode',
        'quartertype',
         'areacode',
         
    ];
    public function area()
    {
        return $this->belongsTo(Area::class, 'areacode', 'areacode');
    }
}
