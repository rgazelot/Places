<?php

namespace Places\Messenger;

use Symfony\Component\HttpFoundation\Request;

use Places\Messenger\Exception\ChallengeException;

class Challenge
{
    private $verifyToken;

    public function __construct($verifyToken)
    {
        $this->verifyToken = $verifyToken;
    }

    public function resolveChallenge(Request $request)
    {
        if ($request->query->get('hub_mode') !== 'subscribe' ||
            $request->query->get('hub_verify_token') !== $this->verifyToken) {
            throw new ChallengeException;
        }

        return true;
    }
}
