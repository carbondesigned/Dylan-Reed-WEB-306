<?php

class Category
{
    private $id;
    private $cat;

    public static function all()
    {
        global $dbc;
        $sql = "SELECT * FROM `categories`";
        $categories = $dbc->fetchArray($sql);
        if (!$categories) {
            return [];
        }

        foreach ($categories as $category) {
            $categoryObjArray[] = new Self(
                $category['id'],
                $category['cat']
            );
        }

        return $categoryObjArray;
    }
    public static function find($sql, $bindVal)
    {
        /*
        Within the find method, use the global keyword to import the $dbc variable. This will import the active PDO database connection so we may use it within the method. 
        
        Execute the SQL query using the active database connection $dbc. 
        
        Use the fetchArray method you created in v1.0. Provide the SQL statement from the method parameter as the first argument and the array of bindings as the second argument to the fetchArray method. 
        
        Store the results in a variable called $categories. 
        
        Create a conditional statement ( if ) to check if the variable $categories is equal to Boolean false. 
        
        If so, return [] (empty array) from the method.  
        
        Close the if statement. We can assume at this point that there were category records returned from the fetchArray method. 
        
        Create a foreach loop. Use the $categories variable as the array expression and $category as the value. 
        
        Within the foreach loop, instantiate a new object of category class (remember we can use the self keyword). Provide the values to the constructor from the associative array $category. 
        
        Store the new object in an array called $categoryObjArray[]. 
        
        Hint: we can use the PHP short form for array creation: $arrayName[] = value 10. After the foreach loop, use the return statement to return the array of category objects stored in $categoryObjArray.

        */

        global $dbc;
        $res = $dbc->fetchArray($sql, $bindVal);
        if ($res == false) {
            return [];
        } else {
            $categoryObjArray = [];
            foreach ($res as $category) {
                $categoryObjArray[] = new Category($category['id'], $category['cat']);
            }
            return $categoryObjArray;
        }
    }
    public function __construct($id, $cat)
    {
        $this->id = $id;
        $this->cat = $cat;
    }
    public function create()
    {
        global $dbc;
        $sql = "INSERT INTO `categories` (cat) VALUES (:cat)";
        $bindVal = ['cat' => $this->cat];
        return $dbc->sqlQuery($sql, $bindVal);
    }

    public function getId()
    {
        return $this->id;
    }
    public function setId($id)
    {
        $this->id = $id;
    }
    public function getCat()
    {
        return $this->cat;
    }
    public function setCat($cat)
    {
        $this->cat = $cat;
    }
}
