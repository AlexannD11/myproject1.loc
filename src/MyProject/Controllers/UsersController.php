<?php


namespace MyProject\Controllers;

use MyProject\Exceptions\{ActivationException, ForbiddenException, InvalidArgumentException};
use MyProject\Services\{EmailSender, UsersAuthService};
//use MyProject\Models\Articles\Article;
//use MyProject\Models\Articles\Comments\Comment;
use MyProject\Models\Users\{User, UserActivationService};

class UsersController extends AbstractController
{
    public function signUp()
    {
        if (!empty($_POST)) {
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }

            if ($user instanceof User) {
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Активация', 'userActivation.php', [
                    'userId' => $user->getId(),
                    'code' => $code
                ]);

                $this->view->renderHtml('users/signUpSuccessful.php');
                return;
            }
        }

        $this->view->renderHtml('users/signUp.php');
    }

    public function activate(int $userId, string $activationCode)
    {
        $user = User::getById($userId);
        if ($user === null) {
            throw new ActivationException('Такого пользователя не существует');
        }
        if ($user->isConfirmed()) {
            throw new ActivationException('Пользователь уже активирован');
        }
        $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);
        if (!$isCodeValid) {
            throw new ActivationException('Код подтверждения авторизации не верен');
        }
        $user->activate();
        UserActivationService::deleteActivationCode($userId);
        $this->view->renderHtml('users/activationSuccessful.php',
            ['nick' => $user->getNickname()]);
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
        if ($this->user) {
            setcookie('token', '', 0, '/', '', false, true);
            $this->view->renderHtml('users/logout.php',
                ['nick' => $this->user->getNickname(), 'user' => null]);
        } else {
            header('Location: /');
            exit();
        }
    }
    public function edit($userId)
    {
        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Для редактирования необходимы права администратора');
        }
        $userEdit = User::getById($userId);
        if ($userEdit === null) {
            throw new ActivationException('Такого пользователя не существует');
        }
        if ($this->user->getId()==$userEdit->getId()) {
            throw new ForbiddenException('Вы не можете сменить свою роль');
        }
        $role=$userEdit->getRole()=='admin' ? 'user' : 'admin';
        $userEdit->setRole($role);
        $users=User::findAll();
        $this->view->renderHtml('admin/viewUsers.php',['users'=>$users]);
    }
    public function delete($userId)
    {
        if (!$this->user->isAdmin()) {
            throw new ForbiddenException('Для редактирования необходимы права администратора');
        }
        $userEdit = User::getById($userId);
        if ($userEdit === null) {
            throw new ActivationException('Такого пользователя не существует');
        }
        if ($this->user->getId()==$userEdit->getId()){
            throw new ForbiddenException('Вы не можете удалить себя');
        }
        $userEdit->delete();
        $users=User::findAll();
        $this->view->renderHtml('admin/viewUsers.php',['users'=>$users]);
    }
}