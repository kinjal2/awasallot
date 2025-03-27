<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Documenttype extends Model
{
    //
    protected $table ='master.m_document_type';
    protected $primaryKey='document_type';
    public function user()
    {
        return $this->belongsTo(User::class); // Assuming Document_type belongs to User
    }
}
