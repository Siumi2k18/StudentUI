<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <link rel="stylesheet" type="text/css" href="grid-style.css?ts=<?=time()?>">
    <script src="grid-script.js"></script>
    <title>RateMyLab</title>
    <?php
        # check if current question is more than total number of questions
        # if so exit, if not rate the question
        session_start();
        $_SESSION['current_question'] = $_SESSION['current_question'] + 1;
        if($_SESSION['current_question'] > $_SESSION['total_questions']){
            header("Location: exit.php");
            exit;
        }
        # database credentials
        $server = "localhost";
        $username = "root";
        $password = "Singapore47";
        $database = "jcurtis6";
        # database variables - will be established by database team
        $students_table = "Students";
        $student_id_column = "student_id";
        $fname_column = "first_name";
        $lname_column = "last_name";
        $labs_table = "Labs";
        $lab_id_column = "lab_id";
        $crn_column = "crn";
        $instructor_name_column = "instructor_name";
        $semester_column = "semester";
        $course_title_column = "course_title";
    ?>
</head>
<body>
    <div class="container">
        <div id="lab-info">
            <?php
                # connect to database
                $conn = new mysqli($server, $username, $password, $database);
                if($conn->connect_error){
                    die("Connection Failed");
                }
                # read session variables - sent from login screen
                $student_id = $_SESSION['student_id'];
                $lab_id = $_SESSION['lab_id'];
                $crn = $_SESSION['crn'];
                # fetch student info from student table
                $result = $conn->query("SELECT $fname_column, $lname_column FROM $students_table WHERE $student_id_column='$student_id' AND $crn_column=$crn");
                if($result->num_rows > 0){
                    $fetch = $result->fetch_assoc();
                    echo "<h3>Student</h3>";
                    echo "<p>" . $fetch[$fname_column] . " " . $fetch[$lname_column] . " (" . $student_id . ")</p>";
                }else{
                    header("Location: error.html");
                    exit;
                }
                # fetch lab info from lab table
                $result = $conn->query("SELECT $instructor_name_column, $course_title_column, $semester_column FROM $labs_table WHERE $lab_id_column=$lab_id AND $crn_column=$crn");
                if($result->num_rows > 0){
                    $fetch = $result->fetch_assoc();
                    echo "<h3>Lab Number</h3>";
                    echo "<p>" . $lab_id . "</p>";
                    echo "<h3>Instructor</h3>";
                    echo "<p>" . $fetch[$instructor_name_column] . "</p>";
                    echo "<h3>Course</h3>";
                    echo "<p>" . $fetch[$course_title_column] . "</p>";
                    echo "<h3>Semester</h3>";
                    echo "<p>" . $fetch[$semester_column] . "</p>";
                    echo "<h3>CRN</h3>";
                    echo "<p>" . $crn . "</p>";
                }else{
                    header("Location: error.html");
                    exit;
                }
                $conn->close();
            ?>
        </div>
        <div class="main">
            <div id="question">
                <?php
                    echo "<h1>Question " . $_SESSION['current_question'] . "<br>Click on the graph at the point that best describes your opinion of today's lab</h1>";
                ?>
            </div>
            <div class="rate_question">
                <div><p id='Interesting'>Interesting</p></div>
                <div class="graph"> 
                    <div><p id='Easy'>Easy</p></div>
                    <div id="dom-table"><!-- Grid Goes Here--></div>
                    <div><p id='Hard'>Hard</p></div>
                </div>
                <div><p id='Boring'>Boring</p></div>   
            </div>
            <div class="action">
                <form id="output_form" method="POST" action="grid-submit.php">
                    <input type="button" id="skip-button" value="Skip Question" />
                    <input type="button" id="submit-button" value="Submit Rating" disabled />
                    <!-- Hidden values for javascript to pass rating -->
                    <input type="hidden" name="x_value" id="x_value" value="" />
                    <input type="hidden" name="y_value" id="y_value" value="" />
                </form>
            </div>
       </div>
    </div>
</body>
</html>
