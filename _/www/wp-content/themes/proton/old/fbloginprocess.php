<?php

$fbuserid = $_POST[fid];  
$fbusername = $_POST[fname];  
$fbaccess = $_POST[faccessToken]; 

echo $fbuserid;  
echo "\n";  
echo $fbusername;  
/**
$db = new DBConnect(); //DB쓰는 php문서는 위 2줄 쓰고 시작  
  
$query = "SELECT * FROM Phoneskin_user where email='".$fbuserid."'";  
$result = $db->executeQuery($query);  
  
$result_count = $result->num_rows;  
  
if($result_count<1) {  
    //facebook으로 로그인한 아이디가 DB에 없을 경우.  
    $query2 = "INSERT INTO `mysql`.`Phoneskin_user` (`num`, `email`, `passwd`, `name`, `facebook_token`, `address`, `phone_number`, `user_picture_path`, `intro`) VALUES (NULL, '".$fbuserid."', NULL, '".iconv("utf-8","euc-kr", $fbusername)."', NULL, NULL, NULL, 'http://graph.facebook.com/".$fbuserid."/picture', NULL)";  
    $result2 = $db->executeQuery($query2);  
      
    $query = "SELECT * FROM Phoneskin_user where email='".$fbuserid."'";  
    $result = $db->executeQuery($query);   
}  
session_start();  
  
$row = mysqli_fetch_assoc($result);  
$_SESSION['num'] = $row['num'];  
$_SESSION['id'] = $row['email'];  
//$_SESSION['name'] = iconv("euc-kr","utf-8", $row['name']);  
$_SESSION['name'] = $row['name'];  
$_SESSION['user_picture_path'] = $row['user_picture_path'];  
$_SESSION['facebook'] = true;  
$_SESSION['fbtoken'] = $fbaccess;  
*/
?>

<script>
var myvar = '<?php echo $fbusername ;?>';

alert(myvar);
</script>