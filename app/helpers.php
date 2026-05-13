<?php

use Vinkla\Hashids\Facades\Hashids;

if (!function_exists('encode_id')) {
    /**
     * Encode ID to Hashids
     */
    function encode_id(int $id): string
    {
        return Hashids::encode($id);
    }
}

if (!function_exists('decode_id')) {
    /**
     * Decode Hashids to ID
     * Return null if hash not valid
     */
    function decode_id(string $hash): ?int
    {
        $decoded = Hashids::decode($hash);

        if (count($decoded) === 0) {
            return null;
        }

        return $decoded[0];
    }
}
