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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('logo');
            $table->text('description');
            $table->string('address');
            $table->string('contact')->unique();
            $table->string('email')->unique();
            $table->string('website')->unique()->nullable();
            $table->date('establishDate');
            $table->enum('status', ['PENDING', 'ACTIVE', 'INACTIVE', 'RESTRICTED']);
            $table->unsignedInteger('jobsPosted')->default(0);
            $table->text('restrictionFeedback')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
