<?php

namespace app\core;

use app\repository\UserEntry;
use app\repository\ConfirmationEntry;
use app\repository\RestoreEntry;

class Service{
    public $user;

    public function __construct(){
        $primaryValue = Application::$app->session->get('user');
        if($primaryValue){
            $user = new Application::$config['userClass'];
            $primaryKey = $user::$primaryKey;
            Application::$app->model->setTable('users');
            $this->user = Application::$app->model->findOne([$primaryKey => $primaryValue]);
        }
        else{
            $this->user = null;
        }
        Application::$app->user = $this->user;
    }

    public function isAuthor(){
        return $this->user ? $this->user->role : false;
    }

    public function userId(){
        return $this->user ? $this->user->id : 0;
    }

    public function hash(){
        return hash('sha256',date('Y-m-d H:i:s'));
    }

    public function saveUser($user, $params = []){
        $hash = $this->hash();
        $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        if(array_search('invitationCode', $user->validated) !== false){
            $user->role = Application::$config['userClass']::ROLE_AUTHOR;
        }
        $confirmation = new ConfirmationEntry();
        $confirmation->loadData([
            'email' => $user->email,
            'hash' => $hash
        ]);
        Application::$app->model->save($confirmation);
        Application::$app->model->save($user);
        Application::$app->mailer->configure('verify', 'Confirm your e-mail address', 'Click here to confirm your e-mail address');
        Application::$app->mailer->send($user->email, $hash);
        return true;
    }

    public function matchUser($user){
        Application::$app->model->setTable('users');
        $foundUser = Application::$app->model->findOne(['email' => $user->email]);
        if(!$foundUser){
            $user->addError('email', 'User with this email does not exist');
            return false;
        }
        if(!password_verify($user->password, $foundUser->password)){
            $user->addError('password', 'Password is incorrect');
            return false;
        }
        return $this->loginUser($foundUser);
    }

    public function loginUser($user){
        Application::$app->user = $user;
        $primaryKey = $user::$primaryKey;
        $primaryValue = $user->{$primaryKey};
        Application::$app->session->set('user', $primaryValue);
        return true;
    }

    public function logoutUser(){
        Application::$app->user = null;
        Application::$app->session->remove('user');
    }

    public function isGuest(){
        return !$this->user;
    }

    public function restorePassword($user){
        $hash = $this->hash();
        Application::$app->model->setTable('users');
        $foundUser = Application::$app->model->findOne(['email' => $user->email]);
        if(!$foundUser){
            $user->addError('email', 'User with this email does not exist');
            return false;
        }
        $restoration = new RestoreEntry();
        $restoration->loadData([
            'email' => $user->email,
            'hash' => $hash
        ]);
        Application::$app->model->save($restoration);
        Application::$app->mailer->configure('restore', 'Password restoration', 'Click here to restore your password');
        Application::$app->mailer->send($user->email, $hash);
        return true;
    }

    public function updatePassword($user, $restoration){
        $newPassword = password_hash($user->password, PASSWORD_DEFAULT);
        Application::$app->model->setTable('users');
        Application::$app->model->alterOne(['email' => $restoration->email], ['password' => $newPassword]);
        Application::$app->model->setTable('restore');
        Application::$app->model->removeOne(['email' => $restoration->email]);
        return true;
    }


}