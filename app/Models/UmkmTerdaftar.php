<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UmkmTerdaftar extends Model
{
    protected $table = 'umkm_terdaftar';

    protected $fillable = [
        'pengajuan_id',
    ];

    /**
     * Get the submission that owns the registered UMKM.
     */
    public function pengajuan(): BelongsTo
    {
        return $this->belongsTo(Pengajuan::class, 'pengajuan_id');
    }

    /**
     * Dynamic proxy to Pengajuan model properties to avoid duplicating data.
     */
    public function __get($key)
    {
        if (array_key_exists($key, $this->attributes) || $this->hasGetMutator($key) || method_exists($this, $key)) {
            return parent::__get($key);
        }

        if ($this->relationLoaded('pengajuan') || $this->pengajuan) {
            return $this->pengajuan->$key;
        }

        return parent::__get($key);
    }

    /**
     * Dynamic isset check proxy.
     */
    public function __isset($key)
    {
        if (parent::__isset($key)) {
            return true;
        }
        return isset($this->pengajuan) && isset($this->pengajuan->$key);
    }
}
