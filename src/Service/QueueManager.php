<?php

namespace App\Service;

use App\Dictionary\Consumers;
use Interop\Queue\Context;

/**
 * Class QueueManager
 *
 * @package App\Service
 */
class QueueManager
{
    /**
     * @var Context
     */
    private $context;

    /**
     * QueueManager constructor.
     *
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    /**
     * @param string $data
     *
     * @throws \Interop\Queue\Exception
     * @throws \Interop\Queue\Exception\InvalidDestinationException
     * @throws \Interop\Queue\Exception\InvalidMessageException
     */
    public function sendMessage(string $data): void
    {
        $this->context->createProducer()->send(
            $this->context->createQueue(Consumers::MS_ANALYTICS),
            $this->context->createMessage($data)
        );
    }
}
