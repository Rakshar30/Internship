<!---STUDENT REGISTRATION FORM USING PHP--->
<?php
$name =$email=$age = $gender=$course="";
$nameErr=$emailErr=$ageErr = $genderErr=$courseErr="";

if($_SERVER["REQUEST_METHOD"]== "POST"){
    if(empty($_POST["name"])){
        $nameErr="Name is required";
    }else{
        $name = $_POST["name"];
    }

    if(empty($_POST["email"])){
        $emailErr="Email is required";
    }else{
        $email = $_POST['email'];
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        $emailErr="invalid email";
}
  }

    if(empty($_POST["age"])){
        $ageErr="Age is required";
    }else{
        $age=$_POST["age"];
        if(!is_numeric($age)){
            $ageErr="Age must be numeric";
        }elseif($age<=17){
            $ageErr="Age must be greater than 17";
        }
    }

    if(empty($_POST["gender"])){
        $genderErr="Gender is required";
    }else{
        $gender=$_POST["gender"];
    }
    if(empty($_POST["course"])){
        $courseErr="Course is required";
    }else{
        $course=$_POST["course"];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h2>Student Registration form</h2>
    <form action="" method="POST">
        Name:
        <input type="text" name="name">
        <span style="color:red;"><?php echo $nameErr;?></span>
        <br>
        <br>
        Email:
        <input type="text" name="email">
        <span style="color:red;"><?php echo $emailErr;?></span>
        <br>
        <br>
        Age:
        <input type="number" name="age">
        <span style="color:red;"><?php echo $ageErr;?></span>
        <br>
        <br>
        Gender:
        <input type="radio" name="gender" value="Male">Male
        <input type="radio" name="gender" value="Female">Female
        <span style="color:red;"><?php echo $genderErr;?></span>
        <br>
        <br>
        Course:
        <select name="course">
            <option value="CSE">CSE</option>
            <option value="ISE">ISE</option>
            <option value="ECE">ECE</option>
        </select>
        <span style="color:red;"><?php echo $courseErr;?></span>
        <input type="submit" value="submit">
    </form>
    
<?php
if ($name && $email && $age && $gender && $course && !$nameErr && !$emailErr && !$ageErr && !$genderErr && !$courseErr) {
    echo "<h3>Registration Successful</h3>";
    echo "Name: $name <br>";
    echo "Email: $email <br>";
    echo "Age: $age <br>";
    echo "Gender: $gender <br>";
    echo "Course: $course <br>";
}
?>
</body>
</html>
