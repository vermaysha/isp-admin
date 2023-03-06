<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperClient
 */
class Client extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Internet Reseller Belum Terpasang
     */
    const NOT_INSTALLED = 0;

    /**
     * Internet Reseller Sudah Terpasang dan sudah aktif
     */
    const ACTIVED = 1;

    /**
     * Pelanggan Terblokir
     */
    const BLOCKED = 2;

    /**
     * Pelanggan berhenti sementara
     */
    const INACTIVE = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'client_id',
        'reseller_id',
        'plan_id',
        'plan_price',
        'plan_bandwidth',
        'npwp',
        'payment_due_date',
        'is_ppn',
        'status',
        'installed_at',
        'blocked_at',
        'inactive_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_ppn' => 'boolean',
        'installed_at' => 'datetime',
        'blocked_at' => 'datetime',
        'inactive_at' => 'datetime',
    ];

    /**
     * Relation to User (Client account)
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation to plan
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Relation to reseller
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reseller()
    {
        return $this->belongsTo(Reseller::class);
    }

    /**
     * Scope a query to only include ppn client.
     *
     * @return void
     */
    public function scopePpn(Builder $query)
    {
        return $query->where('is_ppn', true);
    }

    /**
     * Relation to bills
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    /**
     * Get Last bill
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function lastBill()
    {
        return $this->hasOne(Bill::class)->latestOfMany();
    }
}
