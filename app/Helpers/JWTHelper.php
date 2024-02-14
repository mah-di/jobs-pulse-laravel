<?php

namespace App\Helpers;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHelper
{
    public static function createToken(User $user, string $type = 'auth.token'): string
    {
        $payload = [
            'iss' => env('APP_NAME'),
            'iat' => time(),
            'exp' => time()+60*60*24*30,
            'userID' => $user->id,
            'userEmail' => $user->email,
            'companyID' => $user->company_id,
            'role' => $user->role,
            'verified' => $user->emailVerifiedAt,
            'type' => $type,
        ];

        $key = env('JWT_KEY');

        return JWT::encode($payload, $key, 'HS256');
    }

    public static function verifyToken(?string $token, string $type): ?object
    {
        try {
            if ($token === null)
                throw new Exception();

            $key = env('JWT_KEY');

            $payload = JWT::decode($token, new Key($key, 'HS256'));

            if ($type !== $payload->type)
                throw new Exception();

            return $payload;

        } catch (Exception $exception) {
            return null;
        }
    }
}
