<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('ebooks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('book_id')->nullable()->constrained()->nullOnDelete();
            $t->string('title');
            $t->enum('format', ['pdf', 'epub', 'docx', 'pptx', 'audio', 'video']);
            $t->string('file_path');
            $t->unsignedBigInteger('file_size')->default(0);
            $t->unsignedInteger('duration_seconds')->nullable()->comment('audio/video');
            $t->boolean('downloadable')->default(false);
            $t->boolean('watermark')->default(true);
            $t->enum('access', ['public', 'member', 'staff'])->default('member');
            $t->unsignedInteger('view_count')->default(0);
            $t->unsignedInteger('download_count')->default(0);
            $t->timestamps();
            $t->softDeletes();
            $t->index(['format', 'access']);
        });

        Schema::create('ebook_bookmarks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('ebook_id')->constrained()->cascadeOnDelete();
            $t->unsignedInteger('page')->default(1);
            $t->unsignedInteger('position')->nullable();
            $t->string('note')->nullable();
            $t->timestamps();
            $t->unique(['user_id', 'ebook_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('ebook_bookmarks');
        Schema::dropIfExists('ebooks');
    }
};
