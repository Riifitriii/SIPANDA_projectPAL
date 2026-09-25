<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'subject_type',
        'subject_id',
        'reference_type',
        'reference_id',
    ];

    /**
     * Relasi ke user yang melakukan aktivitas.
     * Menggunakan withDefault agar aman jika user dihapus (user_id menjadi null).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => 'Sistem / Pengguna Terhapus',
            'role' => 'unknown',
        ]);
    }

    /**
     * Relasi polimorfik ke data terkait (subject).
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Alias relasi ke data terkait (reference).
     */
    public function reference(): MorphTo
    {
        return $this->morphTo('subject');
    }

    /**
     * Mutator agar atribut reference_type tersimpan ke subject_type.
     */
    public function setReferenceTypeAttribute($value): void
    {
        $this->attributes['subject_type'] = $value;
    }

    /**
     * Accessor agar reference_type membaca subject_type.
     */
    public function getReferenceTypeAttribute(): ?string
    {
        return $this->attributes['subject_type'] ?? null;
    }

    /**
     * Mutator agar atribut reference_id tersimpan ke subject_id.
     */
    public function setReferenceIdAttribute($value): void
    {
        $this->attributes['subject_id'] = $value;
    }

    /**
     * Accessor agar reference_id membaca subject_id.
     */
    public function getReferenceIdAttribute(): mixed
    {
        return $this->attributes['subject_id'] ?? null;
    }

    /**
     * Helper method statis untuk mencatat aktivitas dengan mudah.
     */
    public static function record(string $action, string $description, ?Model $subject = null, ?User $user = null): self
    {
        return self::create([
            'user_id' => $user?->id ?? auth()->id(),
            'action' => $action,
            'description' => $description,
            'subject_type' => $subject ? $subject->getMorphClass() : null,
            'subject_id' => $subject?->getKey(),
        ]);
    }
}
