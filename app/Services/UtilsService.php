<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 24/07/2021
 * Time: 21:32
 */

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UtilsService
{
    private const ALPHABET = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    private const ACCESS_CODE_LENGTH = 6;

    /**
     * @return string
     */
    public static function generateAccessCode(): string
    {
        $seed = self::ALPHABET;
        $seed = str_split($seed);
        shuffle($seed);
        $seedLength = count($seed);

        $accessCode = '';

        do {
            try {
                $accessCode .= self::ALPHABET[random_int(0, $seedLength)];
            } catch (\Exception $e) {
                Log::channel('user')->warning(
                    'Wystąpił problem z generowaniem składniku kodu dostępu!',
                    [
                        'user_id' => Auth::id(),
                        'data' => [
                            'accessCodeLength' => strlen($accessCode),
                        ],
                    ]
                );
            }
        } while (strlen($accessCode) < self::ACCESS_CODE_LENGTH);

        return $accessCode;
    }
}
