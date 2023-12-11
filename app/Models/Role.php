<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'user';
    const ROLE_SELLER = 'seller';

    const ADMIN = 1;
    const USER = 2;
    const SELLER = 3;

    const ROLES = [self::ROLE_SELLER, self::ROLE_ADMIN, self::ROLE_USER];

    /**
     * @inheritDoc
     */
    protected $fillable = ['id', 'name'];

    /**
     * @inheritDoc
     */
    protected $casts = [];

    ####################
    ### Vitual Attributes
    ####################


    ####################
    ### Helper Methods
    ####################


    ####################
    ### Relations
    ####################
}
