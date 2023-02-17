<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */

namespace App\Models{
    /**
     * App\Models\Bill
     *
     * @property int $id
     * @property string $invoice_id
     * @property int $type
     * @property string $amount Balance Without any tax
     * @property string $tax PPN
     * @property string $grand_total Balance With PPN & BHP USO
     * @property int|null $transaction_id
     * @property string|null $bill_photo
     * @property int|null $reseller_id
     * @property string $reseller_name
     * @property int|null $client_id
     * @property string $client_name
     * @property int|null $plan_id
     * @property string $plan_name
     * @property string $plan_price
     * @property int $plan_bandwidth
     * @property mixed $plan_tax_type
     * @property string|null $description
     * @property string|null $accepted_at
     * @property string|null $payed_at
     * @property \Illuminate\Support\Carbon|null $payment_month
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\Client|null $client
     * @property-read \App\Models\Plan|null $plan
     * @property-read \App\Models\Reseller|null $reseller
     * @property-read \Bavix\Wallet\Models\Transaction|null $transaction
     *
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereAcceptedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereAmount($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereBillPhoto($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereClientId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereClientName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereGrandTotal($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereInvoiceId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill wherePayedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill wherePaymentMonth($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill wherePlanBandwidth($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill wherePlanId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill wherePlanName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill wherePlanPrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill wherePlanTaxType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereResellerId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereResellerName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereTax($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereTransactionId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill withTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Bill withoutTrashed()
     *
     * @mixin \Eloquent
     */
    class IdeHelperBill
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Client
     *
     * @property int $id
     * @property int $user_id
     * @property int $plan_id
     * @property int $reseller_id
     * @property string|null $payment_due_date
     * @property bool $is_ppn
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Bill> $bills
     * @property-read int|null $bills_count
     * @property-read \App\Models\Bill|null $lastBill
     * @property-read \App\Models\Plan $plan
     * @property-read \App\Models\Reseller $reseller
     * @property-read \App\Models\User $user
     *
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client ppn()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereIsPpn($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client wherePaymentDueDate($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client wherePlanId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereResellerId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client whereUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client withTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Client withoutTrashed()
     *
     * @mixin \Eloquent
     */
    class IdeHelperClient
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Permission
     *
     * @property int $id
     * @property string $name
     * @property string $guard_name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
     * @property-read int|null $permissions_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
     * @property-read int|null $roles_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
     * @property-read int|null $users_count
     *
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission permission($permissions)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission query()
     * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Permission role($roles, $guard = null)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereGuardName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Permission whereUpdatedAt($value)
     *
     * @mixin \Eloquent
     */
    class IdeHelperPermission
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Plan
     *
     * @property int $id
     * @property int $reseller_id
     * @property string $name
     * @property int|null $bandwidth
     * @property string|null $price
     * @property string|null $description
     * @property mixed $type
     * @property mixed $tax_type
     * @property mixed $subscription
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Client> $clients
     * @property-read int|null $clients_count
     * @property-read \App\Models\Reseller $reseller
     *
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereBandwidth($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereDescription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan wherePrice($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereResellerId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereSubscription($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereTaxType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereType($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan withTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Plan withoutTrashed()
     *
     * @mixin \Eloquent
     */
    class IdeHelperPlan
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Reseller
     *
     * @property int $id
     * @property int $user_id Owner
     * @property string|null $name Company Name
     * @property string|null $photo
     * @property string|null $email Company Email
     * @property string|null $phone_number Company Phone Number
     * @property string|null $address Company Address
     * @property \Illuminate\Support\Carbon|null $contract_start_at
     * @property \Illuminate\Support\Carbon|null $contract_end_at
     * @property \Illuminate\Support\Carbon|null $inactive_at
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Client> $clients
     * @property-read int|null $clients_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $employees
     * @property-read int|null $employees_count
     * @property-read string $balance
     * @property-read int $balance_int
     * @property-read \Bavix\Wallet\Models\Wallet $wallet
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \Bavix\Wallet\Models\Transaction> $transactions
     * @property-read int|null $transactions_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \Bavix\Wallet\Models\Transfer> $transfers
     * @property-read int|null $transfers_count
     * @property-read \App\Models\User $user
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \Bavix\Wallet\Models\Transaction> $walletTransactions
     * @property-read int|null $wallet_transactions_count
     *
     * @method static \Database\Factories\ResellerFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller whereAddress($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller whereContractEndAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller whereContractStartAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller whereInactiveAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller wherePhoneNumber($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller wherePhoto($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller whereUserId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller withTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Reseller withoutTrashed()
     *
     * @mixin \Eloquent
     */
    class IdeHelperReseller
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Role
     *
     * @property int $id
     * @property string $name
     * @property string $guard_name
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
     * @property-read int|null $permissions_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
     * @property-read int|null $users_count
     *
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\Spatie\Permission\Models\Role permission($permissions)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereGuardName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereName($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Role whereUpdatedAt($value)
     *
     * @mixin \Eloquent
     */
    class IdeHelperRole
    {
    }
}

namespace App\Models{
    /**
     * App\Models\Session
     *
     * @property int $id
     * @property int|null $user_id
     * @property string|null $ip_address
     * @property string|null $user_agent
     * @property string $payload
     * @property \Illuminate\Support\Carbon $last_activity
     *
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session whereIpAddress($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session whereLastActivity($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session wherePayload($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session whereUserAgent($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Session whereUserId($value)
     *
     * @mixin \Eloquent
     */
    class IdeHelperSession
    {
    }
}

namespace App\Models{
    /**
     * App\Models\User
     *
     * @property int $id
     * @property string $username
     * @property string $email
     * @property string $password
     * @property string|null $fullname
     * @property string|null $photo
     * @property string|null $address
     * @property string|null $nik
     * @property string|null $phone_number
     * @property \Illuminate\Support\Carbon|null $birth
     * @property mixed|null $gender
     * @property string|null $remember_token
     * @property \Illuminate\Support\Carbon|null $deleted_at
     * @property \Illuminate\Support\Carbon|null $created_at
     * @property \Illuminate\Support\Carbon|null $updated_at
     * @property-read \App\Models\Client|null $client
     * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
     * @property-read int|null $notifications_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
     * @property-read int|null $permissions_count
     * @property-read \App\Models\Reseller|null $reseller
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Reseller> $resellers
     * @property-read int|null $resellers_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
     * @property-read int|null $roles_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Session> $sessions
     * @property-read int|null $sessions_count
     * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
     * @property-read int|null $tokens_count
     *
     * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User onlyTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User permission($permissions)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User query()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User role($roles, $guard = null)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereAddress($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereBirth($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereCreatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereDeletedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereEmail($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereFullname($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereGender($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereId($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereNik($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePassword($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhoneNumber($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User wherePhoto($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereRememberToken($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUpdatedAt($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User whereUsername($value)
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User withTrashed()
     * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\User withoutTrashed()
     *
     * @mixin \Eloquent
     */
    class IdeHelperUser
    {
    }
}
