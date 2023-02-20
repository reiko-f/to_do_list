<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Comfortaa&display=swap');

            body {
                margin: 25px;
                font-family: 'Comfortaa', sans-serif;
                color: gray;
                background-color: #FAF884;
            }
        </style> 
        <title>To Do List</title>
    </head>
    <body>
        <?php require_once "process_todo.php"; ?>

        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?=$_SESSION['msg_type']?>">

                <?php
                    echo $_SESSION['message'];
                    unset($_SESSION['message']);

                ?>
            </div>
        <?php endif; ?>
        
        <?php 
            $connect = new mysqli('localhost', 'root', '', 'todo_db') or die(mysqli_error($connect));
            
            $sql = "SELECT * FROM todo;";

            $result = $connect -> query($sql) or die($connect -> error);
        ?>                
          
        <h1>To Do List</h1>
        <div class="row justify-content-center">
            <table class="table">
                <thead>
                    <tr>
                        <th>TASK</th>
                        <th>DESCRIPTION</th>
                        <th>DUE DATE</th>
                        <th colspan="3">Action</th>
                    </tr>
                </thead>

                <?php
                    while ($row = $result -> fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['TASK']}</td>
                            <td>{$row['DESCRIPTION']}</td>
                            <td>{$row['DUE_DATE']}</td>
                            <td>
                                <a href=\"todo.php?edit={$row['LOG_ID']}\" style='background:#57E964'name=\"edit\" class=\"btn btn-info\">Edit</a>
                                <a href=\"process_todo.php?delete={$row['LOG_ID']}\" style='background:#F67280' name=\"delete\" class=\"btn btn-danger\">Delete</a>
                            </td>                      
                        </tr>";
                    }; 

                ?>
            </table>
        </div>     

        <?php
            pre_r(($result) -> fetch_assoc());

            function pre_r($array) {
                echo "<pre>";
                print_r($array);
                echo "</pre>";
            };
        ?>

        <div class="row justify-content-center">
            <form action="process_todo.php" method="POST">
                <input type="hidden" name="log_id" value="<?php echo $log_id; ?>">
                <div class=form-group>
                    <label for="task">Task: </label>
                    <input type="text" name="task" value="<?php echo $task; ?>" class="form-control" placeholder="type a task">
                </div>
                <div class=form-group>
                    <label for="description">Description: </label>
                    <input type="text" name="description" value="<?php echo $description; ?>" class="form-control" placeholder="description">
                </div>
                <div class=form-group>
                    <label for="due_date">Due Date: </label>
                    <input type="text" name="due_date" value="<?php echo $due_date; ?>" class="form-control" placeholder="due_date">
                </div><br>
                <div class=form-group>
                    <?php
                        if ($update == TRUE): ?>
                            <button type="submit" name="update" class="btn btn-info">Update</button>
                    <?php 
                        else: ?>                        
                            <button style='background:#00BFFF' type="submit" name="save" class="btn btn-primary">Save</button>
                    <?php endif ?>
                </div>   
            </form>
        </div>
        
        
    </body>
</html>

