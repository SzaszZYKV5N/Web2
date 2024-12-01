<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

<h2><span>MNB Soap kliens</span></h2>


<div class="row">
<div class="col-md-6">



<table style:border=1>

<form action=# method=post>
<tr><td colspan=2>Devizák adott napon</td></tr>

<tr><td>Egyik deviza: </td><td><select name="egyik" id="napiarfolyam">
<?php
    $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");
    $xml = simplexml_load_string($client->GetInfo()->GetInfoResult);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
    for($i=0;$i<sizeof($array['Currencies']['Curr']);$i++)
    {
        echo "<option value=\"". $array['Currencies']['Curr'][$i]."\">".$array['Currencies']['Curr'][$i]  ."</option>";
    }
?>
</select></td></tr>

<tr><td>Másik deviza</td><td><select name="masik" id="napiarfolyam2">
<?php
   // $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");
    $xml = simplexml_load_string($client->GetInfo()->GetInfoResult);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
    for($i=0;$i<sizeof($array['Currencies']['Curr']);$i++)
    {
        echo "<option value=\"". $array['Currencies']['Curr'][$i]."\">".$array['Currencies']['Curr'][$i]  ."</option>";
    }
?>
</select></td></tr>
<tr><td>Dátum</td><td><input type="date" name="datum" required value=$date></td></tr>
<tr><td colspan=2><input type="submit" name=maiarfolyam value="Árfolyam letöltése"></td></tr>
</form>
</table>
<br>

<?php
if(isset($_POST['maiarfolyam']))
{
    $devizak = $_POST['egyik'] . "," . $_POST['masik'];
    $objClient = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL", array('trace' => true));
    $currrates = $objClient->GetExchangeRates(array('startDate' => $_POST['datum'], 'endDate' => $_POST['datum'], 'currencyNames' => $devizak))->GetExchangeRatesResult;
  
    $dom_root = new DOMDocument();
    $dom_root->loadXML($currrates);
    
    $searchNode = $dom_root->getElementsByTagName("Day");
   
    $index=0;
    foreach( $searchNode as $searchNode ) {
        $date = $searchNode->getAttribute('date');
        if (!$date) print "nincs"; else
        print $date . "\n<br>";
        $rates = $searchNode->getElementsByTagName( "Rate" ); 
        foreach( $rates as $rate ) {
            
            print "\t" . $rate->getAttribute('unit') . " " ;
            print $rate->getAttribute('curr');
            print "  =  ";
            print $rate->nodeValue;
            print " HUF\n<br>";
                  
         
        }
         
        echo "<br>";
    }
}
?>

</div>
<div class="col-md-6">

<table>

<form action=# method=post>

<tr><td colspan=2>Devizák adott időszakban</td></tr>
<tr><td>Választott deviza: </td><td><select name="egyik" id="diagramarfolyam">
<?php
    $client = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL");
    $xml = simplexml_load_string($client->GetInfo()->GetInfoResult);
    $json = json_encode($xml);
    $array = json_decode($json,TRUE);
   
    for($i=0;$i<sizeof($array['Currencies']['Curr']);$i++)
    {   
       if($i>0) {echo "<option value=\"". $array['Currencies']['Curr'][$i]."\">".$array['Currencies']['Curr'][$i]  ."</option>";
       }
    }
?>
</select></td></tr>

<tr><td>Mettől: </td><td><input type="date" name="datumtol" required></td></tr>
<tr><td>Meddig: </td><td><input type="date" name="datumig" required></td></tr>
<tr><td colspan=2><input type="submit" name=kirajzol value="Grafikon megjelenítése"></td></tr>
</form>
</table>
</div>
</div>

<div class="row">
<div class="col-md-6">
<hr>
<?php
if(isset($_POST['kirajzol']))
{
    $xek = "";
    $yok = "";
    $objClient = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL", array('trace' => true));
    $currrates = $objClient->GetExchangeRates(array('startDate' => $_POST['datumtol'], 'endDate' => $_POST['datumig'], 'currencyNames' => $_POST['egyik']))->GetExchangeRatesResult;
    $dom_root = new DOMDocument();
    $dom_root->loadXML($currrates);
    
    $searchNode = $dom_root->getElementsByTagName("Day");
    
    foreach( $searchNode as $searchNode ) {
        $date = $searchNode->getAttribute('date');
        $xek .= "\"" . $searchNode->getAttribute('date') . "\",";
        //print $date . "\n<br>";
        $rates = $searchNode->getElementsByTagName( "Rate" ); 
        foreach( $rates as $rate ) {
            //print "\t" . $rate->getAttribute('unit') . " " ;
            //print $rate->getAttribute('curr');

            $yok .= str_replace(",",".",$rate->nodeValue) . ",";

            print $searchNode->getAttribute('date')."\t:  ";
            //print "  =  ";
            print str_replace(",",".",$rate->nodeValue);
            print " HUF\t";
        }
        echo "<br>";
    }

//}
?>
</div>


<?php
//if(isset($_POST['kirajzol']))
//{
    $xek = "";
    $yok = "";
    //$objClient = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL", array('trace' => true));
    $currrates = $objClient->GetExchangeRates(array('startDate' => $_POST['datumtol'], 'endDate' => $_POST['datumig'], 'currencyNames' => $_POST['egyik']))->GetExchangeRatesResult;
    $dom_root = new DOMDocument();
    $dom_root->loadXML($currrates);
    
    $searchNode = $dom_root->getElementsByTagName("Day");
    
    foreach( $searchNode as $searchNode ) {
        $date = $searchNode->getAttribute('date');
        $xek .= "\"" . $searchNode->getAttribute('date') . "\",";
       
        $rates = $searchNode->getElementsByTagName( "Rate" ); 
        foreach( $rates as $rate ) {
       

            $yok .= str_replace(",",".",$rate->nodeValue) . ",";

           
        }
        
    }
    $xek = rtrim($xek, ', ');
    $yok = rtrim($yok, ', ');
   
}

echo "<div class='col-md-6'>";
echo "<canvas id=\"myChart\" style=\"width:100%;max-width:450px; caption: 'A választott deviza árfolyama' \"></canvas>";
echo "<script>";
echo "const xValues = [" . $xek . "];";
echo "const yValues = [" . $yok . "];";
?>

new Chart("myChart", {
  type: "line",
  
  data: {
    labels: xValues,
    datasets: [{
      legend:"A választott deviza árfolyama" , 
      fill: false,
      lineTension: 0,
      backgroundColor: "rgba(0,0,128,2.0)",
      borderColor: "rgba(0,0,224,0.1)",
      data: yValues
    }]
  }
});
</script>

</div>
</div>