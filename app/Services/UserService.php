<?php
/**
 * Created by PhpStorm.
 * User: Patryk Jelonek (patryk)
 * Date: 25/07/2021
 * Time: 23:24
 */

namespace App\Services;

use App\Constants\UserStatusConstants;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserService
{
    /**
     * @var UserRepository
     */
    private $repository;

    /**
     * UserService constructor.
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string      $email
     * @param string      $password
     * @param string      $firstName
     * @param string      $lastName
     * @param string      $phone
     * @param int         $userStatusId
     * @param string|null $avatarUrl
     *
     * @return User|null
     */
    public function createUser(
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $phone,
        int $userStatusId,
        ?string $avatarUrl = null
    ): ?User {
        $user = new User();
        $user->email = $email;
        $user->password_hash = Hash::make($password);
        $user->password_reset_token = Str::random(64);
        $user->first_name = $firstName;
        $user->last_name = $lastName;
        $user->phone = $phone;
        $user->avatar_url = $avatarUrl;
        $user->remember_token = "remember_token";
        $user->user_status_id = $userStatusId;
        $user->activation_token = Str::random(64);
        $user->freshTimestamp();

        if ($user->save()) {
            return $user;
        }

        return null;
    }
}
