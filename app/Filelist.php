<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Filelist extends Model
{

    use HasFactory;
    protected $table ='master.file_list';
   // protected $fillable = ['uid','file_name','rev_id','mimetype','doc_id','document_id','request_id'];

   protected $primaryKey = 'id';
   public $incrementing = true;
     // Define the fillable attributes
     protected $fillable = [
        'uid',
        'file_name',
         'rev_id',
         'mimetype',
         'doc_id',
         'performa',
         'document_id',
         'rivision_id',
        // 'bk_doc_id',
         'request_id',
         'is_file_ddo_verified',
         'is_file_admin_verified',
    ];
    public function user()
    {
      //  return $this->belongsTo('App\User', 'id', 'uid');
    }
}

