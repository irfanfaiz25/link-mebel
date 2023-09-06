<?php


$curPageName = substr($_SERVER["SCRIPT_NAME"], strrpos($_SERVER["SCRIPT_NAME"], "/") + 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="css/style.css">


    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/dataTables.bootstrap5.min.css" />

    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js"></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>Link Meubel Admin</title>
    <link rel="icon" href="../image/logo-title.png">
</head>

<body>

    <div>
        <div class="sidebar p-4 d-flex flex-column vh-100 flex-shrink-0 p-3 text-white bg-dark" id="sidebar">
            <a class="sidebar-brand logo-sbn">
                <img src="../image/logo-meubel.png" alt="logo" width="120">
            </a>

            <div class="margin-set">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="mar">
                        <a class="nav-link text-white 
                        <?php
                        if ($curPageName == "index.php") {
                            echo 'active';
                        }
                        ?>
                        " href="index.php">
                            <i class="fa fa-home ic mr-2"></i>
                            Dashboard
                        </a>
                    </li>
                    <li class="mar">
                        <a class="nav-link text-white 
                        <?php
                        if ($curPageName == "produk.php") {
                            echo 'active';
                        }
                        ?>" href="produk.php">
                            <i class="fa fa-chair ic mr-2"></i>
                            Produk
                        </a>
                    </li>
                    <li class="mar">
                        <a class="nav-link text-white 
                        <?php
                        if ($curPageName == "order.php") {
                            echo 'active';
                        }
                        ?>" href="order.php">
                            <i class="fa fa-truck-ramp-box ic mr-2"></i>Order
                        </a>
                    </li>
                    <li class="mar">
                        <a class="nav-link text-white 
                        <?php
                        if ($curPageName == "transaction.php") {
                            echo 'active';
                        }
                        ?>
                        " href="transaction.php">
                            <i class="fa fa-truck-fast ic mr-2"></i>Transaction
                        </a>
                    </li>
                    <li class="mar">
                        <a class="nav-link text-white 
                        <?php
                        if ($curPageName == "history.php") {
                            echo 'active';
                        }
                        ?>
                        " href="history.php">
                            <i class="fa fa-clock-rotate-left ic mr-2"></i>
                            History
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>