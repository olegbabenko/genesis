<?php

namespace App\Repository;

use App\Dictionary\Users;
use App\Traits\JsonParser;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class UserRepository
 *
 * @package App\Repository
 */
class UserRepository
{
    use JsonParser;

    /**
     * @return string|null
     */
    public function getUsers(): ?string
    {
        $users = null;

        try {
            $users = file_get_contents(Users::JSON_FILE_PATH);
        } catch (FileNotFoundException $fileNotFoundException){
            echo $fileNotFoundException->getMessage();
        }

        return $users;
    }

    /**
     * @param string $nickname
     *
     * @return array|null
     */
    public function getUserByNickname(string $nickname): ?array
    {
        $users = $this->jsonDecode($this->getUsers());

        foreach ($users as $user){
            if ($user[Users::NICK_NAME] === $nickname){
                return $user;
            }
        }

        return null;
    }
}
