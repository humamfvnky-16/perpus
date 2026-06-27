<footer class="border-t border-slate-200 dark:border-slate-700 mt-8 py-4 px-6 text-xs text-slate-500 flex justify-between flex-wrap gap-2">
    <span>&copy; {{ date('Y') }} {{ config('app.name') }}. Konsep multi-tenant terinspirasi SpotBaca.</span>
    <span class="flex items-center gap-3">
        <a href="{{ route('catalog.index') }}" class="hover:text-primary-600">Katalog</a>
        <a href="#" class="hover:text-primary-600">Bantuan</a>
        <a href="#" class="hover:text-primary-600">Tentang</a>
    </span>
</footer>
