<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id_role';

    /**
     * Define the one-to-many relationship with User.
     * Satu Role bisa dimiliki oleh banyak User.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'id_role', 'id_role');
    }
}