<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFileListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('master.Filelist', function (Blueprint $table) {
            $table->integer('request_id')->nullable()->after('bk_doc_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('master.Filelist', function (Blueprint $table) {
            $table->dropColumn(['request_id']);
        });
    }
}
