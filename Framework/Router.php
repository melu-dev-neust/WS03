<?php
    // $routes = require basePath('routes.php');
    namespace Framework;

    class Router {
        protected $routes=[];

        /**ask what type of request*/
        public function setRoute($method, $uri, $controller){
            $this->routes[] = [
                'method'=>$method,
                'uri'=>$uri,
                'controller'=>$controller
            ];
        }
        
    
        public function get($uri, $controller){
            $this->setRoute('GET',$uri,$controller);
        }
        public function post($uri, $controller){
            $this->setRoute('POST',$uri,$controller);
        }
        public function put($uri, $controller){
            $this->setRoute('PUT',$uri,$controller);
        }
        public function delete($uri, $controller){
            $this->setRoute('DELETE',$uri,$controller);
        }

        public function error($httpCode=404){
            http_response_code($httpCode);
            viewPartials("error/{$httpCode}");
            exit;
        }

        /**Route the request */
        public function route($uri, $method){
            foreach($this->routes as $route){
                if($route['uri'] === $uri && $route['method'] === $method){
                    require basePath('App/'.$route['controller']);
                    return;
                }
            }
            $this->error(404);
        }
 
    }
    //------old route------ -

    // if(array_key_exists($uri,$routes)){ 
    //     require(basePath($routes[$uri]));
    // }else{
    //     require basePath($routes['404']);
    // }

?>