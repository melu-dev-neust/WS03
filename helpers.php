<?php  
 
/**
*Get the oath
*@param string $path
*return string
**/

function basePath($path=''){
    return __DIR__.'/'.$path;
}


/**
 * load view
 * @param string $name
 * @return void;
 */
 
function viewPartials($name, $data = []){
    $partialPath= basePath("App/views/{$name}.view.php");
    
    if(file_exists($partialPath)){
        extract($data);
        
        require $partialPath;
    }else{
        echo "View {$name} not found :(";
    }
}


function loadPartials($name){
    $partialPath = basePath("App/views/partials/{$name}.php");
    
    if(file_exists($partialPath)){
        require $partialPath;
    }else{
        echo "Partial {$name} not found :(";
    }
}


function inspect($value){
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

function formatSalary($salary){
    return '$'.number_format(floatval($salary));
}





?>