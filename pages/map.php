<?php
session_start();

// If the user is logged in, redirect to this page
//if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//    header("location: login.php");
//    exit;
//}


// Connect to the database and execute query
require('dbconnect.php');
//$stmt = $db->prepare("SELECT name,description,X(coordinate),Y(coordinate) FROM site");
$stmt = $db->prepare("SELECT latitude,longitude,name,description FROM sites");
$stmt->execute();

// Initialize array
$siteData=array();
while($row=$stmt->fetch(PDO::FETCH_ASSOC)){ // Get results in the array
    $siteData[]=array(
        //'coordinate'=>$row['coordinate'],
        //'latitude'=>$row['X(coordinate)'],
        //'longitude '=>$row['Y(coordinate)'],
        'latitude'=>$row['latitude'],
        'longitude'=>$row['longitude'],
        'name'=>$row['name'],
        'description'=>$row['description']
    );
}

// Convert PHP array to JSON formatted data
$json = json_encode($siteData);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Map</title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/external.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>-->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>
    <style>
    #map {
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 80%;
        height: 650px;
    }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand title" href="#">Archaeological map in Ireland</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true): ?>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/map.php">Explore map</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/mymap.php">My map</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/logout.php">Logout</a>
                    </li>
                </ul>
            </div>
            <?php else: ?>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="../index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/map.php">Explore map</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/register.php">Join member</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../pages/login.php">Login</a>
                    </li>
                </ul>
            </div>
            <?php endif ?>
        </div>
    </nav>
    
    <div id="map"></div>

    <script>
        var map = L.map('map').setView([53.4494762, -7.5029786], 7);
        
        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
        
        var popup = L.popup()
        .setLatLng([54.769009, -10.042556])
        .setContent("<b>Let's explore map!</b>")
        .openOn(map);
    
        // Passing the array from PHP to JavaScript
        var array = <?php echo $json; ?>;
        var markers;
        array.forEach(elm => {
            document.write(elm['latitude']+'<br>'+elm['longitude']+'<br>'+elm['name']+'<br>'+elm['description']+'<br>');            
            //markers = L.marker([elm['coordinate']]).addTo(map).bindPopup("<b>"+ elm['name'] +"</b><br>" + elm['description']);
            markers = L.marker([elm['latitude'],elm['longitude']]).addTo(map).bindPopup("<b>"+ elm['name'] +"</b><br>" + elm['description']);
        });
        //var marker = L.marker([53.694861544342544, -6.475607190321141]).addTo(map).bindPopup("<b>Brú na Bóinne</b><br>Newgrange is a 5,200 year old passage tomb");
        //markers = L.marker([53.694715,-6.478072]).addTo(map).bindPopup("<b>Brú na Bóinne</b><br>Newgrange is a 5,200 year old passage tomb");
        //markers = L.marker([53.7020057,-6.5312538]).addTo(map).bindPopup("<b>Brú na Bóinne2</b><br>Newgrange is a 5,200 year old passage tomb");
        
        var popup = L.popup();
        function onMapClick(e) {
            popup
                .setLatLng(e.latlng)
                .setContent("You clicked the map at " + e.latlng.toString())
                .openOn(map);
        }
        map.on('click', onMapClick);
        
    </script>
    

</body>
</html>