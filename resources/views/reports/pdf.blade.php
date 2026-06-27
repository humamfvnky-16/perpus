<!doctype html>
<html><head><meta charset="utf-8"><title>{{ $title }}</title>
<style>body{font-family:DejaVu Sans,Arial;padding:20px}h1{font-size:18px}table{width:100%;border-collapse:collapse}td,th{border:1px solid #ccc;padding:6px;font-size:11px;text-align:left}</style>
</head><body>
<h1>{{ $title }}</h1>
<p>Dicetak: {{ now()->format('d M Y H:i') }}</p>
<table><thead><tr><th>#</th><th>Detail</th><th>Info</th></tr></thead><tbody>
@foreach($rows as $i => $r)
<tr><td>{{ $i+1 }}</td><td>{{ $r->title ?? $r->book?->title }}</td><td>{{ $r->borrow_count ?? ($r->due_at?->format('d M Y') ?? '') }}</td></tr>
@endforeach
</tbody></table>
</body></html>
