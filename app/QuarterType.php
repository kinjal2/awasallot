<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Tquarterrequesta;
use App\Tquarterrequestb;
class QuarterType extends Model
{
    //
    protected $table = 'master.m_quarter_type';
    // Define the fillable properties
    
     protected $primaryKey = ['officecode', 'quartertype'];
    //protected $primaryKey = 'officecode';

    // Indicate that the primary key is not an auto-incrementing integer
     public $incrementing = false;

    // Specify that the key type is string (if applicable)
     protected $keyType = 'string'; // or 'int', based on your keys

    // Override getKey method
    public function getKey()
    {
        return [$this->key1, $this->key2];
    }

    // Override getKeyName method
    public function getKeyName()
    {
        return $this->primaryKey;
    }
    public $timestamps = false;
    protected $fillable = [
        'officecode',
        'quartertype',
        'quartertype_g',
        'bpay_from',
        'bpay_to',
        'rent_normal',
        'rent_standard',
        'rent_economical',
        'rent_market',
        'remarks',
        'updatedby',
        'updatedon',
        'priority',
        'created_at',
    ];
    public function requestsA()
{
    return $this->hasMany(Tquarterrequesta::class, 'quartertype', 'quartertype');
}

public function requestsB()
{
    return $this->hasMany(Tquarterrequestb::class, 'quartertype', 'quartertype');
}
public function calculateDgWno($dg_quartertype,$officecode)
{
    // Fetch the last Wno for each type of request and prioritize them
    $dg_last_wno = self::with(['requestsA' => function ($query) {
        $query->whereNotNull('wno')->where('IsPriority', 'N')->orderByDesc('wno')->take(1);
    }, 'requestsB' => function ($query) {
        $query->whereNotNull('wno')->where('IsPriority', 'N')->orderByDesc('wno')->take(1);
    }])
        ->where('quartertype', $dg_quartertype)
        ->where('officecode', '=', $officecode)
        ->first();

    // Check if $dg_last_wno is null
    if (!$dg_last_wno) {
        return 1; // Return a default value or handle the null case as appropriate
    }

    // Determine the maximum Wno
    if ($dg_last_wno->requestsA->isEmpty() && $dg_last_wno->requestsB->isEmpty()) {
        $dg_last_wno_value = 0;
    } else {
        $dg_last_wno_value = max(
            $dg_last_wno->requestsA->isNotEmpty() ? $dg_last_wno->requestsA->first()->wno : 0,
            $dg_last_wno->requestsB->isNotEmpty() ? $dg_last_wno->requestsB->first()->wno : 0
        );
    }

    return $dg_last_wno_value + 1;
}
public  function getNextWno($quartertype,$officecode)
    {
        $lastWnoA = Tquarterrequesta::where('quartertype', $quartertype)
            ->where('is_priority', 'N')
            ->where('officecode', '=', $officecode)
            ->whereNotNull('wno')
            ->max('wno');

        $lastWnoB = Tquarterrequestb::where('quartertype', $quartertype)
            ->where('is_priority', 'N')
            ->where('officecode', '=', $officecode)
            ->whereNotNull('wno')
            ->max('wno');

        return max($lastWnoA ?? 0, $lastWnoB ?? 0) + 1;
    }
public function getNextRWno($q,$officecode)
{
    $maxObj = Tquarterrequesta::where('quartertype', $q)
    ->where('is_priority', 'N')
    ->where('officecode', '=', $officecode)
    ->whereNotNull('wno')
    ->whereNotNull('r_wno')
    ->orderByDesc('r_wno')
    ->limit(1)
    ->first();

$maxObj1 = Tquarterrequestb::where('quartertype', $q)
    ->where('is_priority', 'N')
    ->where('officecode', '=', $officecode)
    ->whereNotNull('wno')
    ->whereNotNull('r_wno')
    ->orderByDesc('r_wno')
    ->limit(1)
    ->first();

$maxRwnoA = $maxObj ? $maxObj->r_wno : null;
$maxRwnoB = $maxObj1 ? $maxObj1->r_wno : null;

$lastWno = max($maxRwnoA, $maxRwnoB) ?? 0;
$wno = $lastWno + 1;
return $wno;

}
}
