<?php
include("dbconn.php");
if(isset($_POST['personal']))
{
$s_id 			= $_POST['s_id'];	
$s_name 		= $_POST['s_name'];
$s_father		= $_POST['s_father'];
$s_mother 		= $_POST['s_mother'];
$s_gender		= $_POST['s_gender'];
$s_dob			= $_POST['s_dob'];
$s_religion		= $_POST['s_religion'];
$s_nationality	= $_POST['s_nationality'];
$s_college 		= $_POST['s_college'];
$s_course 		= $_POST['s_course'];
$s_department	= $_POST['s_department'];
$s_year	 		= $_POST['s_year'];
$s_email		= $_POST['s_email'];
$s_mobile		= $_POST['s_mobile'];
$s_pmobile		= $_POST['s_pmobile'];
$s_focc 		= $_POST['s_focc'];
$s_mocc 		= $_POST['s_mocc'];
$s_city 		= $_POST['s_city'];
$s_address		= $_POST['s_address'];
date_default_timezone_set('Asia/Calcutta');
$date = date('d/m/Y h:i:s a', time());	
$query = "INSERT INTO students (s_id, s_name, s_father, s_mother, s_gender, s_dob, s_religion, s_nationality, s_college, s_course, s_department, s_year, s_email, s_mobile, s_pmobile, s_focc, s_mocc, s_city, s_address, reg_date, status)  
		  VALUES 
		('$s_id', '$s_name', '$s_father', '$s_mother', '$s_gender', '$s_dob', '$s_religion', '$s_nationality', '$s_college', '$s_course', '$s_department', '$s_year', '$s_email', '$s_mobile', '$s_pmobile', '$s_focc', '$s_mocc', '$s_city', '$s_address', '$date', '1')";
mysqli_query($conn,$query);
header("Location: ../add-student.php?sid=$s_id&msg=Student Personal Information added."); 
}	

if(isset($_POST['education']))
{
$s_id 		  = $_POST['s_id'];
$s_edu_course = count($_POST["s_edu_course"]);
if($s_edu_course >= 1)
{
	for($i=0; $i<$s_edu_course; $i++)
	{
		if(trim($_POST["s_edu_course"][$i] != ''))
		{
			$sql = "INSERT INTO stu_education(s_id, s_course, s_department, s_marks, s_year) VALUES('$s_id', '".mysqli_real_escape_string($conn, $_POST["s_edu_course"][$i])."', '".mysqli_real_escape_string($conn, $_POST["s_edu_department"][$i])."', '".mysqli_real_escape_string($conn, $_POST["s_edu_marks"][$i])."', '".mysqli_real_escape_string($conn, $_POST["s_edu_year"][$i])."')";
			mysqli_query($conn, $sql);
		}
	}
}
header("Location: ../add-student.php?sid=$s_id&msg=Student Education Information added."); 
}
?>