<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('master.Filelist', function (Blueprint $table) {
            $table->id();
            $table->integer('uid');
            $table->string('file_name');
            $table->string('rev_id');
            $table->string('mimetype');
            $table->string('doc_id');
            $table->string('performa',1);
            $table->integer('document_id');
            $table->integer('rivision_id');
            $table->integer('request_id');
            $table->integer('bk_doc_id')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('master.Filelist');
    }
}
