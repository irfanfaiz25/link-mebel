<?php
include '../fungsi/fungsi.php';
include 'fungsi-index.php';
include 'header.php';
?>
<section class="p-4" id="main-content">
    <div class="row">
        <div class="col-md-1">
            <button class="btn btn-outline-secondary mc" id="button-toggle">
                <i class="bi bi-list nav-col"></i>
            </button>
        </div>
        <div class="col-md-9 float-start">
            <h1><b>DASHBOARD</b></h1>
            <p style="margin-bottom: -7px; margin-top: -5px; color: #7B8FA1 !important;">Link-Meubel</p>
        </div>
        <div class="col-md-2">
            <button class="btn btn-outline-secondary mc float-end" id="button-toggle">
                <i class="fa fa-right-from-bracket nav-col"></i>
            </button>
        </div>
    </div>

    <div class="card mt-5">
        <div class="card-body">

            <!-- tabel data barang -->
            <div class="row dataku">
                <div class="container">
                    <div class="row">
                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-blue order-card">
                                <div class="card-block">
                                    <h6 class="m-b-20 text-light">Total Product</h6>
                                    <h2 class="text-right text-light fs-2 mb-1"><i class="fa fa-chair f-left"></i><span
                                            class="ps-2"><?= $count_total_product; ?></span>
                                    </h2>
                                    <p class="mb-0">Items</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-green order-card">
                                <div class="card-block">
                                    <h6 class="m-b-20 text-light">New Orders</h6>
                                    <h2 class="text-right text-light fs-2 mb-1"><i
                                            class="fa fa-truck-ramp-box f-left"></i><span class="ps-2">
                                            <?= $count_total_new_order; ?>
                                        </span></h2>
                                    <p class="mb-0">Items</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-yellow order-card">
                                <div class="card-block">
                                    <h6 class="m-b-20 text-light">Sold Items</h6>
                                    <h2 class="text-right text-light fs-2 mb-1"><i
                                            class="fa fa-arrow-right-arrow-left f-left"></i>
                                        <span class="ps-2">
                                            <?= $count_total_sold_items; ?>
                                        </span>
                                    </h2>
                                    <p class="mb-0">Items</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 col-xl-3">
                            <div class="card bg-c-pink order-card">
                                <div class="card-block">
                                    <h6 class="m-b-20 text-light">Income</h6>
                                    <h2 class="text-right text-light fs-2 mb-1"><i class="fa fa-coins f-left"></i><span
                                            class="ps-2"><?= number_format($count_income); ?></span>
                                    </h2>
                                    <p class="mb-0">Rupiah</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    // event will be executed when the toggle-button is clicked
    document.getElementById("button-toggle").addEventListener("click", () => {

        // when the button-toggle is clicked, it will add/remove the active-sidebar class
        document.getElementById("sidebar").classList.toggle("active-sidebar");

        // when the button-toggle is clicked, it will add/remove the active-main-content class
        document.getElementById("main-content").classList.toggle("active-main-content");
    });
</script>

<!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
<script src="../js/script.js"></script>

</body>

</html>