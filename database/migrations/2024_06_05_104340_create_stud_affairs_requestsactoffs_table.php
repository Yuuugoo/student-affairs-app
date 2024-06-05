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
        Schema::create('stud_affairs_requestsactoffs', function (Blueprint $table) {
            $table->id('act_off_no');
            $table->string('req_type')->default('Activity Off-Campus');  
            $table->unsignedBigInteger('prepared_by');
            $table->unsignedBigInteger('org_name_no');
            $table->foreign('org_name_no')->references('accred_no')->on('stud_affairs_accreditations')->onDelete('cascade');
            $table->string('status')->default('pending');
            $table->string('csw');
            $table->foreign('prepared_by')->references('id')->on('users');
            $table->string('title');
            $table->string('venues');
            $table->bigInteger('participants_no');
            $table->bigInteger('max_capacity');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->json('remarks')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stud_affairs_requestsactoffs');
    }
};
