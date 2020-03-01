<?php

session_start();

//CONNECT DATABASE
$mysqli = new mysqli('localhost', 'root', '', 'todolist') or die(mysqli_error($mysqli));


//VARIABLES
$id = 0;
$update = false;
$task = '';
$date = '';
$done = 0;

//SAVE TASK TO DATABASE
if (isset($_POST['save'])) {
    if ((empty($_POST['task'])) && (empty($_POST['date']))) {
        $_SESSION['message'] = "You must fill in the task and date!";
        $_SESSION['msg_type'] = "danger";
        //echo "You must fill in the date and task";	
        header("location: ../index.php");
    } else if (empty($_POST['date'])) {
        $_SESSION['message'] = "You must fill in the date!";
        $_SESSION['msg_type'] = "danger";
        //echo "You must fill in the date";
        header("location: ../index.php");
    } else if (empty($_POST['task'])) {
        $_SESSION['message'] = "You must fill in the task!";
        $_SESSION['msg_type'] = "danger";
        //echo "You must fill in the task";
        header("location: ../index.php");
    } else {
        $task = $_POST['task'];
        $date = $_POST['date'];
        $mysqli -> query("INSERT INTO todolist (Task, Date) VALUES ('$task', '$date')") or
        die($mysqli -> error);

        $_SESSION['message'] = "Task has been saved!";
        $_SESSION['msg_type'] = "success";

        header("location: ../index.php");
    }
}


//DELETE TASK FROM DATABASE
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli -> query("DELETE FROM todolist WHERE ID='$id'") or die($mysqli -> error());

    $_SESSION['message'] = "Task has been deleted!";
    $_SESSION['msg_type'] = "danger";

    header("location: ../index.php");
}

//EDIT TASK IN DATABASE
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $mysqli -> query("SELECT * FROM todolist WHERE ID='$id'") or die($mysqli -> error());
    if ($result -> num_rows) {
        $row = $result -> fetch_array();
        $task = $row['Task'];
        $date = $row['Date'];
    }
}

//EDIT DATA IN DATABASE
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $task = $_POST['task'];
    $date = $_POST['date'];

    $mysqli -> query("UPDATE todolist SET Task='$task', Date='$date' WHERE ID='$id'") or
    die($mysqli -> error);

    $_SESSION['message'] = "Task has been updated!";
    $_SESSION['msg_type'] = "success";

    header('location: ../index.php');
}

//MARK TASK AS DONE
if (isset($_GET['done'])) {
    $id = $_GET['done'];
    $mysqli -> query("UPDATE todolist SET Done=1 WHERE ID='$id'") or die($mysqli -> error());

    $_SESSION['message'] = "Task is done!";
    $_SESSION['msg_type'] = "success";

    header("location: ../index.php");
}

//MARK DONE TASK AS UNDONE
if (isset($_GET['undone'])) {
    $id = $_GET['undone'];
    $mysqli -> query("UPDATE todolist SET Done=0 WHERE ID='$id'") or die($mysqli -> error());

    $_SESSION['message'] = "Task is undone!";
    $_SESSION['msg_type'] = "secondary";

    header("location: ../index.php");
}
?>