<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('members', function (Blueprint $t) {
            $t->id();
            $t->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $t->string('member_no', 30)->unique();
            $t->string('nis_nip', 30)->nullable()->index();
            $t->enum('type', ['student', 'teacher', 'staff', 'public'])->default('student');
            $t->string('class')->nullable();
            $t->string('major')->nullable();
            $t->text('address')->nullable();
            $t->string('city')->nullable();
            $t->date('birth_date')->nullable();
            $t->enum('gender', ['M', 'F'])->nullable();
            $t->date('joined_at')->useCurrent();
            $t->date('expires_at')->nullable();
            $t->boolean('is_active')->default(true);
            $t->string('qr_code', 100)->nullable();
            $t->timestamps();
            $t->softDeletes();
            $t->index(['type', 'is_active']);
        });
    }
    public function down(): void { Schema::dropIfExists('members'); }
};
