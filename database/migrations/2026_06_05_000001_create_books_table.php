<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('books', function (Blueprint $t) {
            $t->id();
            $t->string('isbn', 20)->unique();
            $t->string('title');
            $t->string('subtitle')->nullable();
            $t->foreignId('publisher_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('book_category_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('shelf_id')->nullable()->constrained()->nullOnDelete();
            $t->year('year_published')->nullable();
            $t->string('edition', 20)->nullable();
            $t->string('language', 10)->default('id');
            $t->unsignedSmallInteger('pages')->nullable();
            $t->string('cover')->nullable();
            $t->json('images')->nullable();
            $t->text('synopsis')->nullable();
            $t->string('keywords')->nullable();
            $t->enum('status', ['available', 'borrowed', 'reserved', 'maintenance', 'lost'])->default('available');
            $t->unsignedInteger('stock')->default(1);
            $t->unsignedInteger('available')->default(1);
            $t->string('barcode', 50)->unique();
            $t->string('qr_code', 100)->nullable();
            $t->string('location')->nullable();
            $t->unsignedInteger('view_count')->default(0);
            $t->unsignedInteger('borrow_count')->default(0);
            $t->decimal('rating_avg', 3, 2)->default(0);
            $t->unsignedInteger('rating_count')->default(0);
            $t->timestamps();
            $t->softDeletes();
            $t->fullText(['title', 'subtitle', 'synopsis', 'keywords']);
            $t->index(['status', 'book_category_id']);
        });

        Schema::create('book_author', function (Blueprint $t) {
            $t->foreignId('book_id')->constrained()->cascadeOnDelete();
            $t->foreignId('author_id')->constrained()->cascadeOnDelete();
            $t->primary(['book_id', 'author_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('book_author');
        Schema::dropIfExists('books');
    }
};
