<?php

namespace App\Service;

use App\Dictionary\Users;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class UserManager
 *
 * @package App\Service
 */
class UserManager
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserManager constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return string|null
     */
    public function getUsers(): ?string
    {
        return $this->userRepository->getUsers();
    }

    /**
     * @param $data
     *
     * @return bool
     */
    public function addUser($data): bool
    {
        $result = false;

        try {
            $result = file_put_contents(Users::JSON_FILE_PATH, $data);
        } catch (FileException $fileException){
            echo $fileException->getMessage();
        }

        return $result;
    }
}
