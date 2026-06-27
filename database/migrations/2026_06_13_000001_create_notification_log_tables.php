<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('notifications', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->string('type');
            $t->morphs('notifiable');
            $t->text('data');
            $t->timestamp('read_at')->nullable();
            $t->timestamps();
        });
        Schema::create('activity_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('action', 100);
            $t->string('subject_type')->nullable();
            $t->unsignedBigInteger('subject_id')->nullable();
            $t->string('ip_address', 45)->nullable();
            $t->string('user_agent', 500)->nullable();
            $t->json('properties')->nullable();
            $t->timestamps();
            $t->index(['subject_type', 'subject_id']);
            $t->index(['user_id', 'action']);
        });
        Schema::create('audit_logs', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $t->string('event', 50);
            $t->string('auditable_type');
            $t->unsignedBigInteger('auditable_id');
            $t->json('old_values')->nullable();
            $t->json('new_values')->nullable();
            $t->string('url', 500)->nullable();
            $t->string('ip_address', 45)->nullable();
            $t->timestamps();
            $t->index(['auditable_type', 'auditable_id']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('notifications');
    }
};
