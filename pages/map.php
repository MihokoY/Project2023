<?php
// Start session processing
session_start();

// Connect to the database
require('../php/dbconnect.php');
// Get sites information from the sites table
$stmt = $db->prepare("SELECT * FROM sites WHERE flg = 1");
$stmt->execute();

// Initialize array
$siteData = array();

// Get results in the array
while($row = $stmt->fetch(PDO::FETCH_ASSOC)){ 
    $siteData[] = array(
        'id' => $row['id'],
        'latitude' => $row['latitude'],
        'longitude' => $row['longitude'],
        'name' => $row['name'],
        'description' => $row['description'],
        'image' => $row['image']
    );
}

// Convert PHP array to JSON formatted data
$json = json_encode($siteData);

//Initialize array
$json2 = "[]";
$json3 = "[]";

// If the user is logged in
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $login_user_id = $_SESSION["user_id"];

    // Get favourite site ID of the user
    $stmt2 = $db->prepare("SELECT * FROM mymap WHERE user_id = $login_user_id");
    $stmt2->execute();
    $siteIds = array();
    // Get results in the array
    while($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){ 
        $siteIds[] = array(
            'site_id' => $row2['site_id']
        );
    }
    // Convert PHP array to JSON formatted data
    $json2 = json_encode($siteIds);
    
}else{
    // If the user is not logged in, set a parameter
    $param[] = array(
        "member" => "no"
    );
    // Convert PHP array to JSON formatted data
    $json3 = json_encode($param);
}

