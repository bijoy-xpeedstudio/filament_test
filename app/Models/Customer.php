<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Roles;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = [
        'name',
        'role_id',
        'image'
    ];

    public function roles()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
}
