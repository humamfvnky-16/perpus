<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group', 'label', 'description', 'is_public'];
    protected $casts    = ['is_public' => 'boolean'];

    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("setting.$key", function () use ($key, $default) {
            $row = static::where('key', $key)->first();
            if (!$row) return $default;
            return match ($row->type) {
                'int', 'integer' => (int) $row->value,
                'bool', 'boolean' => filter_var($row->value, FILTER_VALIDATE_BOOLEAN),
                'array', 'json' => json_decode($row->value, true),
                default => $row->value,
            };
        });
    }

    public static function set(string $key, $value): void
    {
        $row = static::firstOrNew(['key' => $key]);
        $row->value = is_array($value) ? json_encode($value) : (string) $value;
        $row->save();
        Cache::forget("setting.$key");
    }
}
