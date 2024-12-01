

<h2><span>Napi árfolyamok</span></h2>
<?php 



echo "<br>GetCurrentExchangeRates()<br>"; 

$objClient = new SoapClient("http://www.mnb.hu/arfolyamok.asmx?WSDL", array('trace' => true));
$currrates = $objClient->GetCurrentExchangeRates()->GetCurrentExchangeRatesResult;

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
////////////////////////////////////////////////////////////////////////
 ?>



