<div class="about_section layout_padding margim_90">
         <div class="container">
                  <h1>Munkáink (SOAP kliens)</h1>
                  <?php
$options=array('uri' => 'https://sz95789.hosting.atw.co.hu/szerver/soapserver.php',
 'location' => 'https://sz95789.hosting.atw.co.hu/szerver/soapserver.php',
 'keep_alive' => false,
 'trace' =>true,
'connection_timeout' => 5000,
'cache_wsdl' => WSDL_CACHE_NONE,
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
