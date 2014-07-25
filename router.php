<?php

// If the action parameter is set, we assume that this is an AJAX request
if (isset($_GET['action'])) {
    // Set the header so that the client knows that we are communicating with JSON 
    header("Content-Type: application/json");
    
    // Make the database connection and die if it doesn't connect
    $connection = mysqli_connect(MYSQL_HOST, MYSQL_USER, 
        MYSQL_PASSWORD, MYSQL_DATABASE) 
        or die("Could not connect to MySQL database: {$connection->connect_error}");
    
     //Show all tasks   
    if ($_GET['action'] == 'list'
            && $_SERVER['REQUEST_METHOD'] == 'GET') {
          
        $allTasks = array();
        $sort = "dateCreated";
        $showTasks = "WHERE completed=0";
        
        //Show only completed
        if($_GET['showtasks'] == 'true'){
         $showTasks = "";   
        }
        //Show tasks in priority order
        if($_GET['priority'] == 'true'){
         $sort = "priority DESC";   
        }
        
        $query = "SELECT * FROM task {$showTasks} ORDER BY {$sort}"; 

        $result = mysqli_query($connection, $query) or
                die("Can't execute query " . $query);
        
        while($row = mysqli_fetch_array($result)){
            
         $task = array(
                'id' => $row['id'],
                'label' => $row['label'],
                'dateCreated' => $row['dateCreated'],
                'completed' => $row['completed']                 
            );
         
          if($row['completed'] == '0') {
            $task['dateCompleted'] = "-"; 
          } else {
             $task['dateCompleted'] = $row['dateCompleted']; 
          }
          
          switch ($row['priority']) {
              case(1):
                $task['priority'] = "Very Low";
                  break;
              case(2):
                $task['priority'] = "Low";
                  break;  
              case(3):
                $task['priority'] = "Medium";
                  break;    
              case(4):
                $task['priority'] = "Important";
                  break;   
              case(5):
                $task['priority'] = "Very Important";
                  break;                
          } 
          array_push($allTasks, $task);  
        }    
        echo json_encode($allTasks);
    }
    //Delete task from Db
    else if ($_GET['action'] == 'delete'
            && $_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $taskId = $_POST['taskId'];
        
        $query="DELETE FROM task
            WHERE id={$taskId}";
            
        mysqli_query($connection, $query) or 
            die("Can't execute query " . $query);
        
        echo true;
    }
     //Update competed task in the Db
    else if ($_GET['action'] == 'complete'
            && $_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $taskId = $_POST['taskId'];
        
        $query="UPDATE task
            SET completed=1,dateCompleted=CURRENT_TIMESTAMP 
            WHERE id={$taskId}";
            
        mysqli_query($connection, $query) or 
            die("Can't execute query " . $query);
        
        echo true;  
    }
    //Create new task in the Db
    else if ($_GET['action'] == 'new'
            && $_SERVER['REQUEST_METHOD'] == 'POST') {
                        
        $label = trim(strip_tags($_POST['taskLabel']));
        $priority = trim(strip_tags($_POST['taskPriority']));
                
        $query = "INSERT INTO task (label, priority)
            VALUES ('{$label}', '{$priority}')";
            
        mysqli_query($connection, $query) or 
                die("Can't execute query " . $query);
        echo true;
    }
    
    mysqli_close($connection);
}
// If it's not an AJAX request, then return the main page
else {
    include('views/mainpage.php');
}

?>
