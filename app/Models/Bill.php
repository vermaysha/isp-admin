<?php

namespace App\Models;

use Bavix\Wallet\Models\Transaction;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @mixin IdeHelperBill
 */
class Bill extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Tax Percentage (PPN)
     */
    const TAX = 0.11;

    /**
     * BHP USO Percentage
     */
    const BHP_USO = 0.0175;

    /**
     * KSO Percentage
     */
    const KSO = 0.0575;

    /**
     * Purchase of a new data package
     *
     * @var int
     */
    const TYPE_NEW_PURCHASE = 1;

    /**
     * Old data plan extension
     *
     * @var int
     */
    const TYPE_EXTENSION = 2;

    /**
     * Upgrade old data plan to new
     *
     * @var int
     */
    const TYPE_UPGRADE = 3;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['grand_total_formated', 'created_at_formated', 'payment_month_formated', 'payed_at_formated'];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_month' => 'date',
    ];

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
     * Relation to client
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
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
     * Relation to transaction table
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    /**
     * Format price
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function grandTotalFormated(): Attribute
    {
        return Attribute::make(
            function ($value, $attributes) {
                return rupiah_format($attributes['grand_total']);
            }
        );
    }

    /**
     * Format creation datetime
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function createdAtFormated(): Attribute
    {
        return Attribute::make(
            function ($value, $attributes) {
                return Carbon::parse($attributes['created_at'])
                    ->isoFormat('dddd, D MMMM g');
            }
        );
    }

    /**
     * Format payed datetime
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function payedAtFormated(): Attribute
    {
        return Attribute::make(
            function ($value, $attributes) {
                return Carbon::parse($attributes['payed_at'])
                    ->isoFormat('dddd, D MMMM g');
            }
        );
    }

    /**
     * Format payment for month datetime
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function paymentMonthFormated(): Attribute
    {
        return Attribute::make(
            function ($value, $attributes) {
                return Carbon::parse($attributes['payment_month'])
                    ->isoFormat('MMMM g');
            }
        );
    }
}
