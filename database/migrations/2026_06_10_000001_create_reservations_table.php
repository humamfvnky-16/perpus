<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
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
    }
    public function down(): void { Schema::dropIfExists('reservations'); }
};
