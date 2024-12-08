<?php
// Adatbázis kapcsolat beállítása
$host = "localhost";
$user = "sz95789_zykv5n";
$password = "Jelszo_71";
$database = "sz95789_zykv5n"; // Cseréld le az adatbázis nevére!


$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Hiba az adatbázishoz való kapcsolódáskor: " . $conn->connect_error);
}

// Alapértelmezett változók
$telepules = isset($_POST['telepules']) ? $_POST['telepules'] : '';
$szereloAz = isset($_POST['szerelo']) ? intval($_POST['szerelo']) : '';
$munkalapHelyAz = isset($_POST['munkalap']) ? intval($_POST['munkalap']) : '';

// Települések betöltése
$telepulesOptions = '';
$telepulesQuery = "SELECT DISTINCT telepules FROM hely";
$telepulesResult = $conn->query($telepulesQuery);
while ($row = $telepulesResult->fetch_assoc()) {
    $selected = ($row['telepules'] === $telepules) ? 'selected' : '';
    $telepulesOptions .= '<option value="' . htmlspecialchars($row['telepules']) . '" ' . $selected . '>' . htmlspecialchars($row['telepules']) . '</option>';
}

// Szerelők betöltése az adott település alapján
$szereloOptions = '';
if ($telepules) {
    $szereloQuery = "
        SELECT DISTINCT szerelo.az, szerelo.nev
        FROM szerelo
        JOIN munkalap ON szerelo.az = munkalap.szereloaz
        JOIN hely ON munkalap.helyaz = hely.az
        WHERE hely.telepules = '" . $conn->real_escape_string($telepules) . "'
    ";
    $szereloResult = $conn->query($szereloQuery);
    while ($row = $szereloResult->fetch_assoc()) {
        $selected = ($row['az'] == $szereloAz) ? 'selected' : '';
        $szereloOptions .= '<option value="' . $row['az'] . '" ' . $selected . '>' . htmlspecialchars($row['nev']) . '</option>';
    }
}

// Munkalapok betöltése az adott szerelő és település alapján
$munkalapOptions = '';
if ($szereloAz) {
    $munkalapQuery = "
        SELECT munkalap.az, munkalap.helyaz
        FROM munkalap
        JOIN hely ON munkalap.helyaz = hely.az
        WHERE hely.telepules = '" . $conn->real_escape_string($telepules) . "'
        AND munkalap.szereloaz = $szereloAz
    ";
    $munkalapResult = $conn->query($munkalapQuery);
    while ($row = $munkalapResult->fetch_assoc()) {
        $selected = ($row['helyaz'] == $munkalapHelyAz) ? 'selected' : '';
        $munkalapOptions .= '<option value="' . $row['helyaz'] . '" ' . $selected . '>Munkalap #' . $row['az'] . '</option>';
    }
}
// Összegzés táblázat az adott munkalap alapján
$alkalom=0;
$eredmenyTabla = '';
if ($munkalapHelyAz) {
    $summaryQuery = "
        SELECT munkalap.az, szerelo.nev, hely.telepules, hely.utca
        FROM munkalap
        JOIN szerelo ON munkalap.szereloaz = szerelo.az
        JOIN hely ON munkalap.helyaz = hely.az
        WHERE hely.telepules = '" . $conn->real_escape_string($telepules) . "'
        AND munkalap.szereloaz = $szereloAz
        AND munkalap.helyaz = $munkalapHelyAz
    ";
    $result = $conn->query($summaryQuery);
      $eredmenyTabla .= "<h2>A helyszínhez a kiválasztott szerelőhöz a következő munkalapok köthetők:<br></h2>";
    $eredmenyTabla .= '<table border="1">
                        <tr>
                            <th>Munkalap</th>
                            <th>Szerelő neve</th>
                            <th>Település</th>
                            <th>Utca</th>
                        </tr>';
    while ($row = $result->fetch_assoc()) {
        $eredmenyTabla .= '<tr>
                            <td>' . htmlspecialchars($row['az']) . '</td>
                            <td>' . htmlspecialchars($row['nev']) . '</td>
                            <td>' . htmlspecialchars($row['telepules']) . '</td>
                            <td>' . htmlspecialchars($row['utca']) . '</td>
                          </tr>';
                          $alkalom =$alkalom+1;
                          $szerelonev=htmlspecialchars($row['nev']);
    }
    $eredmenyTabla .= '</table>';
    $eredmenyTabla .="<h3>".$szerelonev. " összesen ".$alkalom. " alkalommal járt kint a megadott címen."; 
}

$conn->close();
?>



               
                  <h1 class="about_taital">TCPDF minta </h1>
            <
            
   

    <form method="POST">
      <table>
         <tr>

        <!-- Település -->
        <td><label for="telepules">Település:</label></td>
        <td><select id="telepules" name="telepules" onchange="this.form.submit()">
            <option value="">Válassz...</option>
            <?= $telepulesOptions ?>
        </select>
         </td></tr>


        

        <!-- Szerelő -->
         <tr>
        <td><label for="szerelo">Szerelő:</label></td>
        <td><select id="szerelo" name="szerelo" onchange="this.form.submit()" <?= $telepules ? '' : 'disabled' ?>>
            <option value="">Válassz...</option>
            <?= $szereloOptions ?>
        </select></td>
         </tr>
        

        <!-- Munkalap -->
         <tr>

        <td><label for="munkalap">Munkalap:</label></td>
        <td><select id="munkalap" name="munkalap" onchange="this.form.submit()" <?= $szereloAz ? '' : 'disabled' ?>>
            <option value="">Válassz...</option>
            <?= $munkalapOptions ?>
        </select>
         </td>
         </tr>
      </table>
    </form>

    <!-- Táblázat -->
    <?= $eredmenyTabla ?>
   
    <h1>PDF Generálás</h1>





