<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->integer('usercode')->nullable();
            $table->string('office_eng')->nullable();
            $table->integer('designationcode')->nullable();
            $table->string('designation',500)->nullable();
            $table->string('office',500)->nullable();
            $table->string('is_dept_head',1)->nullable();
            $table->string('is_transferable',1)->nullable();
            $table->date('appointment_date')->nullable();
            $table->string('salary_slab',30)->nullable();
            $table->string('grade_pay',30)->nullable();
            $table->double('basic_pay', 8, 2)->nullable();
            $table->double('personal_salary', 8, 2)->nullable();
            $table->double('special_salary', 8, 2)->nullable();
            $table->double('actual_salary', 8, 2)->nullable();
            $table->double('deputation_allowance', 8, 2)->nullable();
            $table->string('address',1000)->nullable();
            $table->string('maratial_status',1)->nullable();
            $table->string('contact_no',30)->nullable();
            $table->string('pancard',30)->nullable();
            $table->string('gpfnumber',100)->nullable();
            $table->date('date_of_retirement')->nullable();
            $table->date('date_of_transfer')->nullable(); 
            $table->date('date_of_birth')->nullable();
            $table->text('image')->nullable();
            $table->string('sign')->nullable();
            $table->string('current_address',1000)->nullable();
            $table->string('office_phone',30)->nullable();
            $table->string('office_address',1000)->nullable();
            $table->tinyInteger('is_activated')->default('1')->nullable();
            $table->integer('is_profilechange')->nullable();
            $table->text('image_contents')->nullable();
            $table->date('last_login')->nullable();
            $table->string('last_ip',30)->nullable();
            
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
        Schema::dropIfExists('users');
    }
}
