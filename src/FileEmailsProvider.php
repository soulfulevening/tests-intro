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

    /**
     * @inheritDoc
     */
    public function fetchAll(): array
    {
        return array_filter(explode(PHP_EOL, file_get_contents($this->filePath)));
    }

    /**
     * @inheritDoc
     * @throws \Exception
     */
    public function appendMany(array $emails)
    {
        $result = file_put_contents($this->filePath, implode(PHP_EOL, $emails) . PHP_EOL, FILE_APPEND);

        if ($result === false) {
            throw new \Exception('Data is not saved.');
        }
    }
}