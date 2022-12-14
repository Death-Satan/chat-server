<?php

declare (strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @author   Death-Satan
 * @email    death-satan@qq.com
 */
namespace App\Model;

/**
 * @property int $id 
 * @property int $app_id 
 * @property int $from_id 
 * @property int $to_id 
 * @property int $status 
 * @property \Carbon\Carbon $created_at 
 * @property \Carbon\Carbon $updated_at 
 */
class Friend extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'friend';
    protected $guarded = ['id'];
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
    protected $casts = ['id' => 'integer', 'app_id' => 'integer', 'from_id' => 'integer', 'to_id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];

    public static function is_friend($from_id,$to_id): bool
    {
        $friend_1 = self::query()->newQuery()->where('from_id',$from_id)->where('to_id',$to_id)->first();
        $friend_2 = self::query()->newQuery()->where('from_id',$to_id)->where('to_id',$from_id)->first();
        return !empty($friend_1) || !empty($friend_2);
    }
}