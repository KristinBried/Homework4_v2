<?php require_once 'php/process.php'; ?>

<!DOCTYPE html>
<html>
<head>
    <title>To do list app</title>
    <script src="script\jquery-3.4.1.min.js"></script>
    <script src="script\bootstrap.min.js"></script>
    <script src="script\script.js"></script>
    <link rel="stylesheet" type="text/css" href="css\bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css\bootstrap.min.css.map">
    <link rel="stylesheet" type="text/css" href="css\style.css">
    <link href="https://fonts.googleapis.com/css?family=Reenie+Beanie&display=swap" rel="stylesheet">
</head>

<body>
    <a id="top"></a>
        <div>
                <div class="landing-page">
                    <h1>What do you want to do?</h1>
                    <div class="row justify-content-center input-fields">
                        <form action="php/process.php" method="POST">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="form-group">
                                <label>Task</label>
                                <input type="text" name="task" class="form-control" value="<?php echo $task; ?>">
                            </div>
                            <div class="form-group">
                                <label>When do you want to do that?</label>
                                <input type="date" name="date" value="<?php echo $date; ?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <?php 
                                //IF SELECT UPDATE BUTTON - BUTTON TEXT CHANGES TO "UPDATE"
                                if ($update == true): 
                                ?>
                                    <button type="submit" class="btn btn-info submit-button glow-on-hover" name="update">Update</button>
                                    <?php else: ?>
                                        <button type="submit" class="btn btn-primary submit-button glow-on-hover" name="save">This is what I want to do!</button>
                                    <?php endif; ?>
                            </div>
                        </form>
                    </div>
                    <!-- ALERT MESSAGE PART -->
                    <div class="alert-message">
                        <?php if (isset($_SESSION['message'])): ?>
                            <div class="alert alert-<?=$_SESSION['msg_type']?>">
                                <?php 
                                echo $_SESSION['message']; 
                                unset($_SESSION['message']);
                                ?>
                            </div>
                            <?php endif ?>
                    </div>
                </div>
                <!-- OUTPUT TABLE -->
                <div class="row justify-content-center">
                    <table class="table-dark table-striped table-hover">
                        <thead class="thead-light">
                            <a name="table"></a>
                            <tr>
                                <th width="5%">Nr</th>
                                <th width="10%">Is it done?</th>
                                <th width="15%">Date</th>
                                <th width="20%">Task</th>
                                <th width="30%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
		        // SELECT ALL TASKS FROM DATABASE 
        $todolist = mysqli_query($mysqli, "SELECT * FROM todolist ORDER BY Done, Date ASC");

                //WHILE LOOP - PRINTS OUT ALL ROWS FROM DATABASE AND GIVES FOLLOWING NUMBER TO EACH
		$i = 1; while ($row = mysqli_fetch_array($todolist)) 
		{ ?>
                                <tr>
                                    <td width:>
                                        <?php echo $i; ?>
                                    </td>
                                    <td>
                                        <?php if ($row ['Done']==0){
                    $filepath= "css/images/not-done.png";
                    echo "<img src=".$filepath.">";
                } else {
                    $filepath= "css/images/done.png";
                    echo "<img src=".$filepath.">";
                }
                ?></td>
                                <td>
                                    <?php echo $row['Date']; ?>
                                </td>
                                <td>
                                    <?php echo $row['Task'];?>
                                <td>
                                    <!-- ACTION BUTTONS -->
                                    <a href="index.php?edit=<?php echo $row['ID']; ?>" class="btn btn-info">Edit</a>
                                    <a href="php/process.php?delete=<?php echo $row['ID']; ?>" class="btn btn-danger">Delete</a>
                                    <a href="php/process.php?done=<?php echo $row['ID']; ?>" class="btn btn-warning">Done</a>
                                    <a href="php/process.php?undone=<?php echo $row['ID']; ?>" class="btn btn-secondary">Undone</a>
                                    </td>
                                </tr>
                    <?php $i++; }
                ?>
                </table>
                </tbody>
                </div>
                <!-- SCROLL BACK TO TOP PART -->
                <a id="back2Top" title="Back to top" href="#">&#10148;</a>

                <!-- FOOTER -->
                <footer>
                    <p>&copy Made by K.Briede </p>
                    <p>2020</p>
                </footer>
</body>