<?php
$servername = "localhost";
$username = "root";
$db_password = "Wassup193290";
$db = "feedback";
$connect = mysqli_connect($servername, $username, $db_password, $db);
if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
$connect->query("SET NAMES UTF8");
$first_name=trim($_REQUEST['first_name']);
$last_name=trim($_REQUEST['last_name']);
$email=trim($_REQUEST['email']);
$phone=trim($_REQUEST['phone']);
$phone=str_replace(array('+', ' ', '(' , ')', '-'), '', $phone);
$type=trim($_REQUEST['type']);
$comment=trim($_REQUEST['comment']);
$connect->query("INSERT INTO comments (first_name, last_name, email, phone, type, comment) VALUES ('$first_name','$last_name','$email','$phone','$type','$comment')");
$id_comment = $connect->query("SELECT max(ID) FROM comments;");
$id_comment = trim(mysqli_fetch_array($id_comment, MYSQLI_ASSOC) ['max(ID)']);
$upload_dir = 'files\\';
$upload_file = $upload_dir . basename($_FILES['add_files']['name']);
$upload_file_sql = $upload_dir . "\\" . basename($_FILES['add_files']['name']);
if (move_uploaded_file($_FILES['add_files']['tmp_name'], $upload_file)) {
    $connect->query("INSERT INTO files (file_path) VALUES ('$upload_file_sql')");
    $id_file = $connect->query("SELECT max(ID) FROM files;");
    $id_file = trim(mysqli_fetch_array($id_file, MYSQLI_ASSOC) ['max(ID)']);
    $connect->query("INSERT INTO comments_files (id_comment, id_file) VALUES ('$id_comment','$id_file')");
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'lib/phpmailer/src/Exception.php';
require 'lib/phpmailer/src/PHPMailer.php';
require 'lib/phpmailer/src/SMTP.php';
//Load Composer's autoloader
require 'lib/vendor/autoload.php';
//Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);
try {
    //Server settings
  //  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'ssl://smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'feedbacktestmailer@gmail.com';                     //SMTP username
    $mail->Password   = 'Yfgjktnfyrbdjtdfkb';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
    $mail->Port       = 465;
    //Recipients
    $mail->setFrom('feedbacktestmailer@gmail.com', 'Feedback.devel');
    $mail->addAddress('adm.korotkov@gmail.com', 'Admin');      //Name is optional
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'New comment';
    $mail->Body    = 'New comment from ' . $first_name . ' ' . $last_name . ':' . $comment;
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    $mail->send();
    echo 'Сообщение успешно отправлено!';
} catch (Exception $e) {
    echo "Сообщение не было отправлено. Ошибка: {$mail->ErrorInfo}";
}

require 'index.html';
exit;
?>
