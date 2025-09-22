<?php

namespace App\Utilities;

class FlashMessage
{
    public static function success(string $title, string $description, string $message): array
    {
        return [
            'alert' => [
                'title' => $title,
                'description' => $description,
                'message' => $message,
                'code' => '200'
            ]
        ];
    }

    public static function error(string $title, string $description, string $message): array
    {
        return [
            'alert' => [
                'title' => $title,
                'description' => $description,
                'message' => $message,
                'code' => '400'
            ]
        ];
    }
}
