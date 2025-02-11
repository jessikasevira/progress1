<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory; // 🛠️ Tambahkan ini agar tidak error

    protected $fillable = ['name', 'username', 'email', 'phone', 'address'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
