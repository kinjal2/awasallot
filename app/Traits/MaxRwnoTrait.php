<?php

namespace App\Traits;

// trait MaxRwnoTrait
// {
//     public static function getMaxRwno($quartertype)
//     {
//         return static::where('is_priority', 'N')
//             ->where('quartertype', $quartertype)
//             ->whereNotNull('wno')
//             ->max('r_wno');
//     }
// }


trait MaxRwnoTrait
{
    public static function getMaxRwno($quartertype)
    {
        
        return static::where('is_priority', 'N')
            ->where('quartertype', $quartertype)
            ->whereNotNull('wno')
            ->max('r_wno');
    }
}
