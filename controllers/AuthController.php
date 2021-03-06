<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class AuthController extends Controller{
    public function login(Request $request){
        $user = new \app\repository\UserEntry();
        if($request->isPost()){
           $user->loadData($request->getBody());
           if($user->validate('login') && Application::$app->service->matchUser($user)){
                Application::$app->session->setFlash('success', 'Successful login');
                Application::$app->response->redirect('/');
                exit;
           }
        }
        $this->setLayout('auth');
        return $this->render('login', [
            'model' => $user
        ]);
    }

    public function register(Request $request){
        $user = new \app\repository\UserEntry();
        if($request->isPost()){
            $user->loadData($request->getBody());
            if($user->validate('register') && Application::$app->service->saveUser($user)){
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
        $user = new \app\repository\UserEntry();
        if($request->isPost()){
           $user->loadData($request->getBody());
           if($user->validate('restore1') && Application::$app->service->restorePassword($user)){
                Application::$app->session->setFlash('success', "A message to <b>$user->email</b> with further instructions has been sent");
                Application::$app->response->redirect('/');
                exit;
           }
        }
        $this->setLayout('auth');
        return $this->render('restoreFirst', [
            'model' => $user
        ]);
    }

    public function restoreFormSecond(Request $request, $hash){
        $user = new \app\repository\UserEntry();
        Application::$app->model->setTable('restore');
        $restoration = Application::$app->model->findOne(['hash' => $hash]);
        if(!$restoration){
            Application::$app->response->redirect('/restore');
        }
        if($request->isPost()){
           $user->loadData($request->getBody());
           if($user->validate('restore2') && Application::$app->service->updatePassword($user, $restoration)){
                Application::$app->session->setFlash('success', "Password successfully changed");
                Application::$app->response->redirect('/');
                exit;
           }
        }
        $this->setLayout('auth');
        return $this->render('restoreSecond', [
            'model' => $user,
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
        if($confirmation){
            Application::$app->model->removeOne(['email' => $confirmation->email]);
            Application::$app->model->setTable('users');
            Application::$app->model->alterOne(['email' => $confirmation->email], ['confirmed' => '1']);
            Application::$app->session->setFlash('success', "<b>$confirmation->email</b> successfully confirmed");
        }
        Application::$app->response->redirect('/');
    }

    public function logout(Request $request){
        if(Application::$app->service->user){
            Application::$app->service->logoutUser();
        }
        Application::$app->response->redirect('/');
    }
}
