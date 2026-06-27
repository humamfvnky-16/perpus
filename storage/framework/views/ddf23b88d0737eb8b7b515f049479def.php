<?php $__env->startSection('title', 'Masuk'); ?>
<?php $__env->startSection('content'); ?>
<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900 p-4">
    <div class="card w-full max-w-md">
        <h1 class="text-2xl font-bold mb-1">Masuk</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Akses akun perpustakaan Anda.</p>
        <?php if($errors->any()): ?><div class="badge-red mb-3 block"><?php echo e($errors->first()); ?></div><?php endif; ?>
        <?php if(session('status')): ?><div class="badge-green mb-3 block"><?php echo e(session('status')); ?></div><?php endif; ?>
        <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-4"><?php echo csrf_field(); ?>
            <div>
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus class="form-input">
            </div>
            <div>
                <label class="block text-sm mb-1">Password</label>
                <input type="password" name="password" required class="form-input">
            </div>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="remember" class="rounded"> Ingat saya</label>
            <button class="btn-primary w-full">Masuk</button>
        </form>
        <p class="mt-4 text-sm text-center">Belum punya akun? <a href="<?php echo e(route('register')); ?>" class="text-primary-600 hover:underline">Daftar</a></p>
        <div class="mt-6 text-xs text-gray-400 text-center">
            <p>Demo login:</p>
            <p><code>admin@library.test</code> / <code>password</code></p>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/auth/login.blade.php ENDPATH**/ ?>