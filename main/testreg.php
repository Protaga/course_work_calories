<?php
    session_start();//  уся процедура працює на сесіях. саме в ній зберігаються дані користувача, поки він знаходиться на сайті. Дуже важливо заупустити їх на початку сторінки!!!
if (isset($_POST['login'])) { $login = $_POST['login']; if ($login == '') { unset($login);} } //заносимо введений користувачем логін у змінну $login, якщо він пустий, то видаляємо змінну
    if (isset($_POST['password'])) { $password=$_POST['password']; if ($password =='') { unset($password);} }
    //заносимо введений користувачем пароль у змінну $password, якщо він пустий, то видаляємо змінну
if (empty($login) or empty($password)) //якщо користувач не ввів логін чи пароль, то видаємо помилку та зупиняємо скрипт
    {
    exit ("Ви ввели не всю інформацію, поверніться назад та заповніть всі поля!");
    }
    //якщо логін та пароль введені, то обрабляємо їх, щоб теги чи скрипти не працювали, бо люди можуть ввести усяке
    $login = stripslashes($login);
    $login = htmlspecialchars($login);
$password = stripslashes($password);
    $password = htmlspecialchars($password);
//видаляємо зайві пробіли
    $login = trim($login);
    $password = trim($password);
// підключаємося до бази
    include ("bd.php");
    //файл bd.php має бути у тій же папці, що й уся решта, якщо це не так - змініть шлях 

 
$result = mysql_query("SELECT * FROM users WHERE login='$login'",$db); //дістаємо з бази даних всю інформацію за введеним логіном 
    $myrow = mysql_fetch_array($result);
    if (empty($myrow['password']))
    {
    //якщо користувача з введеним логіном не існує
    exit ("Вибачте, введений вами логін неправильний.");
    }
    else {
    //якщо існує, то звіряємо паролі
    if ($myrow['password']==$password) {
    //якщо паролі співпадають, то запускаємо користувачу сесію!
    $_SESSION['login']=$myrow['login']; 
    $_SESSION['id']=$myrow['id'];//ці дані часто використовуються, тому нехай користувач і носить їх з собою
    echo "Ви вдало увійшли на сайт! <a href='index.php'>Головна сторінка</a>";
    }
 else {
    //якщо паролі не зійшлись

    exit ("Вибачте введений вами пароль невірний.");
    }
    }
    ?>