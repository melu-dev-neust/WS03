<?php
    namespace Framework;
    use App\Controllers\ErrorController;

    class Router {
        protected $routes=[];

        /**ask what type of request*/
        public function setRoute($method, $uri, $action){
            list($controller,$controllerMethod) = explode('@',$action);
        

            $this->routes[] = [
                'method'=>$method,
                'uri'=>$uri,
                'controller'=>$controller,
                'controllerMethod'=>$controllerMethod    
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

        /**Route the request */
        public function route($uri){
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            foreach($this->routes as $route){
                //Split the current URI into segments
                $uriSegments = explode('/',trim($uri,'/'));

                //Split the route
                $routeSegments =  explode('/',trim($route['uri'],'/'));
                $match = true;

                if(count($uriSegments) === count($routeSegments)&&strtoupper($route['method']===$requestMethod)){
                    $params=[];
                    $match=true;
                    for($i=0; $i<count($uriSegments);$i++){
                        //if the URI do not match and there is no value between the {id} 
                        if($routeSegments[$i] !== $uriSegments[$i] && !preg_match('/\{(.+?)\}/',$routeSegments[$i])){
                            $match = false;
                            break;
                        }
                        //check for param and add to $params array
                        if(preg_match('/\{(.+?)\}/', $routeSegments[$i], $matches)){
                            $params[$matches[1]]=$uriSegments[$i];
                        }
                    }
                    if($match){
                              //extract controller and controller method
                        $controller = 'App\\Controllers\\'.$route['controller'];
                        $controllerMethod = $route['controllerMethod'];

                        //instantiate controller class
                        $controllerInstance = new $controller();
                        $controllerInstance->$controllerMethod($params);
                        return;
                    }
                }

                    // if($route['uri'] === $uri && $route['method'] === $method){
                  
                    // }
            }
            ErrorController::notFound();
        }
 
    }
    //------old route------ -

    // if(array_key_exists($uri,$routes)){ 
    //     require(basePath($routes[$uri]));
    // }else{
    //     require basePath($routes['404']);
    // }

?>