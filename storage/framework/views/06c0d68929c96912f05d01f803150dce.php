<div class="fixed bottom-6 right-6 z-50 space-y-2 w-80">
    <template x-for="t in items" :key="t.id">
        <div x-transition class="rounded-lg shadow-lg px-4 py-3 text-sm flex items-start justify-between gap-2"
             :class="{ 'bg-green-600 text-white': t.type==='success', 'bg-red-600 text-white': t.type==='error', 'bg-gray-800 text-white': t.type==='info' }">
            <span x-text="t.msg"></span>
            <button @click="dismiss(t.id)" class="opacity-70 hover:opacity-100">&times;</button>
        </div>
    </template>
</div>
<?php /**PATH C:\laragon\www\Aplikasi Perpus\digital-library\resources\views/partials/toast.blade.php ENDPATH**/ ?>