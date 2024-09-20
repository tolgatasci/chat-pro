<?php
namespace TolgaTasci\Chat\Tests\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Model
{
    use HasFactory; // Factory kullanımı için trait ekleniyor
    protected $guarded = [];
}
