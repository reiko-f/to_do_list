<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Comfortaa&display=swap');

        body {
            font-family: 'Comfortaa', sans-serif;
            color: gray;
            background-color: lavenderblush;

        }
    </style> 
    <title>To Do Connection</title>
</head>
<body>
    <?php

        session_start();

        $connect = new mysqli('localhost', 'root', '', 'todo_db') or die(mysqli_error($connect));

        $update = FALSE;
        $log_id = 0;
        $task = '';
        $description = '';
        $due_date = '';

        if (isset($_POST['save'])) {
            $task = $_POST['task'];
            $description = $_POST['description'];
            $date_array = explode('/', $_POST['due_date']);
            $due_date = $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1]; 

            $query = "INSERT INTO todo (TASK, DESCRIPTION, DUE_DATE) VALUES('$task', '$description', '$due_date')";
            $connect -> query($query) or die($connect -> error);

            $_SESSION['message'] = 'Saved!';
            $_SESSION['msg_type'] = 'success';
            // echo "Saved!";

            header('location: todo.php');

        }

        if (isset($_GET['delete'])) {
            $log_id = $_GET['delete'];
            $connect -> query("DELETE FROM todo WHERE LOG_ID = $log_id;") or die($connect -> error);
            // echo "Deleted";

            $_SESSION['message'] = 'Deleted';
            $_SESSION['msg_type'] = 'danger';

            header('location: todo.php');

        }

        if (isset($_GET['edit'])) {
            $log_id = $_GET['edit'];
            $update = TRUE;
            $result = $connect -> query("SELECT * FROM todo WHERE LOG_ID = $log_id;") or die($connect -> error);

            if ($result) {
                $row = $result -> fetch_array();
                $task = $row['TASK'];
                $description = $row['DESCRIPTION'];
                $due_date = $row['DUE_DATE'];
            }            
        }

        if (isset($_POST['update'])) {
            $task = $_POST['task'];
            $description = $_POST['description'];
            $date_array = explode('/', $_POST['due_date']);
            $due_date = $date_array[2] . '-' . $date_array[0] . '-' . $date_array[1]; 

            $query = "UPDATE todo SET TASK = '$task', DESCRIPTION = '$description', DUE_DATE = '$due_date' WHERE LOG_ID = '$log_id'";
            $connect -> query($query) or die($connect -> error);

            $_SESSION['message'] = 'Updated';
            $_SESSION['msg_type'] = 'warning';

            header('location: todo.php');
        }

    ?>
</body>
</html>