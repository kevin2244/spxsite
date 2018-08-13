<?php
declare(strict_types=1);
/**
 * User: kevin
 * Date: 23/05/2018
 * Time: 02:10
 */

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