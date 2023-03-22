<?php

namespace App\Services;

class Censurator
{
    public const GROS_MOTS = [
        'flute',
        'zut',
        'sapristi',
        'chute',
    ];

    public function purify(string $text): string
    {
        foreach (self::GROS_MOTS as $grosmot) {
            $nbEtoile = str_repeat('*', strlen($grosmot));
            $text = str_ireplace($grosmot, $nbEtoile, $text);
        }

        return $text;
//        return str_ireplace(
//            self::GROS_MOTS, "***", $text
//        );
    }
}
