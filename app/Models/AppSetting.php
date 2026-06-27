<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class AppSetting extends Model
{
    protected $fillable = ['reading_spot_id', 'key', 'value', 'type', 'group'];

    public function readingSpot() { return $this->belongsTo(ReadingSpot::class); }

    public static function get(string $key, ?int $readingSpotId = null, $default = null)
    {
        $cacheKey = "appsetting.{$readingSpotId}.{$key}";
        return Cache::rememberForever($cacheKey, function () use ($key, $readingSpotId, $default) {
            $row = static::where('key', $key)
                ->where('reading_spot_id', $readingSpotId)
                ->first();
            if (!$row) return $default;
            return match ($row->type) {
                'int', 'integer' => (int) $row->value,
                'bool', 'boolean' => filter_var($row->value, FILTER_VALIDATE_BOOLEAN),
                'array', 'json' => json_decode($row->value, true),
                default => $row->value,
            };
        });
    }

    public static function set(string $key, $value, ?int $readingSpotId = null, string $type = 'string'): void
    {
        $row = static::firstOrNew(['key' => $key, 'reading_spot_id' => $readingSpotId]);
        $row->value = is_array($value) ? json_encode($value) : (string) $value;
        $row->type = $type;
        $row->save();
        Cache::forget("appsetting.{$readingSpotId}.{$key}");
    }
}
