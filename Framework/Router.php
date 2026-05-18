<?php
    namespace Framework;
    use App\Controllers\ErrorController;
    use Framework\Middleware\Authorize;

    class Router {
        protected $routes=[];

        /**ask what type of request*/
        public function setRoute($method, $uri, $action, $middleware=[]){
            list($controller,$controllerMethod) = explode('@',$action);
        

            $this->routes[] = [
                'method'=>$method,
                'uri'=>$uri,
                'controller'=>$controller,
                'controllerMethod'=>$controllerMethod,    
                'middleware'=>$middleware 
            ];
        }
        
    
        public function get($uri, $controller, $middleware=[]){
            $this->setRoute('GET',$uri,$controller,$middleware);
        }
        public function post($uri, $controller,$middleware=[]){
            $this->setRoute('POST',$uri,$controller,$middleware);
        }
        public function put($uri, $controller,$middleware=[]){
            $this->setRoute('PUT',$uri,$controller,$middleware);
        }
        public function delete($uri, $controller,$middleware=[]){
            $this->setRoute('DELETE',$uri,$controller,$middleware);
        }

        /**Route the request */
        public function route($uri){
            $requestMethod = $_SERVER['REQUEST_METHOD'];
            
            //check for  _method input
            if($requestMethod === 'POST' && isset($_POST['_method'])){
                // override the request method with the value of _method
                $requestMethod = strtoupper($_POST['_method']);
            }
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
                        foreach($route['middleware'] as $middleware){
                            (new Authorize())->handle($middleware);

                        }
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