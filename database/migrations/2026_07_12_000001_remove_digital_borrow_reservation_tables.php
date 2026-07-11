<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // Denda sekarang mengikuti peminjaman fisik (Checkout), bukan lagi
        // transaksi peminjaman buku digital yang dihapus.
        Schema::table('fines', function (Blueprint $t) {
            $t->dropForeign(['member_id']);
            $t->dropForeign(['borrow_transaction_id']);
            $t->dropIndex(['member_id', 'status']);
            $t->dropColumn(['member_id', 'borrow_transaction_id']);
            $t->foreignId('user_id')->nullable()->after('id')->constrained()->nullOnDelete();
            $t->foreignId('checkout_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $t->index(['user_id', 'status']);
        });

        // return_transactions & reservations bergantung pada borrow_transactions
        // (FK), jadi harus dihapus lebih dulu sebelum borrow_transactions.
        Schema::dropIfExists('return_transactions');
        Schema::dropIfExists('reservations');
        Schema::dropIfExists('borrow_transactions');
    }

    public function down(): void {
        Schema::create('borrow_transactions', function (Blueprint $t) {
            $t->id();
            $t->string('code', 20)->unique();
            $t->foreignId('member_id')->constrained()->cascadeOnDelete();
            $t->foreignId('book_id')->constrained()->cascadeOnDelete();
            $t->foreignId('staff_id')->nullable()->constrained('users')->nullOnDelete();
            $t->date('borrowed_at');
            $t->date('due_at');
            $t->date('returned_at')->nullable();
            $t->enum('status', ['active', 'returned', 'overdue', 'lost', 'damaged'])->default('active');
            $t->unsignedTinyInteger('renew_count')->default(0);
            $t->text('notes')->nullable();
            $t->timestamps();
            $t->index(['member_id', 'status']);
            $t->index(['due_at', 'status']);
        });
        Schema::create('reservations', function (Blueprint $t) {
            $t->id();
            $t->foreignId('member_id')->constrained()->cascadeOnDelete();
            $t->foreignId('book_id')->constrained()->cascadeOnDelete();
            $t->timestamp('reserved_at')->useCurrent();
            $t->timestamp('expires_at')->nullable();
            $t->unsignedSmallInteger('queue_position')->default(1);
            $t->enum('status', ['pending', 'ready', 'fulfilled', 'cancelled', 'expired'])->default('pending');
            $t->text('notes')->nullable();
            $t->timestamps();
            $t->index(['book_id', 'status', 'queue_position']);
        });
        Schema::create('return_transactions', function (Blueprint $t) {
            $t->id();
            $t->foreignId('borrow_transaction_id')->constrained()->cascadeOnDelete();
            $t->foreignId('staff_id')->nullable()->constrained('users')->nullOnDelete();
            $t->date('returned_at');
            $t->enum('condition', ['good', 'damaged', 'lost'])->default('good');
            $t->unsignedInteger('days_late')->default(0);
            $t->unsignedInteger('fine_amount')->default(0);
            $t->text('damage_notes')->nullable();
            $t->timestamps();
        });
        Schema::table('fines', function (Blueprint $t) {
            $t->dropForeign(['user_id']);
            $t->dropForeign(['checkout_id']);
            $t->dropIndex(['user_id', 'status']);
            $t->dropColumn(['user_id', 'checkout_id']);
            $t->foreignId('member_id')->after('id')->constrained()->cascadeOnDelete();
            $t->foreignId('borrow_transaction_id')->nullable()->after('member_id')->constrained()->nullOnDelete();
            $t->index(['member_id', 'status']);
        });
    }
};
