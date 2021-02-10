<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lessons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('post');
            $table->foreign('post')->references('id')->on('posts')->onDelete('cascade');
            $table->integer('number')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->enum('media', ['audio', 'video'])->default('video');
            $table->text('description');
            $table->string('picture')->nullable();
            $table->string('url')->nullable();
            $table->string('duration')->nullable();
            $table->enum('cach', ['free', 'money'])->default('free');
            $table->integer('views')->default(0);
            $table->integer('show')->default(1);
            $table->timestamps();
        });
        Schema::create('lessons_metas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lesson_id');
            $table->foreign('lesson_id')->references('id')->on('lessons')->onDelete('cascade');
            $table->string('meta_key');
            $table->string('meta_value');
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
        Schema::dropIfExists('lessons');
    }
}
