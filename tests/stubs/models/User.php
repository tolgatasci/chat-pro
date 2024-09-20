<?php

namespace TolgaTasci\Chat\Tests\Stubs\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use TolgaTasci\Chat\Traits\Messageable;

class User extends Authenticatable
{
    use HasFactory, Messageable;

    protected $fillable = ['name', 'email', 'password', 'remember_token'];

    /**
     * Model için yeni bir fabrika örneği oluştur.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \TolgaTasci\Chat\Tests\database\factories\UserFactory::new();
    }
}
