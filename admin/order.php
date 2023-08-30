<?php
include '../fungsi/fungsi.php';
include 'fungsi-order.php';
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
            <h1><b>DATA ORDER</b></h1>
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

                <div class="col-md-12 table-responsive-md">
                    <table id="tabel-order" class="table table-bordered table-striped">
                        <thead class="table-warning">
                            <tr class="text-center">
                                <th class="text-center">NO</th>
                                <th class="text-center">NO TRANSAKSI</th>
                                <th class="text-center">JUMLAH PRODUK</th>
                                <th class="text-center">JUMLAH ITEM</th>
                                <th class="text-center">TOTAL</th>
                                <th class="text-center">TANGGAL ORDER</th>
                                <th class="text-center">STATUS</th>
                                <th class="text-center">DETAIL</th>
                                <th class="text-center">BUKTI</th>
                                <th class="text-center">KONFIRMASI</th>
                            </tr>
                        </thead>

                        <?php $i = 1; ?>
                        <?php foreach ($order as $row): ?>
                            <!-- <tbody> -->
                            <tr class="text-center">
                                <td class="align-middle text-center">
                                    <?= $i; ?>
                                </td>
                                <td class="align-middle">
                                    <?= $row["no_trans"]; ?>
                                </td>
                                <td class="align-middle">
                                    <?= $row["jumlah_produk"]; ?>
                                </td>
                                <td class="align-middle">
                                    <?= $row["jumlah_order"]; ?>
                                </td>
                                <td class="align-middle">
                                    IDR
                                    <?= number_format($row["total"]); ?>
                                </td>
                                <td class="align-middle">
                                    <?= date("d-m-Y | H:i", strtotime($row["tgl_transaksi"])); ?>
                                </td>
                                <td class="align-middle text-center">
                                    <?= statusBadges($row["proses_status"]); ?>
                                </td>
                                <td class="align-middle text-center">
                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                        data-target="#detailOrder<?= $row["no_trans"]; ?>"><i
                                            class="fa fa-circle-info"></i></button>
                                </td>
                                <td class="align-middle">
                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                        data-target="#buktiBayar<?= $row["no_trans"]; ?>" <?php
                                          if ($row["bukti_bayar"] == "") {
                                              echo 'disabled';
                                          }
                                          ?>><i class="fa fa-receipt"></i></button>
                                </td>
                                <td class="align-middle text-center">
                                    <form action="" method="post">
                                        <input type="hidden" name="no_trans" value="<?= $row["no_trans"]; ?>">
                                        <button type="submit" class="btn btn-success btn-sm mt-1" name="btn-acc" <?php
                                        if ($row["proses_status"] == "payment rejected" || $row["bukti_bayar"] == "") {
                                            echo 'disabled';
                                        }
                                        ?>><i class="fa fa-clipboard-check"></i><strong>
                                                accept</strong></button>
                                        <button type="button" class="btn btn-danger btn-sm mt-1" data-toggle="modal"
                                            data-target="#ketReject<?= $row["no_trans"]; ?>"><i
                                                class="fa fa-circle-xmark"></i><strong> reject</strong></button>
                                    </form>
                                </td>
                            </tr>

                            <!-- modal detail orderan -->
                            <div id="detailOrder<?= $row["no_trans"]; ?>" class="modal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title text-dark">Detail Order</h6>
                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="card custom-card-data">
                                                    <div class="custom-card-content">
                                                        <div class="row field-data">
                                                            <div class="col-md-6 wait-field">
                                                                <h5 style="font-size: 26px;">
                                                                    Data Pengiriman
                                                                </h5>
                                                                <h5>
                                                                    Nama Penerima :
                                                                    <?= $row["nama_penerima"]; ?>
                                                                </h5>
                                                                <h5>
                                                                    No HP Penerima :
                                                                    <?= $row["no_hp"]; ?>
                                                                </h5>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <h5 class="wait-harga-modal col-alamat"
                                                                    style="font-size: 26px;">
                                                                    Alamat Penerima :
                                                                </h5>
                                                                <h5 class="field-modal col-alamat">
                                                                    <?= $row["alamat"]; ?>
                                                                </h5>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                                $no_trans = $row["no_trans"];
                                                $detail = query("SELECT * FROM transaksi_item WHERE no_trans='$no_trans'");
                                                foreach ($detail as $data) {
                                                    ?>
                                                    <div class="card custom-card">
                                                        <div class="custom-card-content">
                                                            <div class="row">
                                                                <div class="col-md-2">
                                                                    <img src="../image/<?= $data["foto"]; ?>" width="100"
                                                                        class="wait-image" alt="">
                                                                </div>
                                                                <div class="col-md-5 wait-field">
                                                                    <h5>
                                                                        <?= $data["no_trans"] ?>
                                                                    </h5>
                                                                    <h5 class="card-no">
                                                                        <?= $data["nama"]; ?>
                                                                    </h5>
                                                                    <h5>
                                                                        <?= $data["ket"] ?>
                                                                    </h5>
                                                                </div>

                                                                <div class="col-md-5 detail-card">
                                                                    <h5 class="wait-harga">
                                                                        IDR
                                                                        <?= number_format($data["harga"]); ?>
                                                                    </h5>
                                                                    <h5 class="field-modal">Jumlah</h5>
                                                                    <h5 class="field-modal">
                                                                        <?= $data["jumlah"]; ?> Item
                                                                    </h5>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                                ?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal bukti bayar -->
                            <div id="buktiBayar<?= $row["no_trans"]; ?>" class="modal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title text-dark">Bukti Pembayaran</h6>
                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body bukti-modal text-center">
                                            <img src="../image/bukti-pembayaran/<?= $row["bukti_bayar"]; ?>" width="500"
                                                alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- modal keterangan order reject -->
                            <div id="ketReject<?= $row["no_trans"]; ?>" class="modal" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title text-dark">Reject Order</h6>
                                            <button type="button" class="btn-close" data-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <form action="" method="post">
                                                        <input type="hidden" name="no_trans"
                                                            value="<?= $row["no_trans"]; ?>">
                                                        <label for="ket_reject">
                                                            <h5 class="text-dark">Keterangan Reject</h5>
                                                        </label>
                                                        <textarea name="ket_reject" id="ket_reject" class="form-control"
                                                            placeholder="ex: Rekening tujuan untuk pembayaran anda salah, silahkan cek kembali"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="btn-reject"
                                                class="btn btn-success btn-sm"><strong>Send </strong><i
                                                    class="fa fa-paper-plane"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php $i++; ?>
                        <?php endforeach; ?>
                        <!-- </tbody> -->
                    </table>
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

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
    integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
    crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
    crossorigin="anonymous"></script>
<script src="../js/script.js"></script>

</body>

</html>