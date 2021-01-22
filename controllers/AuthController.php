<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class AuthController extends Controller{
    public function login(Request $request){
        $loginForm = new \app\repository\User();
        if($request->isPost()){
           $loginForm->loadData($request->getBody());
           if($loginForm->validate('login') && $loginForm->login()){
                Application::$app->session->setFlash('success', 'Successful login');
                Application::$app->response->redirect('/');
                exit;
           }
        }
        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $loginForm
        ]);
    }

    public function register(Request $request){
        $user = new \app\repository\User();
        if($request->isPost()){
            $user->loadData($request->getBody());
            $hash = hash('sha256',date('Y-m-d H:i:s'));
            if($user->validate('register') && $confirmationCode = $user->save(['validated' => $user->validated, 'hash' => $hash])){

                Application::$app->mailer->configure('verify', 'Confirm your e-mail address', 'Click here to confirm your e-mail address');
                Application::$app->mailer->send($user->email, $confirmationCode);
                Application::$app->session->setFlash('success', "A message to <b>$user->email</b> with a confirmation link has been sent");
                Application::$app->response->redirect('/');
                exit;
            }
        }
        $this->setLayout('auth');
        return $this->render('register', [
            'model' => $user
        ]);
    }

    public function restoreFormFirst(Request $request){
        $restoreForm = new \app\repository\User();
        if($request->isPost()){
           $restoreForm->loadData($request->getBody());
           $hash = hash('sha256',date('Y-m-d H:i:s'));
           if($restoreForm->validate('restore1') && $restoreForm->restore($hash)){

                Application::$app->mailer->configure('restore', 'Password restoration', 'Click here to restore your password');
                Application::$app->mailer->send($restoreForm->email, $hash);
                Application::$app->session->setFlash('success', "A message to <b>$restoreForm->email</b> with further instructions has been sent");
                Application::$app->response->redirect('/');
                exit;
           }
        }
        $this->setLayout('auth');
        return $this->render('restoreFirst', [
            'model' => $restoreForm
        ]);
    }

    public function restoreFormSecond(Request $request, $hash){
        $restoreForm = new \app\repository\User();
        Application::$app->model->setTable('restore');
        $restoration = Application::$app->model->findOne(['hash' => $hash]);
        if(!$restoration){
            Application::$app->response->redirect('/restore');
        }
        if($request->isPost()){
           $restoreForm->loadData($request->getBody());
           if($restoreForm->validate('restore2') && $restoreForm->updatePassword($restoration)){

                Application::$app->model->setTable('restore');
                Application::$app->model->removeOne(['email' => $restoration->email]);
                Application::$app->session->setFlash('success', "Password successfully changed");
                Application::$app->response->redirect('/');
                exit;
           }
        }
        $this->setLayout('auth');
        return $this->render('restoreSecond', [
            'model' => $restoreForm,
            'hash' => $hash
        ]);
    }

    public function restore(Request $request, $path){
        if(!$path){
            return $this->restoreFormFirst($request);
        }
        return $this->restoreFormSecond($request, $path[0]);
    }

    public function verify($request, $path){
        Application::$app->model->setTable('confirmations');
        $confirmation = Application::$app->model->findOne(['hash' => $path[0]]);
        Application::$app->model->removeOne(['email' => $confirmation->email]);
        Application::$app->model->setTable('users');
        Application::$app->model->alterOne(['email' => $confirmation->email], ['confirmed' => '1']);
        Application::$app->session->setFlash('success', "<b>$confirmation->email</b> successfully confirmed");
        Application::$app->response->redirect('/');
    }

    public function logout(Request $request){
        Application::$app->logout();
        Application::$app->response->redirect('/');
    }
}
