<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ddc_categories', function (Blueprint $t) {
            $t->id();
            $t->string('code', 10)->unique()->comment('Kode DDC: 000, 100, ..., 900');
            $t->string('name');
            $t->text('description')->nullable();
            $t->unsignedSmallInteger('order')->default(0);
            $t->foreignId('parent_id')->nullable()->constrained('ddc_categories')->nullOnDelete();
            $t->timestamps();
            $t->index('parent_id');
        });

        Schema::table('books', function (Blueprint $t) {
            $t->foreignId('ddc_category_id')->nullable()->after('book_category_id')->constrained()->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $t) {
            $t->dropForeign(['ddc_category_id']);
            $t->dropColumn('ddc_category_id');
        });
        Schema::dropIfExists('ddc_categories');
    }
};
