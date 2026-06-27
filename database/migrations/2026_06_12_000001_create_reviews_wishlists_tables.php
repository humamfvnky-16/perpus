<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reviews', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('book_id')->constrained()->cascadeOnDelete();
            $t->unsignedTinyInteger('rating');
            $t->text('content')->nullable();
            $t->unsignedInteger('likes')->default(0);
            $t->boolean('is_reported')->default(false);
            $t->boolean('is_hidden')->default(false);
            $t->timestamps();
            $t->unique(['user_id', 'book_id']);
        });
        Schema::create('review_likes', function (Blueprint $t) {
            $t->foreignId('review_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->primary(['review_id', 'user_id']);
        });
        Schema::create('wishlists', function (Blueprint $t) {
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->foreignId('book_id')->constrained()->cascadeOnDelete();
            $t->timestamp('created_at')->useCurrent();
            $t->primary(['user_id', 'book_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('wishlists');
        Schema::dropIfExists('review_likes');
        Schema::dropIfExists('reviews');
    }
};
