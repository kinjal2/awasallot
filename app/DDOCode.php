<?php

namespace App;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable; // This trait provides the necessary methods
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DDOCode extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable;

    protected $table = 'master.m_ddo';
    protected $primaryKey = 'id';

    // Define fillable attributes
    protected $fillable = [
        'id',
        'district',
        'ddo_code',
        'cardex_no',
        'ddo_reg_no',
        'ddo_office',
        'ddo_office_email_id',
        'created_at',
        'updated_at',
        'password', // Ensure you have a password field if you're using authentication
        'remember_token', // Optional if you're using remember me functionality
        'ddo_office_email_id',
        'officecode','dcode'
    ];

    // Define necessary methods for Authenticatable
    public function getAuthIdentifierName()
    {
        return 'id'; // This should match your identifier column
    }

    public function getAuthIdentifier()
    {
        return $this->getKey(); // Returns the primary key
    }

    public function getAuthPassword()
    {
        return $this->password; // This should be the column storing the password
    }

    public function getRememberToken()
    {
        return $this->remember_token; // Optional
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value; // Optional
    }

    public function getRememberTokenName()
    {
        return 'remember_token'; // Optional
    }
}
