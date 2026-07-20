<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('visitor_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('path', 500);
            $t->string('method', 10);
            $t->string('ip_address', 45)->nullable();
            $t->string('user_agent', 500)->nullable();
            $t->string('referer', 500)->nullable();
            $t->timestamps();
            $t->index('created_at');
            $t->index('ip_address');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitor_logs');
    }
};
