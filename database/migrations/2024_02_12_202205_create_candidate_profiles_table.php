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
        Schema::create('candidate_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('profileImg');
            $table->string('firstName');
            $table->string('lastName');
            $table->string('fatherName');
            $table->string('motherName');
            $table->date('dob');
            $table->string('address');
            $table->string('contact');
            $table->string('emergencyContact');
            $table->string('personalWebsite');
            $table->string('whatsapp');
            $table->string('linkedin');
            $table->string('github');
            $table->string('behance');
            $table->string('dribble');
            $table->string('twitter');
            $table->string('slack');
            $table->string('nid')->unique();
            $table->string('passport')->unique();
            $table->enum('bloodGroup', ['A+', 'A-', 'AB+', 'AB-', 'B+', 'B-', 'O+', 'O-']);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_profiles');
    }
};
