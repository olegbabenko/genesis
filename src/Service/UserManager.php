<?php

namespace App\Service;

use App\Dictionary\Users;
use App\Dictionary\Api;
use App\Repository\UserRepository;
use App\Traits\JsonParser;
use App\Traits\ErrorParser;
use App\Traits\DataCollector;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class UserManager
 *
 * @package App\Service
 */
class UserManager
{
    use JsonParser;
    use ErrorParser;
    use DataCollector;

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
     * @param array $data
     *
     * @return bool
     */
    public function addUser(array $data): bool
    {
        $result = false;
        $existData = $this->userRepository->getUsers();

        if ($existData !== ''){
            $existData = $this->jsonDecode($existData);
            $data = $this->jsonEncode($this->mergeData($existData, $data));
        }

        try {
            $result = file_put_contents(Users::JSON_FILE_PATH, $data);
        } catch (FileException $fileException){
            echo $fileException->getMessage();
        }

        return $result;
    }

    /**
     * @param array              $data
     * @param ValidatorInterface $validator
     *
     * @return array
     */
    public function registrationIsValidate(array $data, ValidatorInterface $validator): array
    {
        $firstName = null;
        $lastName = null;
        $nickName = null;
        $age = null;
        $password = null;

        if (array_key_exists(Users::FIRST_NAME, $data)){
            $firstName = $data[Users::FIRST_NAME];
        }

        if (array_key_exists(Users::LAST_NAME, $data)){
            $lastName = $data[Users::LAST_NAME];
        }

        if (array_key_exists(Users::NICK_NAME, $data)){
            $nickName = $data[Users::NICK_NAME];
        }

        if (array_key_exists(Users::AGE, $data)){
            $age = $data[Users::AGE];
        }

        if (array_key_exists(Users::PASSWORD, $data)){
            $password = $data[Users::PASSWORD];
        }

        $input = [
            Users::FIRST_NAME => $firstName,
            Users::LAST_NAME => $lastName,
            Users::NICK_NAME => $nickName,
            Users::AGE => $age,
            Users::PASSWORD => $password
        ];

        $constraints = new Assert\Collection([
            Users::FIRST_NAME => [new Assert\Length(['min' => 3]), new Assert\NotBlank],
            Users::LAST_NAME => [new Assert\Length(['min' => 2]), new Assert\NotBlank],
            Users::NICK_NAME => [new Assert\Length(['min' => 5]), new Assert\NotBlank],
            Users::AGE => [new Assert\Positive(), new Assert\GreaterThan(17), new Assert\NotBlank],
            Users::PASSWORD => [new Assert\Length(['min' => 8]), new Assert\NotBlank]
        ]);

        $violations = $validator->validate($input, $constraints);
        $errors = $this->checkErrors($violations);

        if (count($errors) > 0 ){
            return $errors;
        }

        return [Api::STATUS => true];
    }

    /**
     * @param string $nickName
     * @param string $password
     *
     * @return bool
     */
    public function login(string $nickName, string $password): bool
    {
        $user = $this->userRepository->getUserByNickname($nickName);

        return $user[Users::NICK_NAME] === $nickName && $user[Users::PASSWORD] === $password;
    }
}
