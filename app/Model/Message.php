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
 * @property int $to_id
 * @property int $form_id
 * @property int $msg_type
 * @property int $type
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Message extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'message';

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
    protected $casts = ['id' => 'integer', 'app_id' => 'integer', 'to_id' => 'integer', 'form_id' => 'integer', 'msg_type' => 'integer', 'type' => 'integer', 'created_at' => 'datetime', 'updated_at' => 'datetime'];
}
