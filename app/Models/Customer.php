<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property int $store_id
 * @property string $first_name
 * @property string $phone
 * @property string $email
 * @property bool $has_optin
 * @property bool $is_anonymized
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $last_login_at
 */
class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $with = ['store'];
    protected $fillable = [
        'first_name',
        'phone',
        'email',
        'has_optin',
        'is_anonymized'
    ];
    protected $casts = [
        'has_optin' => 'boolean'
    ];

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
