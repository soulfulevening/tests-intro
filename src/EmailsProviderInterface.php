<?php

namespace Subscription;

interface EmailsProviderInterface
{

    /**
     * @return array
     */
    public function fetchAll(): array;

    /**
     * @param array $emails
     * @return mixed
     */
    public function appendMany(array $emails);
}