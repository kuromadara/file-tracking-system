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
        Schema::create('file_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')->constrained()->onDelete('cascade');
            $table->foreignId('from_fixed_asset_id')->nullable()->constrained('fixed_assets')->onDelete('set null');
            $table->foreignId('to_fixed_asset_id')->constrained('fixed_assets')->onDelete('cascade');
            $table->foreignId('moved_by_user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('moved_at');
            $table->text('notes')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_movements');
    }
};
