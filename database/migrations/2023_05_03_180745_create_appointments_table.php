<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125);
            $table->integer('age')->default(0);
            $table->string('gender', 25)->nullable();
            $table->string('place', 125)->nullable();
            $table->string('mobile', 10)->nullable();
            $table->unsignedBigInteger('doctor_id')->references('id')->on('users');
            $table->date('appointment_date')->nullable();
            $table->time('appointment_time')->nullable();
            $table->unsignedBigInteger('branch_id')->references('id')->on('branches');
            $table->unsignedBigInteger('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
