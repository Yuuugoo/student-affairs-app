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
        Schema::create('stud_affairs_calendars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prepared_by');
            $table->foreign('prepared_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('org_name_no');
            $table->foreign('org_name_no')->references('accred_no')->on('stud_affairs_accreditations')->onDelete('cascade');
            $table->unsignedBigInteger('act_off_no')->nullable();
            $table->foreign('act_off_no')->references('act_off_no')->on('stud_affairs_requestsactoffs')->onDelete('cascade');
            $table->unsignedBigInteger('act_in_no')->nullable();
            $table->foreign('act_in_no')->references('act_in_no')->on('stud_affairs_requestsactins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stud_affairs_calendars');
    }
};
