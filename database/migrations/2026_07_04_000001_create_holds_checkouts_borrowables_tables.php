<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Hold = penangguhan buku fisik (mirip reservasi tapi untuk OfflineBookCopy)
        Schema::create('holds', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('reading_spot_id')->constrained()->cascadeOnDelete();
            $t->timestamp('hold_at')->useCurrent();
            $t->timestamp('expires_at')->nullable();
            $t->enum('status', ['active', 'fulfilled', 'cancelled', 'expired'])->default('active');
            $t->text('notes')->nullable();
            $t->timestamps();
            $t->index(['user_id', 'status']);
        });

        // Checkout = peminjaman buku fisik
        Schema::create('checkouts', function (Blueprint $t) {
            $t->id();
            $t->string('code', 20)->unique();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('reading_spot_id')->constrained()->cascadeOnDelete();
            $t->foreignId('staff_id')->nullable()->constrained('users')->nullOnDelete();
            $t->timestamp('start_time')->useCurrent();
            $t->timestamp('end_time')->comment('Jatuh tempo');
            $t->timestamp('return_time')->nullable()->comment('Waktu pengembalian aktual');
            $t->boolean('is_returned')->default(false);
            $t->unsignedInteger('fine_amount')->default(0);
            $t->text('notes')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['user_id', 'is_returned']);
            $t->index(['reading_spot_id', 'is_returned']);
        });

        // Borrowable = polymorphic pivot untuk Hold/Checkout ke OfflineBookCopy
        Schema::create('borrowables', function (Blueprint $t) {
            $t->id();
            $t->morphs('borrowable', 'borrowable_idx'); // borrowable_type, borrowable_id (Hold or Checkout)
            $t->foreignId('offline_book_copy_id')->constrained()->cascadeOnDelete();
            $t->timestamps();
            $t->index('offline_book_copy_id');
        });

        // Borrowing history (read-only log untuk analitik)
        Schema::create('borrowing_histories', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('offline_book_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('reading_spot_id')->nullable()->constrained()->nullOnDelete();
            $t->date('borrowed_at');
            $t->date('returned_at')->nullable();
            $t->unsignedInteger('days_borrowed')->default(0);
            $t->unsignedInteger('fine_amount')->default(0);
            $t->timestamps();
            $t->index(['user_id', 'borrowed_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('borrowing_histories');
        Schema::dropIfExists('borrowables');
        Schema::dropIfExists('checkouts');
        Schema::dropIfExists('holds');
    }
};
