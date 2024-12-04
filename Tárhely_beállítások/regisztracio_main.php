

<?php
$uzenet="";
if(isset($_POST['csn']) && isset($_POST['un']) && isset($_POST['bn']) && isset($_POST['jel'])) {
    try {
        // Kapcsolódás
        $dbh = new PDO('mysql:host=localhost;dbname=zykv5n', 'zykv5n', 'Nhelyjelszo_71', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        
       // $dbh = new PDO('mysql:host=localhost;dbname=web2', 'root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        
        // Létezik már a felhasználói név?
        $sqlSelect = "select id from felhasznalok where bejelentkezes = :bn";
        $sth = $dbh->prepare($sqlSelect);
        $sth->execute(array(':bn' => $_POST['bn']));
        if($row = $sth->fetch(PDO::FETCH_ASSOC)) {
            $uzenet = "A felhasználói név már foglalt!";
            $ujra = "true";
        }
        else {
            // Ha nem létezik, akkor regisztráljuk
            $sqlInsert = "insert into felhasznalok(id, csaladi_nev, utonev, bejelentkezes, jelszo, jogosultsag)
                          values(0, :csn, :un, :bn, :jel, '_1_')";
            $stmt = $dbh->prepare($sqlInsert); 
            $stmt->execute(array(':csn' => $_POST['csn'], ':un' => $_POST['un'],
                                 ':bn' => $_POST['bn'], ':jel' => sha1($_POST['jel']))); 
            if($count = $stmt->rowCount()) {
                $newid = $dbh->lastInsertId();
                $uzenet = "A regisztrációja sikeres.<br>Azonosítója: {$newid}";                     
                $ujra = false;
            }
            else {
                $uzenet = "A regisztráció nem sikerült.";
                $ujra = true;
            }
        }
    }
    catch (PDOException $e) {
        $uzenet = "Hiba: ".$e->getMessage();
        $ujra = true;
    }      
}
else {
   // header("Location: .");
}
?>
<h2>Regisztráció</h2>
<?= $uzenet ?>
<br>


<form  method="post">
<table>
<tr><td> </td><td><input type="hidden" name="id" value=""></td></tr>
<tr><td>Családi név: </td><td><input type="text" name="csn" maxlength="45"></td></tr>
<tr><td>Utónév:</td><td> <input type="text" name="un" maxlength="45"></td></tr>
<tr><td>Bejelentkezési név: </td><td><input type="text" name="bn" maxlength="12"></td></tr>
<tr><td>Jelszó:</td><td> <input type="text" name="jel"></td></tr>

<tr><td colspan=2><input type="submit" value = "Regisztrálás"></td></tr>
</table>
</form>
</body>
</html>