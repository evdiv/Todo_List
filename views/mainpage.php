<!DOCTYPE HTML>
<html>
    <head>
        <title>TODO List</title>
        <script src="../js/jquery.min.js"></script>
        <script src="../js/script.js"></script>
        <link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <link href="../css/style.css" rel="stylesheet" type="text/css">
    </head>
    <body>
    <div class="row">
       <div class="col-md-3"></div>
       <div class="col-md-6">  
           
            <h1>My task list</h1>         
    <div class="row">
           <div class="col-md-2"></div>
           <div class="col-md-4">
               
           <h2>Tasks to Display</h2>
                <input class="aas" type="radio" name="display" id="allTasks"/> Show all <br />
                <input class="aas" type="radio" name="display" id="incompleTasks" />  Show incomplete only
            </div>
           
            <div class="col-md-1"></div>
            
            <div class="col-md-4">
                <h2>Sort Order</h2> 
                <input class="aas" type="radio" name="sort" id="dateSort"/> Sort by date created <br />
                <input class="aas" type="radio" name="sort" id="prioritySort" />  Sort by priority
            </div>
    </div>  
            
    <p>&nbsp;</p>   
    <p>&nbsp;</p>
    
        <table id="taskList" class="table table-hover">
            <tr>
                <th>&nbsp;</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Date Created</th>       
                <th>Date Completed</th>                    
            </tr>      
        </table>
       
        <div id="controlButtons">
           <input type="button" id="buttonComplete" class="btn btn-success" value="Complete selected" />  
           <input type="button" id="buttonDelete" class="btn btn-danger" value="Delete selected" /> 
        </div>
    
    <p>&nbsp;</p>
        
    <div class="row">  
         <div class="col-md-6">
           <h2>Add new task</h2>
           <form name="addTask" id="addTask" role="form">
                    
              <div class="form-group">
                   <label for="taskLabel">Task Description</label>
                   <input type="text" class="form-control" name="taskLabel" id="taskLabel" placeholder="Task description">
              </div>
                    
              <div class="form-group">
                   <label for="taskPriority">Task Priority</label>
                   <select name="taskPriority" class="form-control">
                       <option value="1">Very Low</option>
                       <option value="2">Low</option>
                       <option value="3">Medium</option>
                       <option value="4">Important</option>
                       <option value="5">Very Important</option>                
                    </select>
             </div>
                  
             <div class="form-group">
                    <input type="button" id="buttonSubmit" class="btn btn-primary" value="Submit" />
             </div>                
           </form>
              
         </div>
      </div>
      </div>
            <div class="col-md-3"></div>
    </div>
    </body>
</html>
