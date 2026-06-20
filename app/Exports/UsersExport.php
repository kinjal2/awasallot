<?php

namespace App\Exports;

use App\User; // ✅ your project uses this
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromQuery, WithHeadings
{
    public function query()
    {
        // ✅ NEVER use User::all() (causes 500 error)
        return User::select('id', 'name', 'email','contact_no');
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Email','Contact no'];
    }
}