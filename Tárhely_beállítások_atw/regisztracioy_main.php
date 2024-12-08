<?php
$url = "https://sz95789.hosting.atw.co.hu/szerver/restserver.php";

$result = "";

if(isset($_POST['id']))
{
// Felesleges szóközök eldobása
$_POST['id'] = trim($_POST['id']);
$_POST['csn'] = trim($_POST['csn']);
$_POST['un'] = trim($_POST['un']);
$_POST['bn'] = trim($_POST['bn']);
$_POST['jel'] = trim($_POST['jel']);

if($_POST['id'] == "" && $_POST['csn'] != "" && $_POST['un'] != "" && $_POST['bn'] != "" && $_POST['jel'] != "")
{
    $data = Array("csn" => $_POST["csn"], "un" => $_POST["un"], "bn" => $_POST["bn"], "jel" => sha1($_POST["jel"]));
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
}

    elseif($_POST['id'] == "")
    {
    $result = "Hiba: Hiányos adatok!";
    }
    elseif($_POST['id'] >= 1 && ($_POST['csn'] != "" || $_POST['un'] != "" || $_POST['bn'] != "" || $_POST['jel'] != ""))
    {
    $data = Array("id" => $_POST["id"], "csn" => $_POST["csn"], "un" => $_POST["un"], "bn" => $_POST["bn"], "jel" => $_POST["jel"]);
    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    }

    elseif($_POST['id'] >= 1)
    {
    $data = Array("id" => $_POST["id"]);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);
    }

    else
    {
    echo "Hiba: Rossz azonosító (Id): ".$_POST['id']."<br>";
    }
}
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$tabla = curl_exec($ch);
curl_close($ch);


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Regisztráció</title>
</head>
<body>

<?= $result ?>
<h1>Regisztráció</h1>

<br>
<h2>Módosítás / Beszúrás</h2>

<form method="post">
<table>
<tr><td>Id: </td><td><input type="hidden" name="id" value=""></td></tr>
<tr><td>Családi név: </td><td><input type="text" name="csn" maxlength="45"></td></tr>
<tr><td>Utónév:</td><td> <input type="text" name="un" maxlength="45"></td></tr>
<tr><td>Bejelentkezési név: </td><td><input type="text" name="bn" maxlength="12"></td></tr>
<tr><td>Jelszó:</td><td> <input type="text" name="jel"></td></tr>

<tr><td colspan=2><input type="submit" value = "Regisztrálás"></td></tr>
</table>
</form>
</body>
</html>