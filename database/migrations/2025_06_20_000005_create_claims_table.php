<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('lost_id')->nullable()->constrained('lost_items');
            $table->foreignId('found_id')->constrained('found_items');
            $table->text('proof_details');
            $table->enum('status', ['Pending', 'Approved', 'Rejected']);
            $table->timestamp('claim_date')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
