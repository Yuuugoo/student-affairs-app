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
        Schema::create('accreditations', function (Blueprint $table) {
            $table->id('accred_no');
            $table->unsignedBigInteger('prepared_by');
            $table->foreign('prepared_by')->references('id')->on('users')->onDelete('cascade');
            $table->string('org_name');
            $table->string('request_for_accred')->nullable();
            $table->json('list_members_officers')->nullable();
            $table->string('const_by_laws')->nullable();
            $table->string('proof_of_acceptance')->nullable();
            $table->string('req_type')->default('Accreditation');
            $table->string('calendar_of_projects')->nullable();
            $table->string('cert_of_grades')->nullable();
            $table->string('stud_enroll_rec')->nullable();
            $table->string('status')->default('pending');
            $table->string('remarks'); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accreditations');
    }
};
