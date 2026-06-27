<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('fines', function (Blueprint $t) {
            $t->id();
            $t->foreignId('member_id')->constrained()->cascadeOnDelete();
            $t->foreignId('borrow_transaction_id')->nullable()->constrained()->nullOnDelete();
            $t->enum('type', ['late', 'damage', 'lost', 'other'])->default('late');
            $t->unsignedInteger('amount');
            $t->unsignedInteger('paid_amount')->default(0);
            $t->enum('status', ['unpaid', 'partial', 'paid', 'waived'])->default('unpaid');
            $t->date('due_date')->nullable();
            $t->text('description')->nullable();
            $t->timestamps();
            $t->index(['member_id', 'status']);
        });
        Schema::create('payments', function (Blueprint $t) {
            $t->id();
            $t->foreignId('fine_id')->constrained()->cascadeOnDelete();
            $t->foreignId('received_by')->nullable()->constrained('users')->nullOnDelete();
            $t->unsignedInteger('amount');
            $t->enum('method', ['cash', 'transfer', 'qris', 'other'])->default('cash');
            $t->string('reference', 100)->nullable();
            $t->string('proof_path')->nullable();
            $t->timestamp('paid_at')->useCurrent();
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('payments');
        Schema::dropIfExists('fines');
    }
};
