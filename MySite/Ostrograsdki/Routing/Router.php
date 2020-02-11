<?php
namespace Vincent\Routing;
use \AltoRouter;

class Router{
    /*
    *@var AltoRouter
    */
    private $router;
    /*
    *@var string path
    */
    private $viewPath;
    
    public function __construct(string $viewPath)
    {
        $this->viewPath = $viewPath;
        $this->router = new AltoRouter();
    }
    
    
    /*
    *@var urlSet
    *@var urlView
    *@var name
    *use for maping url and 
    *@return self class
    */
    public function getPath (string $urlSet, string $urlView, ?string $name = null) : self 
    {

        $this->router->map('GET', $urlSet, $urlView, $name);
        
        return $this;
    }
    
    public function postPath (string $urlSet, string $urlView, ?string $name = null) : self 
    {
        $this->router->map('POST', $urlSet, $urlView, $name);
        return $this;
    }
    
    public function post_getPath (string $urlSet, string $urlView, ?string $name = null) : self 
    {
        $this->router->map('POST|GET', $urlSet, $urlView, $name);
        return $this;
    }
    
    /**
     * Take a route and generate an url target with as link
     * @param  string $name   [the route name]
     * @param  array  $params [the params if it exists]
     * @return [type]         [string as link]
     */
    public function urlPut (string $name, array $params = []):string
    {
        return $this->router->generate($name, $params);
    }
    
    
    /*
    *@param void
    *use for matching url and 
    *@return self class
    */
    public function run () {
        
        $match = $this->router->match();
        $view  = $match['target'];
        $params = $match['params'];
        $router = $this;
        
        ob_start();
        if($view !== null) {
            require $this->viewPath.'/'.$view.'.php';
        }
        
        else{
        $this->match['name'] = 'ERROR-404';
        require $this->viewPath.'/views/erors/404.php';
        }
        
        $content = ob_get_clean();
        require $this->viewPath.DIRECTORY_SEPARATOR.'/views/elements/default.php';
        return $this;
    }
}
