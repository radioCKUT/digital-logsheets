<?php
    //----INCLUDE FILES----
    include("smarty/libs/Smarty.class.php");
    include("dev-mode.php");
    include("database.php");
    require_once("objects/logsheet-classes.php");
    
    // create object
    $smarty = new Smarty;
    
    //database interactions
    try {
    
        //connect to database
        $db = connectToDatabase();
        
        $categories = array();
        $programs = array();
        
        $category_ids = getIds($db, "category");
        foreach($category_ids as $category_id) {
            $category = new Category($db);
            
            $category->setId($category_id);
            $categories[$category->getId()] = $category->getName();
        }
        
        $program_ids = getIds($db, "program");
        foreach($program_ids as $program_id) {
            $program = new Program($db);
            $program->setId($program_id);
            $programs[$program->getId()] = $program->getName();
        }
        
        //close database connection
        $db = NULL;
        
        //assign categories to smarty variable
        $smarty->assign("programs", $programs);
        
        //assign categories to smarty variable
        $smarty->assign("categories", $categories);
        
        // display it
        echo $smarty->fetch('new-logsheet.tpl');
    } catch(PDOException $e) {
        echo 'ERROR: ' . $e->getMessage();
    }
    
    //get an array of all the ids in a table
    function getIds($db, $table) {
        $sql = "SELECT id FROM " . $table;
        $stmt = $db->prepare($sql);
        $stmt->execute();
        
        //get an array of objects, each with an id attribute
        $id_objects = $stmt->fetchAll(PDO::FETCH_OBJ);
        
        $ids = array();
        
        //store each id attribute into an array as String datatypes
        foreach($id_objects as $id_obj) {
            array_push($ids, $id_obj->id);
        }
        
        return $ids;
    }
?>