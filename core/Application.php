<?php

namespace app\core;

class Application{
    public static string $ROOT_DIR;
    public static string $DOMAIN_NAME;
    public static $config = [];
    public $userClass;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public static Application $app;
    public Controller $controller;
    public static View $view;
    public Session $session;
    public Service $service;
    public $user;
    public $model;
    public Mailer $mailer;
    public $templates;
    public function getController(){
        return $this->controller;
    }
    public function setController(Controller $controller){
        $this->controller = $controller;
    }
    public function __construct($rootPath, array $config){
        self::$config = $config;
        self::$DOMAIN_NAME = $config['domainName'];
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        self::$view = new View();
        $this->session = new Session();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        $this->mailer = new Mailer();
        $model = $config['model'];
        $classesArgs = $config['modelClasses'];
        $this->model = new $model($classesArgs);
        $this->service = new Service();
        $templateArgs = $config['templateClasses'];
        $this->templates = new Templates($templateArgs);
    }

    public function run(){
        echo $this->router->resolve();
    }
}
