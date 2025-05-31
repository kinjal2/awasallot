<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    //
    protected $table = 'master.m_area';
    protected $fillable = [
        'areaname', 'address', 'address_g','officecode'
    ];
    protected $primaryKey = 'areacode';

    public $incrementing = true;

    protected $keyType = 'int';

    public function categoryAreaMappings()
    {
        return $this->hasMany(MQtCategoryAreaMapping::class, 'areacode', 'areacode');
    }
}
