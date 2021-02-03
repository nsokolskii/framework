<?php

namespace app\controllers;

use app\core\Application;
use app\core\Controller;
use app\core\Request;

class EditController extends Controller{
    public string $layout = 'main';

    public function upload($request){
        $post = new \app\repository\PostEntry();
        $post->author = Application::$app->user->id;
        $file = new \app\repository\FileEntry();
        if($request->isPost()){
            $post->loadData($request->getBody());
            $file->loadData($request->getFiles()['image']);
            if($post->validate('create') && $file->validate()){
                if($file->empty()){
                    $file->errors[] = "Image must be selected";
                    
                }
                else{
                    $hash = hash('sha256',date('Y-m-d H:i:s'));
                    $imageName = $hash.'.'.$file->getExt();
                    move_uploaded_file($file->tmp_name, 'runtime/img/'.$imageName);
                    $post->image = $imageName;
                    Application::$app->model->save($post);
                    Application::$app->response->redirect("/user/".Application::$app->user->id);
                }
                
            }
        }
        return $this->render('create', [
            'model' => $post,
            'fileModel' => $file
        ]);
    }

    public function edit($request, $path){
        Application::$app->model->setTable('shots');
        $shotId = $path[0];
        $shot = Application::$app->model->findOne(['id' => $shotId]);
        $file = new \app\repository\FileEntry();
        if($request->isPost()){
            $shot->loadData($request->getBody());
            $file->loadData($request->getFiles()['image']);
            if($shot->validate('create') && $file->validate()){
                if(!$file->empty()){
                    $hash = hash('sha256',date('Y-m-d H:i:s'));
                    $imageName = $hash.'.'.$file->getExt();
                    $oldImageName = $shot->image;
                    unlink('runtime/img/'.$oldImageName);
                    move_uploaded_file($file->tmp_name, 'runtime/img/'.$imageName);
                    $shot->image = $imageName;
                }
                Application::$app->model->setTable('shots');
                Application::$app->model->alterOne(['id' => $shotId], ['title' => $shot->title, 'description' => $shot->description, 'image' => $shot->image]);
                Application::$app->response->redirect("/shots/".$shotId);
            }
        }
        return $this->render('edit', [
            'model' => $shot,
            'fileModel' => $file
        ]);
    }

    public function delete($request, $path){
        Application::$app->model->setTable('shots');
        $shotId = $path[0];
        Application::$app->model->setTable('shots');
        $shot = Application::$app->model->findOne(['id' => $shotId]);
        if($shot){
            Application::$app->model->removeOne(['id' => $shotId]);
            Application::$app->session->setFlash('success', "Post removed");
        }
        Application::$app->response->redirect("/user/".Application::$app->user->id);
    }
}