<?php
namespace App\Controllers;
use Framework\Database;
use Framework\Validation;
use Framework\Session;
use Framework\Authorization;

class ListingsController{
    
    protected $db;

    public function __construct(){         
        $config = require basePath('config/db.php');
        $this->db = new Database($config);
    }
    
    public function index(){
        
        $listings = $this->db->query('SELECT * FROM listings ORDER BY created_at DESC')->fetchAll();
        viewPartials('listings/index',['k_listings'=>$listings]);
    }

    public function create(){
        viewPartials('listings/create');

    }
    public function show($params){
        $id = $params['id'] ?? '';
        $params=[
            'id'=>$id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id',$params)->fetch();

        //Check if listing exist
        if(!$listing){
            ErrorController::notFound('Listing not found :(');
            return;
        }
        viewPartials('listings/show',['listing'=>$listing]);

    }

     /**
     * Store data in database
     * 
     * return void
     */
    public function store(){

        $allowedFields =[
            'title','description','salary','tags',
            'company','address','city','state','phone'
            ,'email','requirements','benefits'
        ];
        $newListingData = array_intersect_key($_POST, array_flip($allowedFields));
        
        // inspectAndDie(Session::get('user'));
        
        $newListingData['user_id'] = Session::get('user')['id'];  

        $newListingData = array_map('sanitize',$newListingData);

        $requiredFields = ['title','description','salary','email','city','state'];
        $errors = [];

        foreach ($requiredFields as $field){
            if(empty($newListingData[$field]) || !Validation::string($newListingData[$field])){
                $errors[$field] = ucfirst($field).' is required';
        }
        }
        if (!empty($errors)){
            //reload view with error
            viewPartials('listings/create',[
                'errors'=>$errors,
                'listing'=>$newListingData
                ]);
        }else{
            //Submit Data

            // $this->db->query('
            // INSERT INTO listings (title, description, salary, tags, company, address, city, state, phone, email, requirements, benefits, user_id)
            // VALUES (:title, :description, :salary, :tags, :company, :address, :city, :state, :phone, :email, :requirements, :benefits, :user_id)', $newListingData);
            $fields = [];

            foreach($newListingData as $field => $value){
                $fields[] = $field;

            }
            $fields = implode(', ',$fields);

            $value = [];

            foreach($newListingData as $field => $value){
                //convert empty string to null
                if($value === ''){
                    $newListingData[$field] = null;
                }
                $values[] = ':' . $field;
            }
            $values = implode(', ',$values);

            $query = "INSERT INTO listings ({$fields}) VALUES ({$values}) ";
            $this->db->query($query, $newListingData);
            redirect('/listings');
            
        }
    }
    /**
     * Delete a listing
     * 
     * @param array $params
     * 
     * return void
     */

    public function destroy($params){
        $id = $params['id'];
        $params = [
            'id'=>$id
        ];
        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id', $params)->fetch();

        //Check if listing exist
        if(!$listing){
            ErrorController::notFound('Listing not found :(');
            return;
        }
        //Authorization
        if(!Authorization::isOwner($listing->user_id)){
            $_SESSION['error_message']='You are not authorize to delete this listing';
            return redirect('/listings/'.$listing->id);
        }

        $this->db->query('DELETE FROM listings WHERE id = :id', $params);

        //set flash message
        $_SESSION['success_message'] = 'Listing Deleted Successfully';
        redirect('/listings');
    }


    public function edit($params){
        $id = $params['id'] ?? '';
        $params=[
            'id'=>$id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id',$params)->fetch();

        //Check if listing exist
        if(!$listing){
            ErrorController::notFound('Listing not found :(');
            return;
        }
        viewPartials('listings/edit',['listing'=>$listing]);

    }

    /**
     * Update listing
     * 
     * @params array
     * return variant
     */
    public function update($params){
        $id = $params['id'] ?? '';
        $params=[
            'id'=>$id
        ];

        $listing = $this->db->query('SELECT * FROM listings WHERE id = :id',$params)->fetch();

        //Check if listing exist
        if(!$listing){
            ErrorController::notFound('Listing not found :(');
            return;
        }
        $allowedFields =[
            'title','description','salary','tags',
            'company','address','city','state','phone'
            ,'email','requirements','benefits'
        ];
        $updatedValues = [];
        $updatedValues = array_intersect_key($_POST, array_flip($allowedFields));
        $updatedValues = array_map('sanitize',$updatedValues);

        $requiredFields = ['title','description','salary','email','city','state'];
        $errors = [];
        foreach($requiredFields as $field){
            if(empty($updatedValues[$field])||!Validation::string($updatedValues[$field])){
                $errors[$field] = ucfirst($field).' is Required';
            }
        }
        if(!empty($errors)){
            viewPartials('listings/edit',[
                'listing'=>$listing,
                'errors'=>$errors
            ]);
        }else{
            //Submit to DB
            $updateFields=[];
            foreach(array_keys($updatedValues) as $field){
                $updateFields[]="{$field}=:{$field}";
                // inspect($field);
            }
            $updateFields = implode(', ',$updateFields);
            $updateQuery = "UPDATE listings SET $updateFields WHERE id = :id";


            //inspectAndDie($updatedValues);

            $updatedValues['id'] = $id;
            $this->db->query($updateQuery, $updatedValues);

            $_SESSION['success_message'] = 'Listing Updated';
            redirect('/listings/'.$id);


        }
        // inspectAndDie($errors);

    }



}
?>