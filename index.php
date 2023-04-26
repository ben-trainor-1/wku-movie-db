<!DOCTYPE html>

<html>

<head>

    <title>IMDb | Upload</title>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    
    <link href="css/main.css" rel="stylesheet">

</head>

<body>

    <div id="form_container" class="row position-absolute w-100 m-0 p-0">
        <div class="col-xl-3 col-lg-1"></div>
        <div class="col-xl-6 col-lg-10 text-center align-items-center m-0 p-3">
            <form action="upload.php" method="post" enctype="multipart/form-data" class="form">
                <h3 class="fw-bold m-0 p-0 pb-2">Upload files</h3>
                <p class="fst-italic m-0 p-0 pb-2">Make sure they are named <b>titles.csv</b> and <b>credits.csv</b>.</p>
                <div class="row w-100 m-0 p-0">
                    <div class="col-sm-6 m-0 p-2">
                        <input class="form-control m-0 p-3 ps-4" type="file" name="files[]" id="files" multiple>
                    </div>
                    <div class="col-sm-6 m-0 p-2">
                        <input class="form-control btn btn-primary m-0 p-3" type="submit" value="Upload" name="submit">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>
    
</body>

</html>