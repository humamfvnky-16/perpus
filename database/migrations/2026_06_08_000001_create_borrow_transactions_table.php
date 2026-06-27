<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
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
    }
    public function down(): void { Schema::dropIfExists('borrow_transactions'); }
};
