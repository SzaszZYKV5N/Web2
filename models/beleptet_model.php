<?php

class beleptet_Model
{
	public function get_data($vars)
	{
		$retData['eredmeny'] = "";
		try {
			$connection2 = Database::getConnection();
			$jsz0=$vars['password'];
			print $jsz0."hhh";
			$jsz=sha1($jsz0);
			$neve=$vars['login'];
			//$jsz=sha1("Login2");
			//$neve="Login2";

			$sql = "select * from felhasznalok where bejelentkezes='" .$neve."' and jelszo='".$jsz."'";
			//$sql = "select id, csaladi_nev, utonev, jogosultsag from felhasznalok where bejelentkezes='".$vars['login']."' and jelszo='".sha1($vars['password'])."'";
			//$sql = "select * from felhasznalok where bejelentkezes='" .$vars['login']."' and jelszo='".$vars['password']."'";
			$stmt = $connection2->query($sql);
			$felhasznalo = $stmt->fetchAll(PDO::FETCH_ASSOC);
			switch(count($felhasznalo)) {
				case 0:
					$retData['eredmeny'] = "ERROR";
					$retData['uzenet'] = "Helytelen felhasználói név-jelszó pár!  ".$neve." ".$jsz."<br>".$sql;
					break;
				case 1:
					$retData['eredmeny'] = "OK";
					$retData['uzenet'] = "Kedves ".$felhasznalo[0]['csaladi_nev']." ".$felhasznalo[0]['utonev']."!<br><br>
					                      Jó munkát kívánunk ".$neve." ".$jsz."<br><br>
										  Az üzemeltetők";
					$_SESSION['userid'] =  $felhasznalo[0]['id'];
					$_SESSION['userlastname'] =  $felhasznalo[0]['csaladi_nev'];
					$_SESSION['userfirstname'] =  $felhasznalo[0]['utonev'];
					$_SESSION['userlevel'] = $felhasznalo[0]['jogosultsag'];
					Menu::setMenu();
					break;
				default:
					$retData['eredmeny'] = "ERROR";
					$retData['uzenet'] = "Több felhasználót találtunk a megadott felhasználói név -jelszó párral!";
			}
		}
		catch (PDOException $e) {
					$retData['eredmeny'] = "ERROR";
					$retData['uzenet'] = "Adatbázis hiba: ".$e->getMessage()."!";
		}
		return $retData;
	}
}

?>