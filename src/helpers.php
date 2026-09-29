<?php

declare(strict_types=1);

function date_ru(?string $value): string
{
    return $value ? (new DateTime($value))->format('d.m.Y') : '';
}

// русская форма слова по числу: plural_ru(3, 'просмотр', 'просмотра', 'просмотров')
function plural_ru(int $number, string $one, string $few, string $many): string
{
    $number = abs($number) % 100;
    if ($number >= 11 && $number <= 19) {
        return $many;
    }

    return match (true) {
        $number % 10 === 1 => $one,
        $number % 10 >= 2 && $number % 10 <= 4 => $few,
        default => $many,
    };
}
