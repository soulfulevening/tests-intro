<?php

namespace Subscription;

use Subscription\Exceptions\EmailAlreadyExistsException;
use Subscription\Exceptions\EmailStorageException;

class EmailRepository
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
     * @var EmailsProviderInterface
     */
    private $emailsProvider;

    public function __construct(EmailsProviderInterface $emailsProvider)
    {
        $this->emailsProvider = $emailsProvider;
        $this->renewEmailList();
    }

    private function renewEmailList()
    {
        $this->emails = $this->emailsProvider->fetchAll();
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
        try {
            $this->emailsProvider->appendMany($this->persistedEmails);

        } catch (\Exception $exception) {
            throw new EmailStorageException('An error occurred while saving email to subscription list!');
        }

        $this->persistedEmails = [];
        $this->renewEmailList();
    }
}