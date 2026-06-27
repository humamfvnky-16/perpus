<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reading_spots', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('slug')->unique();
            $t->string('type')->default('school')->comment('school, library, community, public');
            $t->string('npsn', 20)->nullable()->comment('Nomor Pokok Sekolah Nasional');
            $t->string('address')->nullable();
            $t->string('city')->nullable();
            $t->string('province')->nullable();
            $t->decimal('latitude', 10, 7)->nullable();
            $t->decimal('longitude', 10, 7)->nullable();
            $t->string('phone', 20)->nullable();
            $t->string('email')->nullable();
            $t->string('logo')->nullable();
            $t->string('banner')->nullable();
            $t->text('description')->nullable();
            $t->boolean('is_active')->default(true);
            $t->timestamps();
            $t->softDeletes();
            $t->index(['type', 'is_active']);
        });

        // Pivot: user dapat menjadi anggota di beberapa Reading Spot
        Schema::create('reading_spot_user', function (Blueprint $t) {
            $t->foreignId('reading_spot_id')->constrained()->cascadeOnDelete();
            $t->foreignId('user_id')->constrained()->cascadeOnDelete();
            $t->string('role')->default('member')->comment('admin, staff, member');
            $t->boolean('is_active')->default(true);
            $t->timestamp('joined_at')->useCurrent();
            $t->primary(['reading_spot_id', 'user_id']);
        });

        // Tambah kolom reading_spot_id ke tabel inti
        Schema::table('books', function (Blueprint $t) {
            $t->foreignId('reading_spot_id')->nullable()->after('shelf_id')->constrained()->nullOnDelete();
            $t->index('reading_spot_id');
        });
        Schema::table('members', function (Blueprint $t) {
            $t->foreignId('reading_spot_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            $t->index('reading_spot_id');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $t) {
            $t->dropForeign(['reading_spot_id']);
            $t->dropColumn('reading_spot_id');
        });
        Schema::table('books', function (Blueprint $t) {
            $t->dropForeign(['reading_spot_id']);
            $t->dropColumn('reading_spot_id');
        });
        Schema::dropIfExists('reading_spot_user');
        Schema::dropIfExists('reading_spots');
    }
};
