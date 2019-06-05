<?php

namespace App\Service;

use App\Dictionary\Stats;
use App\Repository\StatsRepository;
use App\Traits\JsonParser;
use App\Traits\ErrorParser;
use App\Traits\DataCollector;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

/**
 * Class TrackingManager
 *
 * @package App\Service
 */
class TrackingManager
{
    use JsonParser;
    use ErrorParser;
    use DataCollector;

    /**
     * @var StatsRepository
     */
    private $statsRepository;

    /**
     * @var QueueManager
     */
    private $queueManager;

    /**
     * TrackingManager constructor.
     *
     * @param StatsRepository           $statsRepository
     * @param QueueManager              $queueManager
     */
    public function __construct(StatsRepository $statsRepository, QueueManager $queueManager)
    {
        $this->statsRepository = $statsRepository;
        $this->queueManager = $queueManager;
    }

    /**
     * @return string|null
     */
    public function getStats(): ?string
    {
        return $this->statsRepository->getAll();
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @throws \Exception
     */
    public function prepareData(array $data): array
    {
        $date = new \DateTime();
        $dateCreated = $date->format('Y-m-d H:i:s');

        if (!array_key_exists(Stats::DATE_CREATED, $data)){
            $data[Stats::DATE_CREATED] = $dateCreated;
        }

        return $data;
    }

    /**
     * @param array              $data
     * @param ValidatorInterface $validator
     *
     * @return array
     */
    public function isValidate(array $data, ValidatorInterface $validator): array
    {
        $id = null;
        $idUser = null;
        $sourceLabel = null;

        if (array_key_exists(Stats::ID, $data)){
            $id = $data[Stats::ID];
        }

        if (array_key_exists(Stats::ID_USER, $data)){
            $idUser = $data[Stats::ID_USER];
        }

        if (array_key_exists(Stats::SOURCE_LABEL, $data)){
            $sourceLabel = $data[Stats::SOURCE_LABEL];
        }

        $input = [
            Stats::ID => $id,
            Stats::ID_USER => $idUser,
            Stats::SOURCE_LABEL => $sourceLabel
        ];

        $constraints = new Assert\Collection([
            Stats::ID => [new Assert\Positive(), new Assert\NotBlank],
            Stats::ID_USER => [new Assert\Positive(), new Assert\NotBlank],
            Stats::SOURCE_LABEL => [new Assert\Length(['min' => 5]), new Assert\NotBlank]
        ]);

        $violations = $validator->validate($input, $constraints);

        return $this->checkErrors($violations);
    }

    /**
     * @param array $data
     *
     * @return bool
     */
    public function addStats(array $data): bool
    {
        $result = false;
        $existStats = $this->statsRepository->getAll();

        if ($existStats !== ''){
            $existStats = $this->jsonDecode($existStats);
            $data = $this->jsonEncode($this->mergeData($existStats, $data));
            $this->queueManager->sendMessage($data);
        }

        try {
            $result = file_put_contents(Stats::JSON_FILE_PATH, $data);
        } catch (FileException $fileException){
            echo $fileException->getMessage();
        }

        return $result;
    }
}
