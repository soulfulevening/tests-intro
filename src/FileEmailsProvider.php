<?php

namespace Subscription;

class FileEmailsProvider implements EmailsProviderInterface
{
    /**
     * @var string
     */
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }


    public function fetchAll(): array
    {
        // TODO: Implement fetchAll() method.
    }

    public function appendMany(array $emails)
    {
        // TODO: Implement appendMany() method.
    }
}