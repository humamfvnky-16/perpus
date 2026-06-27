<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('book_categories', function (Blueprint $t) {
            $t->id();
            $t->string('name')->unique();
            $t->string('slug')->unique();
            $t->string('dewey_code', 10)->nullable();
            $t->text('description')->nullable();
            $t->timestamps();
        });
        Schema::create('authors', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->text('bio')->nullable();
            $t->string('photo')->nullable();
            $t->date('birth_date')->nullable();
            $t->string('nationality')->nullable();
            $t->timestamps();
            $t->index('name');
        });
        Schema::create('publishers', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('address')->nullable();
            $t->string('city')->nullable();
            $t->string('country')->nullable();
            $t->string('website')->nullable();
            $t->timestamps();
        });
        Schema::create('shelves', function (Blueprint $t) {
            $t->id();
            $t->string('code', 20)->unique();
            $t->string('name');
            $t->string('floor')->nullable();
            $t->string('room')->nullable();
            $t->text('description')->nullable();
            $t->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('shelves');
        Schema::dropIfExists('publishers');
        Schema::dropIfExists('authors');
        Schema::dropIfExists('book_categories');
    }
};
