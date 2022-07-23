<?php

namespace ridwan\Belajar\PHP\MVC\Controller;

use PHPUnit\Framework\TestCase;
use ridwan\Belajar\PHP\MVC\Config\Database;
use ridwan\Belajar\PHP\MVC\Domain\Session;
use ridwan\Belajar\PHP\MVC\Domain\User;
use ridwan\Belajar\PHP\MVC\Repository\SessionRepository;
use ridwan\Belajar\PHP\MVC\Repository\UserRepository;
use ridwan\Belajar\PHP\MVC\Service\SessionService;

class HomeControllerTest extends TestCase
{
    private HomeController $homeController;
    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp():void
    {
        $this->homeController = new HomeController();
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());

        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();
    }

    public function testGuest()
    {
        $this->homeController->index();

        $this->expectOutputRegex("[Login Management]");
    }

    public function testUserLogin()
    {
        $user = new User();
        $user->id = "ridwan";
        $user->name = "ridwan";
        $user->password = "rahasia";
        $this->userRepository->save($user);

        $session = new Session();
        $session->id = uniqid();
        $session->userId = $user->id;
        $this->sessionRepository->save($session);

        $_COOKIE[SessionService::$COOKIE_NAME] = $session->id;

        $this->homeController->index();

        $this->expectOutputRegex("[Hello ridwan]");
    }

}
