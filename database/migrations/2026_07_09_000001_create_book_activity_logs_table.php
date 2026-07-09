<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('book_activity_logs', function (Blueprint $t) {
            $t->id();
            $t->string('type', 10); // 'view' (buku dibuka di katalog) | 'read' (e-book dibuka utk dibaca)
            $t->foreignId('book_id')->nullable()->constrained()->cascadeOnDelete();
            $t->foreignId('ebook_id')->nullable()->constrained()->cascadeOnDelete();
            $t->foreignId('reading_spot_id')->nullable()->constrained()->nullOnDelete();
            $t->timestamps();
            $t->index(['type', 'created_at']);
            $t->index(['reading_spot_id', 'created_at']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('book_activity_logs');
    }
};
