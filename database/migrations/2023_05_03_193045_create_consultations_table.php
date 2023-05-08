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
        Schema::create('consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->unsignedBigInteger('mrid');
            $table->string('mrn', 25)->unique();
            $table->unsignedBigInteger('branch_id')->references('id')->on('branches');
            $table->unsignedBigInteger('purpose_of_visit')->references('id')->on('consultation_types');
            $table->unsignedBigInteger('doctor_id')->references('id')->on('users');
            $table->decimal('doctor_fee', 7, 2)->default(0.00);
            $table->unsignedBigInteger('doctor_fee_payment_method')->references('id')->on('payment_modes')->nullable();
            $table->unsignedBigInteger('appointment_id')->references('id')->on('appointments')->nullable();
            $table->string('coupon_code', 25)->nullable();
            $table->boolean('advised_cataract_surgery')->comment('1-yes,0-no')->nullable();
            $table->boolean('surgery_urgent')->comment('1-yes,0-no')->nullable();
            $table->date('surgery_advised_on')->nullable();
            $table->boolean('status')->comment('0-active,1-cancelled')->default(0);
            $table->unsignedBigInteger('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->references('id')->on('users');
            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consultations');
    }
};
