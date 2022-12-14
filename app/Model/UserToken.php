<?php

declare (strict_types=1);
namespace App\Model;

use Carbon\Carbon;
/**
 * @property int $id 
 * @property int $user_id 
 * @property string $token 
 * @property string $expire_at 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class UserToken extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_token';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'user_id' => 'integer', 'expire_at'=>'datetime', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}