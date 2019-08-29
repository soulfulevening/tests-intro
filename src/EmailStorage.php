<?php

namespace Subscription;

use Subscription\Exceptions\EmailAlreadyExistsException;
use Subscription\Exceptions\EmailStorageException;

class EmailStorage
{

    /**
     * @var string[]
     */
    private $emails = [];

    /**
     * @var array
     */
    private $persistedEmails = [];

    /**
     * @var string
     */
    private $filePath;

    public function __construct(string $filePath)
    {
        $this->emails = explode(PHP_EOL, file_get_contents($filePath));
        $this->filePath = $filePath;
    }

    /**
     * @param string $email
     *
     * @throws EmailAlreadyExistsException
     */
    public function persist(string $email): void
    {
        if ($this->exists($email)) {
            throw new EmailAlreadyExistsException('This email is already subscribed!');
        }

        $this->persistedEmails[] = $email;
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    public function exists(string $email): bool
    {
        return in_array($email, $this->emails);
    }

    /**
     * @throws EmailStorageException
     */
    public function flush()
    {
        $result = file_put_contents($this->filePath, implode(PHP_EOL, $this->persistedEmails) . PHP_EOL, FILE_APPEND);

        if ($result === false) {
            throw new EmailStorageException('An error occurred while saving email to subscription list!');
        }

        $this->emails = array_merge($this->emails, $this->persistedEmails);
        $this->persistedEmails = [];
    }
}