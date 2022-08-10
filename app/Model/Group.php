<?php

declare(strict_types=1);
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
 * @property string $name
 * @property string $group_code_name
 * @property string $setting
 * @property int $status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Group extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'group';

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
    protected $casts = ['id' => 'integer', 'app_id' => 'integer', 'status' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
