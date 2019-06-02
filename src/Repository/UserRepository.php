<?php

namespace App\Repository;

use App\Dictionary\Users;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;

/**
 * Class UserRepository
 *
 * @package App\Repository
 */
class UserRepository
{
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
}
