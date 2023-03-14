<?php

namespace App\Models;

use App\Enums\ResellerType;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperReseller
 */
class Reseller extends Model implements Wallet
{
    use HasFactory, HasWallet, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'photo',
        'email',
        'phone_number',
        'address_id',
        'npwp',
        'pks',
        'contract_file',
        'contract_start_at',
        'contract_end_at',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'type' => ResellerType::class,
        'contract_start_at' => 'date',
        'contract_end_at' => 'date',
        'inactive_at' => 'date',
    ];

    /**
     * Relation to reseller employees
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function employees()
    {
        return $this->belongsToMany(User::class, 'reseller_employee')->withTimestamps();
    }

    /**
     * Relation to clients
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    /**
     * Show only PPN Clients with eager loading
     *
     * @return void
     */
    public function clientPpns()
    {
        return $this->clients()->ppn();
    }

    /**
     * Relation to reseller owner
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relation to address
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }
}
