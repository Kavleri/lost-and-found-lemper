<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('item_code', 20)->unique()->nullable();
            $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('reporter_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('finder_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('name', 100);
            $table->text('description');
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('location_found', 100)->nullable();
            $table->string('location_lost', 100)->nullable();
            $table->date('date_found')->nullable();
            $table->date('date_lost')->nullable();
            $table->timestamp('date_reported')->useCurrent();
            $table->enum('status', ['hilang', 'ditemukan', 'diklaim', 'selesai', 'expired'])->default('hilang');
            $table->boolean('is_confidential')->default(false);
            $table->text('hidden_details')->nullable();
            $table->string('drop_off_location', 100)->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
