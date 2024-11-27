<?php
namespace App\Enum;

enum PostStatus: string
{
    case DRAFT = 'draft';
    case PUBLISHED = 'published';
    case ARCHIVED = 'archived';

    public static function list(): array
    {
        return [
            self::DRAFT->value => __('DRAFT'),
            self::PUBLISHED->value => __('PUBLISHED'),
            self::ARCHIVED->value => __('ARCHIVED'),
        ];
    }
}
