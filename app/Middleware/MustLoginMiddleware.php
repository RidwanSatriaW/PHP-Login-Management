<?php

namespace ridwan\Belajar\PHP\MVC\Middleware;

use ridwan\Belajar\PHP\MVC\App\View;
use ridwan\Belajar\PHP\MVC\Config\Database;
use ridwan\Belajar\PHP\MVC\Repository\SessionRepository;
use ridwan\Belajar\PHP\MVC\Repository\UserRepository;
use ridwan\Belajar\PHP\MVC\Service\SessionService;

class MustLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository, $userRepository);
    }

    function before(): void
    {
        $user = $this->sessionService->current();
        if ($user == null) {
            View::redirect('/users/login');
        }
    }
}