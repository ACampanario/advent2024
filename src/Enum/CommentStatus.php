<?php
namespace App\Enum;

enum CommentStatus: string
{
    case APPROVED = 'approved';
    case DECLINED = 'declined';

    public static function list(): array
    {
        return [
            self::APPROVED->value => __('APPROVED'),
            self::DECLINED->value => __('DECLINED'),
        ];
    }
}