?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Map</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
              integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" 
              crossorigin="anonymous">
        <link rel="stylesheet" href="../css/external.css">
        <link rel="stylesheet" href="../css/external_footer.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
         integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
         crossorigin=""/>
        <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>-->
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
         integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
         crossorigin=""></script>    
    </head>
    <body>
        <!-- Top menu -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand title" href="#">Archaeological map in Ireland</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <!-- Menu for logged in users -->
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
                            <a class="nav-link" href="../pages/mysites.php">My sites</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../php/logout.php">Logout</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white">&#128100;<?php echo $_SESSION["user_name"]; ?></a>
                        </li>
                    </ul>
                </div>
                <!-- Menu for not logged in users -->
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
                            <a class="nav-link" href="../pages/register.php">Join us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../pages/login.php">Login</a>
                        </li>
                    </ul>
                </div>
                <?php endif ?>
            </div>
        </nav>

        <!-- Map -->
        <div id="map"></div>

        <script>
            // Initial display coordinates
            var map = L.map('map', {
                // Limit display to Ireland
                maxBounds: [[55.691918, -11.272559], [51.082822, -5.073562]]
                }).setView([53.4494762, -7.5029786], 7); // Central point
                       
            // Add a OpenStreetMap tile layer
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            // Initial popup display
            var popup = L.popup()
            .setLatLng([54.769009, -10.042556])
            .setContent("<b>Let's explore map!</b>")
            .openOn(map);
    
            // When the "Add to my map" button is clicked
            function onButtonClick() {
                answer = confirm('Do you want to add this site to your map?');
                if(answer === true){
                    // Invoke the addFav.php
                    fetch('../php/addFav.php');
 
                    // Show the message
                    if(!alert('Added!')){
                        window.location.reload();
                    }
                }
            }

            // When the marker is clicked
            function onMarkerClick(e){
                //alert(e.target.id);
                fetch('../php/getSiteID.php', { // Destination
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(e.target.siteId.toString()) // Convert siteID to json format and attach
                });
            }

            // Passing the array from PHP to JavaScript to show markers
            var array = <?php echo $json; ?>;
            var array2 = <?php echo $json2; ?>;
            var array3 = <?php echo $json3; ?>;
            var markers;
            
            // Display markers from the array
            // Non member
            if(array3.length !== 0 && array2.length === 0){
                //alert('if');
                array.forEach(elm => {
                    // With image
                    if(elm['image'] !== null){
                        markers = L.marker([elm['latitude'],elm['longitude']])
                                .addTo(map)
                                .bindPopup("<b>"+ elm['name'] +"</b><br>" + elm['description']
                                            +"<br><img src=\"../images/"+ elm['image']+"\" width=\"200\" height=\"auto\">");
                        
                    // Without image
                    }else{
                        markers = L.marker([elm['latitude'],elm['longitude']])
                                .addTo(map)
                                .bindPopup("<b>"+ elm['name'] +"</b><br>" + elm['description']);
                    }
                });
                
            // Member with some favourites
            }else if(array2.length !== 0){
                //alert('elseif');
                array.forEach(elm => {            
                    //document.write(elm['name']+'<br>');            
                    
                    array2.some(elm2 => {
                        //document.write(elm['id']+'<br>');
                        //document.write(elm2['site_id']+'<br>');
                        
                        // Favourite site
                        if(elm['id'] === elm2['site_id']){
                            // With image
                            if(elm['image'] !== null){
                                markers = L.marker([elm['latitude'],elm['longitude']])
                                        .addTo(map)
                                        .bindPopup("<b>"+ elm['name'] +"</b><br>" + elm['description']
                                                    +"<br><img src=\"../images/"+ elm['image']+"\" width=\"200\" height=\"auto\">");
                                return true;
                                
                            // Without image
                            }else{
                                markers = L.marker([elm['latitude'],elm['longitude']])
                                        .addTo(map)
                                        .bindPopup("<b>"+ elm['name'] +"</b><br>" + elm['description']);
                                return true;
                            }
                        // Not Favourite site
                        }else{
                            // With image
                            if(elm['image'] !== null){
                                markers = L.marker([elm['latitude'],elm['longitude']])
                                        .addTo(map)
                                        .on( 'click', function(e) {  onMarkerClick(e); }) // When the marker is clicked
                                        .bindPopup("<b>"+ elm['name'] +"</b><br>" + elm['description']
                                                    +"<br><img src=\"../images/" + elm['image']
                                                    +"\" width=\"200\" height=\"auto\"><br>\n\
                                                    <br><input type=\"button\" value=\"Add to my map\" name=\"addF\" onclick=\"onButtonClick();\">");
                                markers.siteId = elm['id']; //Used when this marker is clicked
                                
                            // Without image
                            }else{
                                markers = L.marker([elm['latitude'],elm['longitude']])
                                        .addTo(map)
                                        .on( 'click', function(e) {  onMarkerClick(e); }) // When the marker is clicked
                                        .bindPopup("<b>"+ elm['name'] +"</b><br>" + elm['description'] 
                                               +"<br><br><input type=\"button\" value=\"Add to my map\" name=\"addF\" onclick=\"onButtonClick();\">");
                                markers.siteId = elm['id']; //Used when this marker is clicked
                            }
                        }
                    });
                });
                
            // Member without favourite
            }else{
                //alert('else');
                array.forEach(elm => {
                    // With image
                    if(elm['image'] !== null){
                        markers = L.marker([elm['latitude'],elm['longitude']])
                                .addTo(map)
                                .on( 'click', function(e) {  onMarkerClick(e); }) // When the marker is clicked
                                .bindPopup("<b>"+ elm['name'] +"</b><br>" + elm['description']
                                            +"<br><img src=\"../images/" + elm['image']
                                            +"\" width=\"200\" height=\"auto\"><br>\n\
                                            <br><input type=\"button\" value=\"Add to my map\" name=\"addF\" \n\
                                            onclick=\"onButtonClick();\">");
                        markers.siteId = elm['id']; //Used when this marker is clicked
                    
                    // Without image
                    }else{
                        markers = L.marker([elm['latitude'],elm['longitude']])
                                .addTo(map)
                                .on( 'click', function(e) {  onMarkerClick(e); }) // When the marker is clicked
                                .bindPopup("<b>"+ elm['name'] +"</b><br>" + elm['description'] 
                                            +"<br><br><input type=\"button\" value=\"Add to my map\" name=\"addF\" \n\
                                            onclick=\"onButtonClick();\">");
                        markers.siteId = elm['id']; //Used when this marker is clicked
                    }
                });
            }
            
            // Show coordinates of the clicked point
            var popup = L.popup();
            function onMapClick(e) {
                popup
                    .setLatLng(e.latlng)
                    .setContent("You clicked the map at " + e.latlng.toString() 
                                + "&nbsp;&nbsp;&nbsp;<input type=\"button\" value=\"Add new site here⇒\" name=\"add\" \n\
                                onclick=\"location.href='../pages/addsite.php'\">")
                    .openOn(map);

                // Pass coordinate value to PHP
                fetch('../php/getCoordinate.php', { // Destination
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(e.latlng.toString()) // Convert to json format and attach
                });
            }
            
            map.on('click', onMapClick);

        </script>

        <!-- Footer -->
        <footer class="footer bg-dark">
            <div class="container text-center mt-2">
                <p class="text-white title">©2023 Archaeology club, Inc. All Rights Reserved</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
                integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
                crossorigin="anonymous"></script>
    </body>
</html>