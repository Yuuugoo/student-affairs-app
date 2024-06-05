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
        Schema::create('stud_affairs_reaccreditations', function (Blueprint $table) {
            $table->id('reaccred_no');
            $table->unsignedBigInteger('prepared_by');
            $table->foreign('prepared_by')->references('id')->on('users');
            $table->unsignedBigInteger('org_name_no');
            $table->foreign('org_name_no')->references('accred_no')->on('stud_affairs_accreditations')->onDelete('cascade');
            $table->string('req_type')->default('Reaccreditation');
            $table->string('request_for_accred')->nullable();
            $table->json('list_members_officers');
            $table->string('const_by_laws')->nullable();
            $table->string('proof_of_acceptance')->nullable();
            $table->string('calendar_of_projects')->nullable();
            $table->string('cert_of_grades')->nullable();
            $table->string('stud_enroll_rec')->nullable();
            $table->string('status')->default('pending');  
            $table->json('remarks')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stud_affairs_reaccreditations');
    }
};
