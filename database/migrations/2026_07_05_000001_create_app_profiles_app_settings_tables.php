<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Profile aplikasi per ReadingSpot (untuk branding multi-tenant)
        Schema::create('app_profiles', function (Blueprint $t) {
            $t->id();
            $t->foreignId('reading_spot_id')->nullable()->constrained()->cascadeOnDelete();
            $t->string('app_name')->default('Perpustakaan Digital');
            $t->string('logo')->nullable();
            $t->string('favicon')->nullable();
            $t->string('primary_color', 10)->default('#2563eb');
            $t->string('secondary_color', 10)->default('#f3f4f6');
            $t->text('about')->nullable();
            $t->text('terms')->nullable();
            $t->text('privacy_policy')->nullable();
            $t->string('contact_email')->nullable();
            $t->string('contact_phone', 30)->nullable();
            $t->string('facebook')->nullable();
            $t->string('instagram')->nullable();
            $t->string('twitter')->nullable();
            $t->string('youtube')->nullable();
            $t->timestamps();
        });

        // App Settings (key-value flexible per ReadingSpot)
        Schema::create('app_settings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('reading_spot_id')->nullable()->constrained()->cascadeOnDelete();
            $t->string('key', 100);
            $t->text('value')->nullable();
            $t->string('type', 20)->default('string');
            $t->string('group', 50)->default('general');
            $t->timestamps();
            $t->unique(['reading_spot_id', 'key']);
        });

        // Checkout Settings (aturan peminjaman per spot)
        Schema::create('checkout_settings', function (Blueprint $t) {
            $t->id();
            $t->foreignId('reading_spot_id')->constrained()->cascadeOnDelete();
            $t->unsignedSmallInteger('loan_days')->default(7);
            $t->unsignedTinyInteger('max_books')->default(3);
            $t->unsignedInteger('daily_fine')->default(1000);
            $t->unsignedInteger('damage_fine')->default(25000);
            $t->unsignedInteger('lost_fine')->default(100000);
            $t->unsignedTinyInteger('renew_limit')->default(1);
            $t->unsignedSmallInteger('hold_expires_hours')->default(48);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checkout_settings');
        Schema::dropIfExists('app_settings');
        Schema::dropIfExists('app_profiles');
    }
};
