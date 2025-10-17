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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unique();
            $table->integer('company_id');
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->string('employee_number')->nullable();
            $table->date('joined_at')->nullable();
            $table->date('left_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['user_id', 'company_id']);
            $table->index('company_id');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('company_id')->references('id')->on('companies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
