<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Darcy's Record Collection - View Record</title>
    <link rel="icon" type="image/x-icon" href="/favicon.png">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,400,700&amp;display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/css/pikaday.min.css">

    <script src="https://code.jquery.com/jquery-3.1.0.js"></script> <!--JQUERY for img hover-->

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="assets/css/Projects-Grid-images.css">
    <link rel="stylesheet" href="assets/css/Stats-icons.css">
</head>

<body>
    <nav class="navbar navbar-dark navbar-expand-lg fixed-top bg-white portfolio-navbar gradient">
        <div class="container"><img src="favicon.png" width="50" height="50">&nbsp&nbsp&nbsp&nbsp<a class="navbar-brand logo" href="index.php">Darcy's Record Collection</a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navbarNav"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php#">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="index.php#favartists">Fav Artists</a></li>
                    <li class="nav-item"><a class="nav-link active" href="index.php#stats">Stats</a></li>
                    <li class="nav-item"><a class="nav-link active" href="index.php#albums">Albums</a></li>
                    <li class="nav-item"><a class="nav-link active" href="index.php#favsingleseps">Fav Singles/EPs</a></li>
                    <li class="nav-item"><a class="nav-link active" href="index.php#wishlist">Wishlist</a></li>
                    <li class="nav-item"><a class="nav-link active" href="index.php#other">Other Formats</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main class="page lanidng-page" id="home">


        <section class="portfolio-block call-to-action border-bottom"  style="background: var(--bs-gray-100);">
            <h1 id="albums" style="text-align: center;"><strong>Viewing Record</strong></h1>
            <div class="container">
                <div class="d-flex justify-content-center align-items-center content"></div>
            </div>
            <div class="container py-4 py-xl-5" id="albums">
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
                <div class="text-center py-4">
                <div class="row gy-4 row-cols-1 row-cols-md-2 row-cols-xl-1">
                <?php
                //GET REQUEST INFO
                $currentPageUrl = 'https://' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
                $errorMsg = "<center>Invalid Request:";
                if (!str_contains($currentPageUrl, "type=")){
                    $errorMsg = $errorMsg . "<br>type is missing from request!";
                }
                if (!str_contains($currentPageUrl, "db=")){
                    $errorMsg = $errorMsg . "<br>db (database name) is missing from request!";
                }
                if (!str_contains($currentPageUrl, "id=")){
                    $errorMsg = $errorMsg . "<br>id is missing from request!";
                }
                if ($errorMsg != "<center>Invalid Request:"){
                    die($errorMsg . "</center>");
                }

                $type = htmlspecialchars($_GET["type"]);
                $databaseName = htmlspecialchars($_GET["db"]);
                $id = htmlspecialchars($_GET["id"]);

                //READ CONFIGURATION
                $configFileName = "config.conf";
                $configDBExtension = explode("|",file($configFileName)[0])[0];
                $configNewBadgeText = explode("|",file($configFileName)[1])[0];
                $configDBStartLine = explode("|",file($configFileName)[2])[0];
                $configDBDir = explode("|",file($configFileName)[3])[0];
                $configCollectedText = explode("|",file($configFileName)[4])[0];

                //GENERATE FILE DIRECTORIES
                if ($type == "album"){
                    $fileDir = $configDBDir . "/albums/" . $databaseName . "_database" . $configDBExtension;
                    $imgDir = $configDBDir . "/albums/" . $databaseName . "/";
                } else if ($type == "fav_singles_eps"){
                    $fileDir = $configDBDir . "/singles_eps/" . $databaseName . "_database" . $configDBExtension;
                    $imgDir = $configDBDir . "/singles_eps/" . $databaseName . "/";
                } else if ($type == "other_singles_eps"){
                    $fileDir = $configDBDir . "/singles_eps/" . $databaseName . "_database" . $configDBExtension;
                    $imgDir = $configDBDir . "/singles_eps/" . $databaseName . "/";
                } else if ($type == "wishlist"){
                    $fileDir = $configDBDir . "/wishlist/" . $databaseName . "_database" . $configDBExtension;
                    $imgDir = $configDBDir . "/wishlist/" . $databaseName . "/";
                } else if ($type == "other"){
                    $fileDir = $configDBDir . "/other/" . $databaseName . "_database" . $configDBExtension;
                    $imgDir = $configDBDir . "/other/" . $databaseName . "/";
                }

                //CHECK FOR VALID REQUEST TYPE
                $types = array("album", "fav_singles_eps", "other_singles_eps", "wishlist", "other");
                $errorMsg = "<center>Invalid Request:";
                $valid = false;
                for ($i = 0; $i < count($types); $i++){
                    if ($type == $types[$i]){
                        $valid = true;
                    }
                }
                if ($valid == false){
                    $errorMsg = $errorMsg . "<br>Invalid type</center>";
                    die($errorMsg);
                }

                if (!file_exists($fileDir)) {
                    $errorMsg = $errorMsg . "<br>Invalid database</center>";
                    die($errorMsg);
                }
                if ($id > count(file($fileDir))) {
                    $errorMsg = $errorMsg . "<br>Invalid ID</center>";
                    die($errorMsg);
                }
                
                if ($type == "album"){
                    //READ INFO
                    $fileContent = file($fileDir)[$id];
                    $fileItems = explode(":",$fileContent);
                    $randomID = rand();
                    $subtitle = $fileItems[0];
                    $title = $fileItems[1];
                    $description = $fileItems[2];
                    $identifier = $fileItems[3];
                    $mediaCondition = $fileItems[4];
                    $sleeveCondition = $fileItems[5];
                    $imageName = $fileItems[6];
                    $imageExtension = $fileItems[7];
                    $discogsID = $fileItems[8];
                    $newBool = $fileItems[9];
                    $numberImages = $fileItems[10];
                    $collectionDate = $fileItems[11];
                    

                    //HTML OUTPUT
                    echo "<div class='col'>\n";
                    echo "    <div class='card'>\n";
                    echo "         <div class='card-body p-4'>\n";

                    echo "<div id='images' class='carousel slide' data-bs-ride='carousel'>\n";

                    //<!-- Indicators/dots
                    echo "<div class='carousel-indicators'>\n";
                    for ($i = 0; $i < $numberImages; $i++) {
                        if ($i == 0){
                            echo "    <button type='button' data-bs-target='#images' data-bs-slide-to='" . $i . "' class='active'></button>\n";
                        } else {
                            echo "    <button type='button' data-bs-target='#images' data-bs-slide-to='" . $i . "'></button>\n";
                        }
                    }
                    echo "</div>";
                    
                    //The slideshow/carousel
                    echo "<div class='carousel-inner'>\n";
                    for ($i = 0; $i < $numberImages; $i++) {
                        $imageNumber = $i + 1;
                        if ($i == 0){
                            echo "    <div class='carousel-item active'>\n";
                            echo "    <center><img src='/" . $imgDir . $imageName . $imageNumber . $imageExtension . "' class='d-block' style='height:500px;'></center>\n";
                            echo "    </div>\n";
                        }
                        else {
                            echo "    <div class='carousel-item'>\n";
                            echo "    <center><img src='/" . $imgDir . $imageName . $imageNumber . $imageExtension . "' class='d-block' style='height:500px;'></center>\n";
                            echo "    </div>\n";
                        }
                    }
                    echo "</div>\n";
                    
                    //Left and right controls/icons
                    echo "<button class='carousel-control-prev' type='button' data-bs-target='#images' data-bs-slide='prev'>";
                    echo "    <span class='carousel-control-prev-icon'></span>";
                    echo "</button>";
                    echo "<button class='carousel-control-next' type='button' data-bs-target='#images' data-bs-slide='next'>";
                    echo "    <span class='carousel-control-next-icon'></span>";
                    echo "</button>";
                    echo "</div>";


                    //Text Info
                    echo "             <br><h4 class='card-title'><strong>" . $title . "</strong></h4>";
                    echo "             <h6 class='text-muted card-subtitle mb-2'>" . $subtitle;
                    if (str_contains($newBool, "t")){
                        echo "&nbsp&nbsp";
                        echo "<span class='badge bg-info'>" . $configNewBadgeText . "</span>";
                    }
                    echo "</h6>";
                    echo "             <p class='card-text'><strong>" . $description . "</strong><br>" . $identifier . "<br>Media Condition: " . $mediaCondition . "<br>Sleeve Condition: " . $sleeveCondition . "</p>";
                    echo "<span class='badge' style='background-color: #009ef2; color: #fff;'>" . $configCollectedText . $collectionDate . "</span><br><br>";
                    echo "             <a class='btn' style='background-color: #1d995f; color: #fff;' href='https://www.discogs.com/release/" . $discogsID . "' target='_blank' role='button'>View on Discogs</a>";
                    echo "         </div>";
                    echo "     </div>";
                    echo "</div>";
                } else if ($type == "fav_singles_eps"){
                    //READ INFO
                    $fileContent = file($fileDir)[$id];
                    $fileItems = explode(":",$fileContent);
                    $randomID = rand();
                    $subtitle = $fileItems[0];
                    $artist = $fileItems[1];
                    $title = $fileItems[2];
                    $description = $fileItems[3];
                    $identifier = $fileItems[4];
                    $mediaCondition = $fileItems[5];
                    $sleeveCondition = $fileItems[6];
                    $imageName = $fileItems[7];
                    $imageExtension = $fileItems[8];
                    $discogsID = $fileItems[9];
                    $newBool = $fileItems[10];
                    $numberImages = $fileItems[11];
                    $collectionDate = $fileItems[12];
                    

                    //HTML OUTPUT
                    echo "<div class='col'>\n";
                    echo "    <div class='card'>\n";
                    echo "         <div class='card-body p-4'>\n";

                    echo "<div id='images' class='carousel slide' data-bs-ride='carousel'>\n";

                    //<!-- Indicators/dots
                    echo "<div class='carousel-indicators'>\n";
                    for ($i = 0; $i < $numberImages; $i++) {
                        if ($i == 0){
                            echo "    <button type='button' data-bs-target='#images' data-bs-slide-to='" . $i . "' class='active'></button>\n";
                        } else {
                            echo "    <button type='button' data-bs-target='#images' data-bs-slide-to='" . $i . "'></button>\n";
                        }
                    }
                    echo "</div>";
                    
                    //The slideshow/carousel
                    echo "<div class='carousel-inner'>\n";
                    for ($i = 0; $i < $numberImages; $i++) {
                        $imageNumber = $i + 1;
                        if ($i == 0){
                            echo "    <div class='carousel-item active'>\n";
                            echo "    <center><img src='/" . $imgDir . $imageName . $imageNumber . $imageExtension . "' class='d-block' style='height:500px;'></center>\n";
                            echo "    </div>\n";
                        }
                        else {
                            echo "    <div class='carousel-item'>\n";
                            echo "    <center><img src='/" . $imgDir . $imageName . $imageNumber . $imageExtension . "' class='d-block' style='height:500px;'></center>\n";
                            echo "    </div>\n";
                        }
                    }
                    echo "</div>\n";
                    
                    //Left and right controls/icons
                    echo "<button class='carousel-control-prev' type='button' data-bs-target='#images' data-bs-slide='prev'>";
                    echo "    <span class='carousel-control-prev-icon'></span>";
                    echo "</button>";
                    echo "<button class='carousel-control-next' type='button' data-bs-target='#images' data-bs-slide='next'>";
                    echo "    <span class='carousel-control-next-icon'></span>";
                    echo "</button>";
                    echo "</div>";


                    //Text Info
                    echo "             <br><h4 class='card-title'><strong>" . $title . "</strong></h4>";
                    echo "             <h6 class='text-muted card-subtitle mb-2'>" . $artist . " - " . $subtitle;
                    if (str_contains($newBool, "t")){
                        echo "&nbsp&nbsp";
                        echo "<span class='badge bg-info'>" . $configNewBadgeText . "</span>";
                    }
                    echo "</h6>";
                    echo "             <p class='card-text'><strong>" . $description . "</strong><br>" . $identifier . "<br>Media Condition: " . $mediaCondition . "<br>Sleeve Condition: " . $sleeveCondition . "</p>";
                    echo "<span class='badge' style='background-color: #009ef2; color: #fff;'>" . $configCollectedText . $collectionDate . "</span><br><br>";
                    echo "             <a class='btn' style='background-color: #1d995f; color: #fff;' href='https://www.discogs.com/release/" . $discogsID . "' target='_blank' role='button'>View on Discogs</a>";
                    echo "         </div>";
                    echo "     </div>";
                    echo "</div>";
                } else if ($type == "other_singles_eps"){
                    //READ INFO
                    $fileContent = file($fileDir)[$id];
                    $fileItems = explode(":",$fileContent);
                    $randomID = rand();
                    $artist = $fileItems[0];
                    $format = $fileItems[1];
                    $title = $fileItems[2];
                    $description = $fileItems[3];
                    $identifier = $fileItems[4];
                    $condition = $fileItems[5];
                    $imageName = $fileItems[6];
                    $imageExtension = $fileItems[7];
                    $discogsID = $fileItems[8];
                    $numberImages = $fileItems[9];
                    $collectionDate = $fileItems[10];
                    

                    //HTML OUTPUT
                    echo "<div class='col'>\n";
                    echo "    <div class='card'>\n";
                    echo "         <div class='card-body p-4'>\n";

                    echo "<div id='images' class='carousel slide' data-bs-ride='carousel'>\n";

                    //<!-- Indicators/dots
                    echo "<div class='carousel-indicators'>\n";
                    for ($i = 0; $i < $numberImages; $i++) {
                        if ($i == 0){
                            echo "    <button type='button' data-bs-target='#images' data-bs-slide-to='" . $i . "' class='active'></button>\n";
                        } else {
                            echo "    <button type='button' data-bs-target='#images' data-bs-slide-to='" . $i . "'></button>\n";
                        }
                    }
                    echo "</div>";
                    
                    //The slideshow/carousel
                    echo "<div class='carousel-inner'>\n";
                    for ($i = 0; $i < $numberImages; $i++) {
                        $imageNumber = $i + 1;
                        if ($i == 0){
                            echo "    <div class='carousel-item active'>\n";
                            echo "    <center><img src='/" . $imgDir . $imageName . $imageNumber . $imageExtension . "' class='d-block' style='height:500px;'></center>\n";
                            echo "    </div>\n";
                        }
                        else {
                            echo "    <div class='carousel-item'>\n";
                            echo "    <center><img src='/" . $imgDir . $imageName . $imageNumber . $imageExtension . "' class='d-block' style='height:500px;'></center>\n";
                            echo "    </div>\n";
                        }
                    }
                    echo "</div>\n";
                    
                    //Left and right controls/icons
                    echo "<button class='carousel-control-prev' type='button' data-bs-target='#images' data-bs-slide='prev'>";
                    echo "    <span class='carousel-control-prev-icon'></span>";
                    echo "</button>";
                    echo "<button class='carousel-control-next' type='button' data-bs-target='#images' data-bs-slide='next'>";
                    echo "    <span class='carousel-control-next-icon'></span>";
                    echo "</button>";
                    echo "</div>";


                    //Text Info
                    echo "             <br><h4 class='card-title'><strong>" . $title . "</strong></h4>";
                    echo "             <h6 class='text-muted card-subtitle mb-2'>" . $artist;
                    echo "</h6>";
                    echo "             <p class='card-text'><strong>" . $description . "</strong><br>" . $format . "<br>" . $identifier . "<br>Condition: " . $condition . "</p>";
                    echo "<span class='badge' style='background-color: #009ef2; color: #fff;'>" . $configCollectedText . $collectionDate . "</span><br><br>";
                    echo "             <a class='btn' style='background-color: #1d995f; color: #fff;' href='https://www.discogs.com/release/" . $discogsID . "' target='_blank' role='button'>View on Discogs</a>";
                    echo "         </div>";
                    echo "     </div>";
                    echo "</div>";
                } else if ($type == "wishlist"){
                    //READ INFO
                    $fileContent = file($fileDir)[$id];
                    $fileItems = explode(":",$fileContent);
                    $randomID = rand();
                    $artist = $fileItems[0];
                    $subtitle = $fileItems[1];
                    $title = $fileItems[2];
                    $description = $fileItems[3];
                    $imageName = $fileItems[4];
                    $imageExtension = $fileItems[5];
                    $discogsID = $fileItems[6];
                    $newBool = $fileItems[7];
                    $numberImages = $fileItems[8];
                    

                    //HTML OUTPUT
                    echo "<div class='col'>\n";
                    echo "    <div class='card'>\n";
                    echo "         <div class='card-body p-4'>\n";

                    echo "<div id='images' class='carousel slide' data-bs-ride='carousel'>\n";

                    //<!-- Indicators/dots
                    echo "<div class='carousel-indicators'>\n";
                    for ($i = 0; $i < $numberImages; $i++) {
                        if ($i == 0){
                            echo "    <button type='button' data-bs-target='#images' data-bs-slide-to='" . $i . "' class='active'></button>\n";
                        } else {
                            echo "    <button type='button' data-bs-target='#images' data-bs-slide-to='" . $i . "'></button>\n";
                        }
                    }
                    echo "</div>";
                    
                    //The slideshow/carousel
                    echo "<div class='carousel-inner'>\n";
                    for ($i = 0; $i < $numberImages; $i++) {
                        $imageNumber = $i + 1;
                        if ($i == 0){
                            echo "    <div class='carousel-item active'>\n";
                            echo "    <center><img src='/" . $imgDir . $imageName . $imageNumber . $imageExtension . "' class='d-block' style='height:500px;'></center>\n";
                            echo "    </div>\n";
                        }
                        else {
                            echo "    <div class='carousel-item'>\n";
                            echo "    <center><img src='/" . $imgDir . $imageName . $imageNumber . $imageExtension . "' class='d-block' style='height:500px;'></center>\n";
                            echo "    </div>\n";
                        }
                    }
                    echo "</div>\n";
                    
                    //Left and right controls/icons
                    echo "<button class='carousel-control-prev' type='button' data-bs-target='#images' data-bs-slide='prev'>";
                    echo "    <span class='carousel-control-prev-icon'></span>";
                    echo "</button>";
                    echo "<button class='carousel-control-next' type='button' data-bs-target='#images' data-bs-slide='next'>";
                    echo "    <span class='carousel-control-next-icon'></span>";
                    echo "</button>";
                    echo "</div>";


                    //Text Info
                    echo "             <br><h4 class='card-title'><strong>" . $title . "</strong></h4>";
                    echo "             <h6 class='text-muted card-subtitle mb-2'>" . $artist . " - " . $subtitle;
                    if (str_contains($newBool, "t")){
                        echo "&nbsp&nbsp";
                        echo "<span class='badge bg-info'>" . $configNewBadgeText . "</span>";
                    }
                    echo "</h6>";
                    echo "             <p class='card-text'><strong>" . $description . "</strong>" . "</p>";
                    echo "<span class='badge' style='background-color: #ffc907; color: #fff;'>" . "Wishlist Item" . "</span>";
                    echo "<br><br>";
                    echo "             <a class='btn' style='background-color: #1d995f; color: #fff;' href='https://www.discogs.com/release/" . $discogsID . "' target='_blank' role='button'>View on Discogs</a>";
                    echo "         </div>";
                    echo "     </div>";
                    echo "</div>";
                } else if ($type == "other"){
                    //READ INFO
                    $fileContent = file($fileDir)[$id];
                    $fileItems = explode(":",$fileContent);
                    $randomID = rand();
                    $artist = $fileItems[0];
                    $format = $fileItems[1];
                    $title = $fileItems[2];
                    $identifier = $fileItems[3];
                    $condition = $fileItems[4];
                    $imageName = $fileItems[5];
                    $imageExtension = $fileItems[6];
                    $onDiscogsBool = $fileItems[7];
                    $discogsID = $fileItems[8];
                    $newBool = $fileItems[9];
                    $numberImages = $fileItems[10];
                    $collectionDate = $fileItems[11];
                    

                    //HTML OUTPUT
                    echo "<div class='col'>\n";
                    echo "    <div class='card'>\n";
                    echo "         <div class='card-body p-4'>\n";

                    echo "<div id='images' class='carousel slide' data-bs-ride='carousel'>\n";

                    //<!-- Indicators/dots
                    echo "<div class='carousel-indicators'>\n";
                    for ($i = 0; $i < $numberImages; $i++) {
                        if ($i == 0){
                            echo "    <button type='button' data-bs-target='#images' data-bs-slide-to='" . $i . "' class='active'></button>\n";
                        } else {
                            echo "    <button type='button' data-bs-target='#images' data-bs-slide-to='" . $i . "'></button>\n";
                        }
                    }
                    echo "</div>";
                    
                    //The slideshow/carousel
                    echo "<div class='carousel-inner'>\n";
                    for ($i = 0; $i < $numberImages; $i++) {
                        $imageNumber = $i + 1;
                        if ($i == 0){
                            echo "    <div class='carousel-item active'>\n";
                            echo "    <center><img src='/" . $imgDir . $imageName . $imageNumber . $imageExtension . "' class='d-block' style='height:500px;'></center>\n";
                            echo "    </div>\n";
                        }
                        else {
                            echo "    <div class='carousel-item'>\n";
                            echo "    <center><img src='/" . $imgDir . $imageName . $imageNumber . $imageExtension . "' class='d-block' style='height:500px;'></center>\n";
                            echo "    </div>\n";
                        }
                    }
                    echo "</div>\n";
                    
                    //Left and right controls/icons
                    echo "<button class='carousel-control-prev' type='button' data-bs-target='#images' data-bs-slide='prev'>";
                    echo "    <span class='carousel-control-prev-icon'></span>";
                    echo "</button>";
                    echo "<button class='carousel-control-next' type='button' data-bs-target='#images' data-bs-slide='next'>";
                    echo "    <span class='carousel-control-next-icon'></span>";
                    echo "</button>";
                    echo "</div>";


                    //Text Info
                    echo "             <br><h4 class='card-title'><strong>" . $title . "</strong></h4>";
                    echo "             <h6 class='text-muted card-subtitle mb-2'>" . $artist . " - " . $format;
                    if (str_contains($newBool, "t")){
                        echo "&nbsp&nbsp";
                        echo "<span class='badge bg-info'>" . $configNewBadgeText . "</span>";
                    }
                    echo "</h6>";
                    echo "             <p class='card-text'>" . $identifier . "<br>Condition: " . $condition . "</p>";
                    echo "<span class='badge bg-primary'>" . $configCollectedText . $collectionDate . "</span><br><br>";
                    if (str_contains($onDiscogsBool,"t")){
                        echo "             <a class='btn' style='background-color: #1d995f; color: #fff;' href='https://www.discogs.com/release/" . $discogsID . "' target='_blank' role='button'>View on Discogs</a>";
                    } else {
                        echo "             <a class='btn btn-danger' target='_blank' role='button'>Unavailable on Discogs</a>";
                    }
                    echo "         </div>";
                    echo "     </div>";
                    echo "</div>";
                }
                ?>
                </div>
                </div>
            </section>

