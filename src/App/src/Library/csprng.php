<?php
/**
 * SPX Site
 *
 * @copyright Kevin Smith 2018
 */
declare(strict_types=1);


namespace App\Library;

class csprng
{
    /**
     * Generate a random token
     * using a cryptographically secure
     * pseudorandom number generator (CSPRNG)
     *
     * @param int $length
     *
     * @return string
     * @throws \Exception
     */
    public static function generateToken($length = 20)
    {
        return bin2hex(random_bytes($length));
    }
}