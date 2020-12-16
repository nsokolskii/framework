<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;
use app\models\Confirmation;
use app\models\Restoration;
use app\models\User;
use app\models\LoginForm;
use app\models\RestoreFormFirst;
use app\models\RestoreFormSecond;

class AuthController extends Controller{
    public function login(Request $request){
        $loginForm = new LoginForm();
        if($request->isPost()){
           $loginForm->loadData($request->getBody());
           if($loginForm->validate() && $loginForm->login()){
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
        $user = new User();
        if($request->isPost()){
            $user->loadData($request->getBody());
            if($user->validate() && $user->save(['validated' => $user->validated])){
                $confirmation = new Confirmation();
                $confirmationCode = password_hash($user->email, PASSWORD_DEFAULT);
                $confirmation->saveConfirmationCode($user->email, $confirmationCode);
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
        $restoreForm = new RestoreFormFirst();
        if($request->isPost()){
           $restoreForm->loadData($request->getBody());
           $hash = hash('sha256',date('Y-m-d H:i:s'));
           if($restoreForm->validate() && $restoreForm->restore($hash)){
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
        $restoreForm = new RestoreFormSecond();
        $restoration = Restoration::findOne(['hash' => $hash]);
        if(!$restoration){
            Application::$app->response->redirect('/restore');
        }
        if($request->isPost()){
           $restoreForm->loadData($request->getBody());
           if($restoreForm->validate() && $restoreForm->updatePassword($restoration)){
                Restoration::removeOne('email', $restoration->email);
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
        $confirmation = Confirmation::findOne(['confirmationCode' => $path[0]]);
        User::alter($confirmation->email, 'confirmed', '1');
        Confirmation::removeOne('email', $confirmation->email);
        Application::$app->session->setFlash('success', "<b>$confirmation->email</b> successfully confirmed");
        Application::$app->response->redirect('/');
    }

    public function logout(Request $request){
        Application::$app->logout();
        Application::$app->response->redirect('/');
    }
}
