<div class="about_section layout_padding margim_90">
         <div class="container">
                  <h1>Munkáink</h1>
                  <?php
$options=array('uri' => 'http://localhost/web2/szerver/soapServer.php',
 'location' => 'http://localhost/web2/szerver/soapServer.php',
 //keep_alive => true
);
try{
    $kliens=new SoapClient(null,$options);
    $adatokeredmeny=$kliens->getadatok(1);
    if($adatokeredmeny['hibakod']==1){
        echo '<br>Hiba történt:<br>A hiba kódja:'. $adatokeredmeny['uzenet']; 
    }
  
    echo "<table border='1'><tr><th>nev</th><th>helyaz</th><th>telepules</th><th>utca</th></tr>";
    foreach($adatokeredmeny['adatok'] as $e){
        echo '<tr>
        <td>'. $e['nev'] .'</td>
        <td>'. $e['helyaz'] .'</td>
        <td>'. $e['telepules'] .'</td>
        <td>'. $e['utca'] .'</td>
        </tr>'; 
    }   
echo '</table>';
}catch(SoapFault $e){
     dump($e);
}

?>
</div>
</div>
