<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'fullname',
        'username',
        'email',
        'password',
        'birth',
        'gender',
        'address',
        'photo',
        'nik',
        'ktp_file',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth' => 'date',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['created_at_formated'];

    /**
     * Relation to all user sessions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions()
    {
        return $this->hasMany(Session::class, 'user_id', 'id');
    }

    /**
     * Relation to resellers
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function resellers()
    {
        return $this->belongsToMany(Reseller::class, 'reseller_employee')->withTimestamps();
    }

    /**
     * Relation to client data (if exists)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function client()
    {
        return $this->hasOne(Client::class);
    }

    /**
     * Relation to admin data (if exists)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function admin()
    {
        return $this->hasOne(Admin::class);
    }

    /**
     * Relation to reseller owner data (if exitst)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function reseller()
    {
        return $this->hasOne(Reseller::class);
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
                if (empty($attributes['created_at'])) {
                    return null;
                }

                return Carbon::parse($attributes['created_at'])
                    ->isoFormat('dddd, D MMMM g');
            }
        );
    }
}
