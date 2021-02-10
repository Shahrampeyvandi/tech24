<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->string('fname');
            $table->string('lname');
            $table->string('email')->nullable()->unique();
            $table->string('mobile')->unique();
            $table->string('avatar')->nullable();
            $table->string('username')->unique();
            $table->string('password');
            $table->string('google_id')->nullable();
            $table->string('age')->nullable();
            $table->enum('group', ['student', 'teacher'])->default('student');
            $table->boolean('active')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });
       

       DB::table('users')->insert(
            array(
                'fname'=>'admin',
                'lname'=>'admin',
                'avatar'=>null,
                'mobile'=>'09381699949',
                'username'=>'admin',
                'password'=>Hash::make('123456'),
                'email'=>'test@gmail.com',
                'remember_token'=>null

                )
        );
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