<footer class="text-center py-4" style="background: var(--bs-gray-100);">

<div class="col">
    <ul class="list-inline my-2">
        <li class="list-inline-item me-4"></li>
        <li class="list-inline-item me-4"></li>
        <li class="list-inline-item"></li>
        </ul>
        <a class="link-secondary" href="mailto:darcywdjohnson@gmail.com">Email</a>
        <br>
        <a class="link-secondary" href="https://github.com/DarcyJProjects/PHP-Vinyl-Record-Collection" target="_blank">Source Code</a>
        <p class='text-muted my-2'>Made with <a class="link-secondary" href="https://getbootstrap.com/docs/5.1/getting-started/introduction/" target="_blank">Bootstrap 5.1</a> + <a class="link-secondary" href="https://github.com/DarcyJProjects/PHP-Vinyl-Record-Collection" target="_blank">Custom JS & PHP Scripts!</a></p> 
        <?php
        $year = date("Y");
        if ($year == "2022"){
        echo "<p class='text-muted my-2'>Copyright © 2022 Darcy Johnson.</p>";
        } else {
        echo "<p class='text-muted my-2'>Copyright © 2022-" . $year . " Darcy Johnson.</p>";
        }
        ?>
</div>
<script src="assets/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.11.1/baguetteBox.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pikaday/1.6.1/pikaday.min.js"></script>
<script src="assets/js/Lightbox-Gallery.js"></script>
<script src="assets/js/theme.js"></script>
</body>

</html>