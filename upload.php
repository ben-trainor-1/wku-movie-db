<!doctype html>
<html lang="en">

<head>

    <title>IMDb | Results</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    
    <!-- Other CSS -->
    <link href="css/main.css" rel="stylesheet">

    <!-- Scripts -->
    <script src="js/script.js"></script>

</head>

<body>

    <!-- Main container -->
    <div class="row m-0 p-0">

        <div class="col-xxl-2 col-lg-1 m-0 p-0"></div>
        <div class="col-xxl-8 col-lg-10 col-12 m-0 p-0">

            <!-- Table display -->
            <div class="row m-0 p-0">
                
                <table id="movie_table" class="table m-0 p-0">

                    <!-- Process csv and display -->
                    <?php
                        
                        // Upload files to XAMPP temp folder
                        $targetDir = "../../temp/";
                        $files = array_filter($_FILES["files"]["name"]);
                        $count = count($_FILES["files"]["name"]);
                        $initCheck = true;

                        // No files uploaded
                        if ($count == 1 && $_FILES["files"]["name"][0] == null) {
                            echo "<p class=\"m-0 p-4 pb-0\">You did not upload any files.</p>";
                            $initCheck = false;
                        }
                        // 1 or > 2 files uploaded
                        else if ($count != 2 && $_FILES["files"]["name"][0] != null) {
                            echo "<p class=\"m-0 p-4 pb-0\">You should have uploaded <b>2 files</b>, not <b>$count</b>.</p>";
                            $initCheck = false;
                        }
                        // Wrong file types
                        else {
                            $initCheck = true;
                            for ($i = 0; $i < $count; $i++) {
                                if (strtolower(pathinfo($_FILES["files"]["name"][$i], PATHINFO_EXTENSION)) != "csv") {
                                    $initCheck = false;
                                    echo "<p class=\"m-0 p-4 pb-0\">Please only upload <b>.csv</b> files.</p>";
                                    break;
                                }
                            }
                        }

                        // Passed all checks
                        if ($initCheck == true) {

                            for ($i = 0; $i < $count; $i++) {
                                
                                $destination = $targetDir . basename($_FILES["files"]["name"][$i]); // Full directory path to store file
                                $uploadOk = true;
                                $fileType = strtolower(pathinfo($destination, PATHINFO_EXTENSION));
                                
                                // Check if file is correct type
                                if (isset($_POST["submit"])) {

                                    $uploadOk = true;

                                    // Check file size
                                    if ($_FILES["files"]["size"][$i] > 500000000) {
                                        echo "<p class=\"m-0 p-4 pb-0\">Sorry, your file is <b>too large</b>.</p>";
                                        $uploadOk = false;
                                    }
                                    // Make sure file was processed correctly
                                    if ($uploadOk == false) {
                                        echo "<p class=\"m-0 p-4 pb-0\">A file was not uploaded.</p>";
                                        break;
                                    }
                                    else {
                                        // echo "File passed checks. Trying to upload.<br>";
                                        if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $destination)) {
                                            // echo "File is valid, and was successfully uploaded.<br>";
                                        } 
                                        else {
                                            echo "Upload failed<br>";
                                        }
                                    }

                                }
                                else {
                                    $uploadOk = false;
                                }

                            }

                        }

                        if ($uploadOk == true && $initCheck == true) {
                            displayTable();
                        }
                        else {
                            echo "<p class=\"m-0 p-4\"><a href=\"index.html\">Go back</a></p>";
                        }

                        function displayTable() {

                            // Process files, check for errors
                            // If no errors, open the temp file
                            // echo "Attempting to open file. <br>";
                            if (($titlesFile  = fopen("../../temp/titles.csv", "r")) !== false) {

                                // echo "File opened.";
                                $err = false;
                                $row = 0;
                                $finalTable = array(
                                                array("TITLE", "TYPE", "DIRECTORS", "ACTORS")
                                            );
                                
                                // Make sure titles file can be read
                                // Find title IDs, show whether it's a movie/show, count movies/shows
                                $movieCount = 0;
                                $showCount = 0;
                                
                                while (($data = fgetcsv($titlesFile, 3000, ",")) !== false) {
                                    // Skip header row
                                    if ($row > 0) {
                                        // Store first three entries in new array
                                        $finalTable[$row][0] = $data[0]; // ID
                                        $finalTable[$row][1] = $data[1]; // Title
                                        $finalTable[$row][2] = $data[2]; // Type
                                        $finalTable[$row][3] = 0; // Initialize Directors count
                                        $finalTable[$row][4] = 0; // Initialize Actors count
                                        // Count movies and shows
                                        if (str_contains($finalTable[$row][0], "m")) $movieCount++;
                                        else if (str_contains($finalTable[$row][0], "s")) $showCount++;
                                    }
                                    $row++;
                                }

                                fclose($titlesFile);
                                
                            }
                            else {
                                $err = true;
                                exit;
                            }
                            
                            // Make sure credits file can be read and that the previous file could be read
                            $creditsTable = array();
                            if (($creditsFile  = fopen("../../temp/credits.csv", "r")) !== false && $err == false) {
                                
                                // Parse csv into an array
                                $row = 0;
                                while (($data = fgetcsv($creditsFile, 3000, ",")) !== false && $row <= sizeof($creditsTable)) {
                                    $creditsTable[$row] = $data;
                                    $row++;
                                }
                                fclose($creditsFile);
                                
                                // Iterate through unique movie/show IDs and count directors/actors in creditsTable
                                for ($i = 0; $i < sizeof($finalTable); $i++) {
                                    // Iterate through rows of credits table
                                    for ($j = 0; $j < sizeof($creditsTable); $j++) {
                                        // If movie/show IDs match, count actors and directors
                                        if ($creditsTable[$j][1] == $finalTable[$i][0]) {
                                            if (strtolower($creditsTable[$j][4]) == "director") $finalTable[$i][3]++;
                                            if (strtolower($creditsTable[$j][4]) == "actor") $finalTable[$i][4]++;
                                        }
                                    }

                                }
                                
                            }
                            else {
                                $err = true;
                                exit;
                            }

                            // Display results
                            if ($err == false) {

                                // Display movie and show counts
                                echo "
                                    <div class=\"row m-0 p-3\">
                                        <div class=\"row border-bottom m-0 pt-0 pb-3\">
                                            <h1 class=\"text-center m-0 p-0 fw-bold\">Results</h1>
                                        </div>
                                        <div class=\"row m-0 pt-3 pb-0\">
                                            <div class=\"col-md-6 m-0 p-0\">
                                                <h2 class=\"m-0 p-0 pb-2\">Number of movies: <b>" . $movieCount . "</b>
                                                <h2 class=\"m-0 p-0\">Number of shows: <b>" . $showCount . "</b>
                                            </div>
                                            <div class=\"col-md-6 m-0 p-0 pt-md-0 pb-md-0 pt-3 pb-2\">
                                                <label id=\"search_label\" class=\"w-100\" for=\"search\"><b>Search</b></label>
                                                <input class=\"form-control\" type=\"text\" id=\"search\" onkeyup=\"searchTable()\" placeholder=\"Look up movies or shows...\">
                                            </div>
                                        </div>
                                    </div>
                                ";

                                // Main table display
                                for ($i = 0; $i < sizeof($finalTable); $i++) {
                                    // Header row
                                    if ($i == 0) {
                                        echo "<tr class=\"table bg-primary text-white border-0 m-0 p-0\">";
                                        for ($j = 0; $j < sizeof($finalTable[$i]); $j++) {
                                            // Add onclick events for sorting by columns
                                            if ($j == 0) {
                                                echo "<th class=\"border-0 fw-bold fs-3 text-start m-0 p-3\" onclick=\"sortTable($j)\">" . $finalTable[$i][$j] . "</th>";
                                            }
                                            else {
                                                echo "<th class=\"border-0 fw-bold fs-3 text-center m-0 p-3\" onclick=\"sortTable($j)\">" . $finalTable[$i][$j] . "</th>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                    // Other rows
                                    else {
                                        echo "<tr class=\"m-0 p-0\">";
                                        for ($j = 1; $j < sizeof($finalTable[$i]); $j++) {
                                            // Left justify the first column
                                            if ($j == 1) {
                                                echo "<td class=\"text-start m-0 p-2 ps-3\">" . $finalTable[$i][$j] . "</td>";
                                            }
                                            // Center other columns
                                            else {
                                                echo "<td class=\"text-center m-0 p-2\">" . $finalTable[$i][$j] . "</td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                }

                            }
                            // Shouldn't be reachable, but just in case
                            else {
                                exit;
                            }
                        }
                    
                    ?>

                </table>
                
            </div>

        </div>
        
    </div>

    <footer class="row text-center m-0 p-0">
        <div class="col-xxl-2 col-lg-1 m-0 p-0"></div>
        <div class="col-xxl-8 col-lg-10 col-12 bg-white m-0 p-2">
            <p class="m-0 p-0"><a href="https://iconscout.com/icons/search" target="_blank">Free Search Icon</a> by <a href="https://iconscout.com/contributors/eva-icons" target="_blank">Akveo</a></p>
        </div>
    </footer>



    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

</body>

</html>