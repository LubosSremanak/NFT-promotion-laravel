<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'address',
        'name',
        'nonce',
        'profile_url',
        'banner_url',
        'role',
        'premium'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function deleteUserToken(): void
    {
        auth()->user()->tokens()->delete();
    }

    public function isConnected(): bool
    {
        return auth()->check();
    }


    public function findUserByKey($publicKey)
    {
        return self::where('address', $publicKey)->first();
    }

    public function isWrongPassword($user, $password): bool
    {
        return (!$user || !Hash::check($password, $user->password));
    }

    public function updateNonce($address, $nonce)
    {
        return self::where('address', $address)->update(['nonce' => $nonce]);
    }

    public function createUser(string $nonce, $validatedRequest)
    {
        return self::create([
            'name' => $validatedRequest['address'],
            'address' => $validatedRequest['address'],
            'nonce' => $nonce,
            'profile_url' => $this->generateAvatar(),
            'banner_url' => null,
            'premium' => null,
            'role' => null,
        ]);
    }

    private function generateAvatar(): string
    {
        $avatars =
            ['jia', 'jean', 'james', 'josh', 'joe', 'jerry', 'jude', 'jack',
                'jon', 'jordan', 'jake', 'jed', 'jacques', 'jai', 'jazebelle',
                'jane', 'jocelyn', 'jenni', 'jabala', 'jana', 'jess',
                'jeane', 'jeri', 'jodi', 'jolee', 'josephine', 'jaqueline',
                'julie'];
        $path = 'api/pictures/avatars/';
        return $path . $avatars[array_rand($avatars)] . 'svg';

    }
}
