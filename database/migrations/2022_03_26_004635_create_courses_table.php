<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->enum('type', ['universities', "high_school", "public", 'public_medicine'])->default("public");
            $table->float('price')->nullable();
            $table->float('price_en')->nullable();
            $table->float('price_ar')->nullable();
            $table->float('discount_en')->nullable()->default(0);
            $table->float('discount_ar')->nullable()->default(0);

            $table->unsignedBigInteger('semester_id')->nullable();
            $table->foreign('semester_id')->references('id')->on('semesters')->onDelete('cascade');
            
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('module_id')->nullable()->constrained('modules');
            $table->integer('is_archived')->default(0);
            $table->boolean('free')->default(false);
            $table->string('rate')->default(0);
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
        Schema::dropIfExists('courses');
    }
}