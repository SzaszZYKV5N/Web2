<?php
class Szolgaltatas {
   

    public function getadatok($novekvo=1){
        if($novekvo==1){$asc="asc";}else{$asc="desc";}
        $eredmeny = array("hibakod" => 0,
        "uzenet" => "",
        "markak" => Array());
        try {
        $dbh = new PDO('mysql:host=localhost;dbname=web2','root', '', array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
        $dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
        $sql = "select nev, munkalap.helyaz, telepules, utca from szerelo, munkalap, hely 
        where szerelo.az=munkalap.szereloaz 
        and munkalap.helyaz=hely.az 
        order by helyaz $asc";
        $sth = $dbh->prepare($sql);
        $sth->execute(array());
        $eredmeny['adatok'] = $sth->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
        $eredmeny["hibakod"] = 1;
        $eredmeny["uzenet"] = $e->getMessage();
        }
        return $eredmeny;
        }
}
$options = array('uri' => 'http://localhost/web2/szerver/soapServer.php');

$server = new SoapServer(null, $options);
$server->setClass('Szolgaltatas');
$server->handle();


?>