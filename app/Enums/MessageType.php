<?php


namespace App\Enums;


class MessageType extends BaseEnums
{
    // 文本消息
    public const TEXT = 1;

    // emoji 消息
    public const EMOJI = 2;

    // 图片消息
    public const IMAGE = 3;

    // 文件消息
    public const FILE = 4;

    // 语音消息
    public const VC = 5;

    // 引用消息
    public const REFERENCE = 6;
}