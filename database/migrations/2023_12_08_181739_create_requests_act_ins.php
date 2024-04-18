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
        Schema::create('requests_act_ins', function (Blueprint $table) {
            $table->id('act_in_no');
            $table->unsignedBigInteger('prepared_by');
            $table->string('req_type')->default('Activity In-Campus');  
            $table->foreign('prepared_by')->references('id')->on('users');
            $table->unsignedBigInteger('org_name_no');
            $table->foreign('org_name_no')->references('accred_no')->on('accreditations')->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->string('csw');
            $table->string('title');
            $table->string('venues');
            $table->bigInteger('participants_no');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests_act_in');
    }
};
