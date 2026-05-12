<?php
namespace App\Controllers;

class ErrorController{
    
    public static function notFound($message='Page Not Found :('){
        http_response_code(404);

        viewPartials('error',[
            'status'=>'404',
            'message'=>$message
        ]);
    }

    public static function unautorized($message='Your are not Autorized to view this page >:('){
        http_response_code(403);

        viewPartials('error',[
            'status'=>'403',
            'message'=>$message
        ]);
    }




}

?>