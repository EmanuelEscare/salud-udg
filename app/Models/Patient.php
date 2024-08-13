<?php

namespace App\Models;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Patient extends Model
{
    use HasFactory;

        /**
     * The attributes to be encrypted.
     *
     * @var array<string>
     */
    protected $encryptable = [
        'name',
        'email',
        'phone',
        'code',
        'career',
    ];

    public function setAttribute($key, $value)
    {
        if (in_array($key, $this->encryptable)) {
            $value = Crypt::encryptString($value);
        }

        return parent::setAttribute($key, $value);
    }

    public function getNameAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function getEmailAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function getPhoneAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function getCodeAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }

    public function getCareerAttribute($value)
    {
        return $value ? Crypt::decryptString($value) : null;
    }
    
    public function tests()
    {
        return $this->hasMany(Test::class);
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
