<?php #Do autoloading

namespace app\core;

require_once "Router.php";
require_once "Controller.php";

class Application{
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public static Application $app;
    public Controller $controller;
    public static View $view;
    public function getController(){
        return $this->controller;
    }
    public function setController(Controller $controller){
        $this->controller = $controller;
    }
    public function __construct($rootPath, array $config){
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        self::$view = new View();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
        
    }
    public function run(){
        echo $this->router->resolve();
    }
}
