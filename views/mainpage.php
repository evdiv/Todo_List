<!DOCTYPE HTML>
<html>
    <head>
        <title>TODO List</title>
        <script src="js/jquery.min.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css"> 
        <script>
            
            //Add single task to the DOM    
            var addTask = function(task) {
                var singleTd = "<td><input type='checkbox' class='controls' id='task_" + task.id + "'></td>" +
                               "<td>" + task.label + "</td>" +
                               "<td>" + task.priority + "</td>" +
                               "<td>" + task.dateCreated + "</td>" +    
                               "<td class='dateCompleted'>" + task.dateCompleted + "</td>";
                var trClass = "active data";       
                if(task.completed === '1'){trClass = "success data";};
                
                var singleRow = $("<tr>")
                       .addClass(trClass)
                       .append(singleTd);       
                                              
                $("#taskList").append(singleRow);
            }
            
            //Post the data from the Form to the router
            var newTask = function(){                                        
               var queryUrl = "index.php?action=new";
                         
               $.post(queryUrl, $('#addTask').serialize(), function(){
                    getAll();                   
               });
            }
            
            //Retrieves all tasks
            var getAll = function() {
                
            $('tr.data').empty();
            
            var showTasks ="false"; 
            var prioritySort = "false";
           
               if($('#allTasks').is(':checked')) { 
                  showTasks ="true"; 
               }               
               if($('#prioritySort').is(':checked')) { 
                  prioritySort = "true"; 
               }

            var queryUrl = "index.php?action=list&showtasks=" + showTasks +"&priority=" + prioritySort;
            
            $.get(queryUrl, function(e) {
                    for (var i = 0; i < e.length; i++)
                        addTask(e[i]);
                });  
            }
            
            //Post id of completed task
            var complete = function(id) {
                
                $.post('index.php?action=complete', "taskId=" + id, function() {
                    // For make our app works faster we don't refresh page on this stage.
                    //getAll();
                });                               
            };
            
            //Delete task from the Db
            //Task hasn't exist in the DOM so we don't refresh it.
            var deleteTask = function(id) {
                $.post('index.php?action=delete', "taskId=" + id, function() {
                });                
            }
            
            
            $(document).ready(function() {
               // Start the application by getting all tasks
                getAll();
                
               //Refresh the task list if user click any radio button
                $('input.aas').click(function(){
                    getAll();
                });
                
                //If user chooses some tasks as completed find them 
                $('#buttonComplete').click(function(){
                   
                    $("input[class='controls']").each(function(){
                      var $this = $(this);
                      var $tr = $this.parent().parent();
                      if($this.is(':checked')){
                          if($tr.hasClass('active')){
                              
                              //For increasing speed of the app 
                              //change representation of the task in the DOM 

                              //If radio button allTasks checked we change color of the tr and add current time
                              if($("#allTasks").is(':checked')){
                                $tr.removeClass('active');
                                $tr.addClass('success');  
                                
                                //Get current time
                                var curDate = new Date();
                                var dd = curDate.getDate();
                                var mm = curDate.getMonth()+1; 
                                var yyyy = curDate.getFullYear();
                                var hh = curDate.getHours();    
                                var min = curDate.getMinutes();
                                var sec = curDate.getSeconds();
                                
                                if(dd<10) { dd = '0'+dd;} 
                                if(mm<10) { mm = '0'+mm;} 
                                if(hh<10) { hh = '0'+hh;} 
                                if(min<10) { min = '0'+min;} 
                                if(sec<10) { sec = '0'+sec;}    
                                
                                curDate = yyyy+ '-' +mm+ '-' +dd+ ' ' +hh+ ':' +min+ ':' +sec;
                                $tr.children( ".dateCompleted" ).text(curDate);                             
                              }
                              
                              //If radio button incompleTasks checked we remove tr from the DOM
                              if($("#incompleTasks").is(':checked')){
                                $tr.remove();
                              }
                              
                              //Send data about task to the complete()function
                              var taskId = $this.attr('id').slice(5);
                              complete(taskId);   
                          }
                      }
                    });    
                });
                
                //If user chooses some tasks as deleted find them 
                //and delete tasks from the DOM to make our app faster
                $('#buttonDelete').click(function(){
                   
                    $("input[class='controls']").each(function(){
                      var $this = $(this);
                      if($this.is(':checked')){
                          
                       var taskId = $this.attr('id').slice(5);                     
                       deleteTask(taskId);
                       //delete task from the list
                       $this.parent().parent().empty();  
                       }           
                    });               
                });
                
                //Check the form, if not empty send data and clear the input field
                $('#buttonSubmit').click(function(){
                    if(!$('input:text').val()){
                       $('#taskLabel').parent().addClass('has-error');
                    } else {               
                        newTask();
                        $('input:text').val(''); 
                        $('#taskLabel').parent().removeClass('has-error');
                    }
                });              
            });
        </script>
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
