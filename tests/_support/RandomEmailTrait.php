<?php

use Tokenly\TokenGenerator\TokenGenerator;

trait RandomEmailTrait
{

    public function generateRandomEmail()
    {
        $generator = new TokenGenerator();

        return $generator->generateToken(10, 'QA-TEST-')
            . '@' . $generator->generateToken(5, 'Q')
            . '.' . $generator->generateToken(5, 'A');
    }
}