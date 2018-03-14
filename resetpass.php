<?php

if(isset($_POST['pass'])){
$pass = $_POST['pass'];
$acode=$_POST['code'];
$newpw=password_hash($pass, PASSWORD_DEFAULT);
$con=mysqli_connect("localhost","root","","ProjectDB");
// Check connection
if (mysqli_connect_errno())
{
echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$query = mysqli_query($con,"select * from users where activation_code='$acode'")
or die(mysqli_error($con)); 

if (mysqli_num_rows ($query)==1) 
{
$query3 = mysqli_query($con,"update users set Password='$newpw' where activation_code='$acode'")
or die(mysqli_error($con)); 

 echo "<script>
alert('Passward changed!');
window.location.href='login.php';
</script>";
}
else
{
echo 'Wrong CODE';
}
}
?>

<form action="resetpass.php" method="POST">
<p>New Password:</p><input type="password" name="pass" />
<input type="submit"  name="submit" value="Enter The New Adress!" />
<input type="hidden" name="code" value="<?php echo $_GET['code'];?>" />
</form>


