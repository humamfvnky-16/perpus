<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Master buku fisik (1 entri = 1 judul)
        Schema::create('offline_books', function (Blueprint $t) {
            $t->id();
            $t->foreignId('reading_spot_id')->constrained()->cascadeOnDelete();
            $t->string('isbn', 20)->nullable();
            $t->string('title');
            $t->string('subtitle')->nullable();
            $t->foreignId('publisher_id')->nullable()->constrained()->nullOnDelete();
            $t->foreignId('ddc_category_id')->nullable()->constrained()->nullOnDelete();
            $t->year('year_published')->nullable();
            $t->string('language', 10)->default('id');
            $t->unsignedSmallInteger('pages')->nullable();
            $t->string('cover')->nullable();
            $t->text('synopsis')->nullable();
            $t->string('keywords')->nullable();
            $t->enum('source', ['purchase', 'donation', 'exchange', 'other'])->default('purchase');
            $t->unsignedInteger('view_count')->default(0);
            $t->unsignedInteger('borrow_count')->default(0);
            $t->timestamps();
            $t->softDeletes();
            $t->index(['reading_spot_id', 'ddc_category_id']);
        });

        // Pivot N:M offline_book_author dan offline_book_category
        Schema::create('author_offline_book', function (Blueprint $t) {
            $t->foreignId('offline_book_id')->constrained()->cascadeOnDelete();
            $t->foreignId('author_id')->constrained()->cascadeOnDelete();
            $t->primary(['offline_book_id', 'author_id']);
        });
        Schema::create('offline_book_category', function (Blueprint $t) {
            $t->foreignId('offline_book_id')->constrained()->cascadeOnDelete();
            $t->foreignId('book_category_id')->constrained()->cascadeOnDelete();
            $t->primary(['offline_book_id', 'book_category_id']);
        });

        // Kopi fisik (1 entri = 1 unit fisik dengan kode katalog unik)
        Schema::create('offline_book_copies', function (Blueprint $t) {
            $t->id();
            $t->foreignId('offline_book_id')->constrained()->cascadeOnDelete();
            $t->foreignId('reading_spot_id')->constrained()->cascadeOnDelete();
            $t->foreignId('shelf_id')->nullable()->constrained()->nullOnDelete();
            $t->string('catalog_code', 50)->unique()->comment('No. inventaris/katalog unik');
            $t->string('barcode', 50)->nullable()->unique();
            $t->enum('condition', ['new', 'good', 'damaged', 'lost', 'maintenance'])->default('good');
            $t->date('acquired_at')->nullable();
            $t->unsignedInteger('price')->nullable();
            $t->text('notes')->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['offline_book_id', 'condition']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offline_book_copies');
        Schema::dropIfExists('offline_book_category');
        Schema::dropIfExists('author_offline_book');
        Schema::dropIfExists('offline_books');
    }
};
