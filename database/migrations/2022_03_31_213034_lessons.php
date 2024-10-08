<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Lessons extends Migration
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
            $table->string('lesson_name')->nullable();
            $table->enum('video_type', ['video_url', 'video_upload'])->default('video_url');
            $table->string('url')->nullable();
            $table->string('video')->nullable();
            $table->foreignId('section_id')->constrained('sections')->onDelete('cascade');
            
            $table->string('duration')->nullable();
            $table->string('mcq_url')->nullable();
            $table->string('pdf_attach')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_lecture_free')->nullable()->default(false);
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
        //
    }
}