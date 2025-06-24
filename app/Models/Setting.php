<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value', 'type', 'group', 'description', 'is_public', 'is_encrypted'];
    protected $casts = ['is_public' => 'boolean', 'is_encrypted' => 'boolean'];

    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }
        
        $value = $setting->value;
        
        // Cast selon le type
        return match($setting->type) {
            'boolean' => (bool) $value,
            'integer' => (int) $value,
            'float' => (float) $value,
            'array', 'json' => json_decode($value, true),
            default => $value
        };
    }

    public static function set($key, $value, $type = 'string')
    {
        if (in_array($type, ['array', 'json'])) {
            $value = json_encode($value);
        }
        
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }
}
