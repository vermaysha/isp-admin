<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperPlan
 */
class Plan extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Plan Fixed
     *
     * for personal or home usage
     */
    const PLAN_FIXED = 'FIXED';

    /**
     * Plan Dynamic
     *
     * for corporate usage
     */
    const PLAN_DYNAMIC = 'DYNAMIC';

    /**
     * Subscription postpaid
     */
    const SUBSCRIPTION_POSTPAID = 'POSTPAID';

    /**
     * Subscription Prepaid
     */
    const SUBSCRIPTION_PREPAID = 'PREPAID';

    /**
     * Price include Tax
     *
     * for personal or home usage
     */
    const TAX_INCLUDED = 'INCLUDED';

    /**
     * Price exclude Tax
     *
     * for corporate usage
     */
    const TAX_EXCLUDED = 'EXCLUDED';

    /**
     * Tax Percentage
     */
    const TAX = .11;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'reseller_id',
        'bandwidth',
        'price',
        'description',
        'tax_type',
        'type',
    ];

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [
        'price' => null,
        'description' => null,
        'tax_type' => self::TAX_INCLUDED,
        'type' => self::PLAN_FIXED,
        'subscription' => self::SUBSCRIPTION_POSTPAID,
    ];

    /**
     * Format price
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function priceFormated(): Attribute
    {
        return Attribute::make(
            function ($value, $attributes) {
                if ($attributes['tax_type'] === self::TAX_EXCLUDED) {
                    $price = $attributes['price'];
                } else {
                    $price = $attributes['price'] - ($attributes['price'] * self::TAX);
                }

                return rupiah_format($price);
            }
        );
    }

    /**
     * Total tax from price
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function taxFormated(): Attribute
    {
        return Attribute::make(
            fn ($value, $attributes) => rupiah_format($attributes['price'] * .11)
        );
    }

    /**
     * Total Price after tax
     *
     * @return Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function priceTaxFormated(): Attribute
    {
        return Attribute::make(
            function ($value, $attributes) {
                if ($attributes['tax_type'] === self::TAX_EXCLUDED) {
                    $price = $attributes['price'] + ($attributes['price'] * .11);
                } else {
                    $price = $attributes['price'];
                }

                return rupiah_format($price);
            }
        );
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
     * Relation to clients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }
}
