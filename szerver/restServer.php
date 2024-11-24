<?php

$eredmeny = "";
try {
// belép az adatbázisba:
$dbh = new PDO('mysql:host=localhost;dbname=web2', 'root', '',
array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
$dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
// lekérdezi a módszert: GET, POST, PUT, DELETE
switch($_SERVER['REQUEST_METHOD']) {

case "GET":
    $sql = "SELECT * FROM felhasznalok";
    $sth = $dbh->query($sql);
    // HTML táblázat készítése a kiolvasott adatokkal:
    $eredmeny .= "<table style=\"border-collapse: collapse;\"><tr><th></th><th>Családi név</th><th>Utónév</th>
    <th>Login név</th><th>Kódolt jelszó</th><th>Jogosultság</th></tr>";
    while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
    $eredmeny .= "<tr>";
    foreach($row as $column)
    $eredmeny .= "<td style=\"border: 1px solid black; padding: 3px;\">".$column."</td>";
    $eredmeny .= "</tr>";
    }
    $eredmeny .= "</table>";
    break;

case "POST":
    $sql = "insert into felhasznalok values (0, :csn, :un, :bn, :jel, '_1_')";
    $sth = $dbh->prepare($sql);

    $incoming = file_get_contents("php://input");
    // parse_str: Parses the string into variables
    // https://www.php.net/manual/en/function.parse-str.php
    parse_str($incoming, $data);
    $count = $sth->execute(Array(":csn"=>$data["csn"], ":un"=>$data["un"], ":bn"=>$data["bn"], ":jel"=>$data["jel"]));
    // Ez is jó lenne, mert a $_POST tömbben IS megjelenik az elküldött adat:
    // Ilyenkor ezek sem kellenének:
    // $incoming = file_get_contents("php://input");
    // parse_str($incoming, $data);
    //$count = $sth->execute(Array(":csn"=>$_POST["csn"], ":un"=>$_POST["un"], ":bn"=>$_POST["bn"], ":jel"=>$_POST["jel"]));
    // lastInsertId():Returns the ID of the last inserted row or sequence value
    // https://www.php.net/manual/en/pdo.lastinsertid.php
    $newid = $dbh->lastInsertId();
    // Ebben az esetben a szerver által visszaadott eredmény string ehhez hasonló lesz:
    // 1 beszúrt sor: 12 (1 db sort szúrt be a 12. pozícióba)
    $eredmeny .= $count." beszúrt sor: ".$newid;
    break;
    // PUT módszer esetén:
case "PUT":
    $data = array();
    $incoming = file_get_contents("php://input");
    parse_str($incoming, $data);
    // Update esetén ehhez hasonló lekérdezést kell összeállítani preparált formában:
    // UPDATE felhasznalok SET csaladi_nev = 'Kovács', utonev = 'Ferenc'
    // WHERE id = 1;
    // A $modositando stringbe állítja össze a preparált lekérdezés
    // Update felhasznalok set ……… where kipontozott részét
    // A $params tömbbe állítja össze a preparált lekérdezéshez az adatokat,
    // amiket a változók helyére kell beszúrni
    // amelyik adat benne van a $data tömbben, azzal kiegészíti a $modositando stringet és a $params tömböt
    // Az id biztos, hogy benne van a $data tömbben
    $modositando = "id=id"; $params = Array(":id"=>$data["id"]);
    if($data['csn'] != "") {$modositando .= ", csaladi_nev = :csn"; $params[":csn"] = $data["csn"];}
    if($data['un'] != "") {$modositando .= ", utonev = :un"; $params[":un"] = $data["un"];}
    if($data['bn'] != "") {$modositando .= ", bejelentkezes = :bn"; $params[":bn"] = $data["bn"];}
    if($data['jel'] != "") {$modositando .= ", jelszo = :jel"; $params[":jel"] = sha1($data["jel"]);}
    $sql = "update felhasznalok set ".$modositando." where id=:id";
    $sth = $dbh->prepare($sql);
    $count = $sth->execute($params);
    $eredmeny .= $count." módositott sor. Azonosítója:".$data["id"];
    break;
    // DELETE módszer esetén:
case "DELETE":
    // Mint a PUT módszernél: kiolvassuk a küldött adatokat
    $data = array();
    $incoming = file_get_contents("php://input");
    parse_str($incoming, $data);
    // DELETE esetén csak az ID van továbbítva
    // törli a felhasznalok táblából azt a rekordot, amelyiknek meg lett adva az ID-je.
    $sql = "delete from felhasznalok where id=:id";
    $sth = $dbh->prepare($sql);
    $count = $sth->execute(Array(":id" => $data["id"]));
    $eredmeny .= $count." sor törölve. Azonosítója:".$data["id"];
    break;
}
}
catch (PDOException $e) {
$eredmeny = $e->getMessage();
}
echo $eredmeny;
?>