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
        Schema::create('calendars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('prepared_by');
            $table->foreign('prepared_by')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('org_name_no');
            $table->foreign('org_name_no')->references('accred_no')->on('accreditations')->onDelete('cascade');
            $table->unsignedBigInteger('act_off_id')->nullable();
            $table->foreign('act_off_id')->references('id')->on('requests_act_offs')->onDelete('cascade');
            $table->unsignedBigInteger('act_in_id')->nullable();
            $table->foreign('act_in_id')->references('id')->on('requests_act_ins')->onDelete('cascade');
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};
