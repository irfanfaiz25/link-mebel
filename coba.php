<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Bootstrap Demo</title>
    <!-- bootstrap 5 css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
        integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="//use.fontawesome.com/releases/v5.0.7/css/all.css">
    <link rel="stylesheet" href="css/style.css">

    <style>
        body {
            background-color: #eee;
        }

        .nav-link:hover {
            background-color: #525252 !important;
        }

        .nav-link .fa {
            transition: all 1s;
        }

        .nav-link:hover .fa {
            transform: rotate(360deg);
        }
    </style>
</head>

<body>
    <div class="d-flex flex-column vh-100 flex-shrink-0 p-3 text-white bg-dark" style="width: 250px;"> <a href="/"
            class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none"> <svg
                class="bi me-2" width="40" height="32"> </svg> <span class="fs-4">BBBootstrap</span> </a>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item"> <a href="#" class="nav-link active" aria-current="page"> <i
                        class="fa fa-home"></i><span class="ms-2"> Home</span> </a> </li>
            <li> <a href="#" class="nav-link text-white"> <i class="fa fa-dashboard"></i><span class="ms-2">
                        Dashboard</span> </a> </li>
            <li> <a href="#" class="nav-link text-white"> <i class="fa fa-first-order"></i><span class="ms-2"> My
                        Orders</span> </a> </li>
            <li> <a href="#" class="nav-link text-white"> <i class="fa fa-cog"></i><span class="ms-2"> Settings</span>
                </a> </li>
            <li> <a href="#" class="nav-link text-white"> <i class="fa fa-bookmark"></i><span class="ms-2">
                        Bookmarks</span> </a> </li>
        </ul>
        <hr>
        <div class="dropdown"> <a href="#"
                class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1"
                data-bs-toggle="dropdown" aria-expanded="false"> <img src="https://github.com/mdo.png" alt="" width="32"
                    height="32" class="rounded-circle me-2"> <strong> John W </strong> </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
                <li><a class="dropdown-item" href="#">New project</a></li>
                <li><a class="dropdown-item" href="#">Settings</a></li>
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
            </ul>
        </div>
    </div>
</body>

</html>