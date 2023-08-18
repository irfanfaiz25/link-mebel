<?php
include '../fungsi/fungsi.php';
include 'fungsi-produk.php';
include 'header.php';
?>
<section class="p-4" id="main-content">
	<div class="row">
		<div class="col-md-1">
			<button class="btn btn-outline-secondary mc" id="button-toggle">
				<i class="bi bi-list"></i>
			</button>
		</div>
		<div class="col-md-9 float-start">
			<h1><b>DATA PRODUK</b></h1>
			<p style="margin-bottom: -7px; margin-top: -5px; color: #7B8FA1 !important;">Link-Meubel</p>
		</div>
		<div class="col-md-2">
			<button class="btn btn-outline-secondary mc float-end" id="button-toggle">
				<i class="fa fa-right-from-bracket"></i>
			</button>
		</div>
	</div>

	<div class="card mt-5">
		<div class="card-body">

			<div class="row utama">
				<div class="col-md-12 justify-content-end">
					<button type="button" class="btn btn-secondary float-end" data-toggle="modal"
						data-target="#inputModal"><i class="fa fa-plus"></i></button>
				</div>
			</div>

			<!-- modal input data -->
			<div id="inputModal" class="modal fade" tabindex="-1">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="text-secondary">TAMBAH PRODUK</h4>
							<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
						</div>
						<div class="modal-body">
							<form action="" method="post" enctype="multipart/form-data">
								<label for="nama">Nama Produk</label>
								<input type="text" class="form-control" name="nama" id="nama">

								<label for="harga" style="padding-top: 8px;">Harga Sewa</label>
								<input type="text" class="form-control" name="harga" id="harga">

								<label for="stok" style="padding-top: 8px;">Stok</label>
								<input type="text" class="form-control" name="stok" id="stok">

								<label for="ket" style="padding-top: 8px;">Keterangan / Ukuran</label>
								<input type="text" class="form-control" name="ket" id="ket">

								<label for="kategori" style="padding-top: 8px;">Kategori</label>
								<input type="text" class="form-control" name="kategori" id="kategori">

								<label for="foto" style="padding-top: 8px;">Foto</label>
								<input type="file" class="form-control" name="foto" id="foto">
						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary" name="add"><i class="fa fa-plus"></i>
								TAMBAH</button>
							</form>
						</div>
					</div>
				</div>
			</div>






			<!-- tabel data barang -->
			<div class="row dataku">

				<div class="col-md-12 table-responsive-md">
					<table id="tabel-barang" class="table table-bordered table-striped">
						<thead class="table-primary">
							<tr>
								<th class="ctr">NO</th>
								<th class="ctr">ID PRODUK</th>
								<th class="ctr">NAMA PRODUK</th>
								<th class="ctr">HARGA</th>
								<th class="ctr">STOK</th>
								<th class="ctr">KETERANGAN</th>
								<th class="ctr">KATEGORI</th>
								<th class="ctr">FOTO</th>
								<th class="ctr">AKSI</th>
							</tr>
						</thead>

						<?php $i = 1; ?>
						<?php foreach ($barang as $row): ?>
							<!-- <tbody> -->
							<tr class="text-center">
								<td class="align-middle text-center">
									<?= $i; ?>
								</td>
								<td class="align-middle">
									<?= $row["id_produk"]; ?>
								</td>
								<td class="align-middle">
									<?= $row["nama"]; ?>
								</td>
								<td class="align-middle">
									<?= $row["harga"]; ?>
								</td>
								<td class="align-middle">
									<?= $row["stok"]; ?>
								</td>
								<td class="align-middle">
									<?= $row["keterangan"]; ?>
								</td>
								<td class="align-middle">
									<?= $row["kategori"]; ?>
								</td>
								<td class="align-middle"><img src="../image/<?= $row["foto"]; ?>" height="53" width="50"
										alt=""></td>
								<td class="text-center align-middle">

									<button style="margin-right: 5px;" type="submit" class="btn btn-warning btn-sm mt-1"
										name="ubah" data-toggle="modal" data-target="#editModal<?= $row["id_produk"]; ?>"
										href=""><i class="fa fa-edit"></i></button>
									<a class="btn btn-danger btn-sm mt-1" name="hapus"
										href="hapus.php?id=<?= $row["id_produk"]; ?>"><i class="fa fa-trash"></i></a>

								</td>
							</tr>
							<!-- modal edit data -->
							<div id="editModal<?= $row["id_produk"]; ?>" class="modal fade" tabindex="-1">
								<div class="modal-dialog">
									<div class="modal-content">
										<div class="modal-header">
											<h4 class="text-secondary">UBAH DATA</h4>
											<button type="button" class="btn-close" data-dismiss="modal"
												aria-label="Close"></button>
										</div>
										<div class="modal-body">
											<form action="" method="post" enctype="multipart/form-data">
												<input type="hidden" name="id" value="<?= $row["id_produk"]; ?>">
												<input type="hidden" name="fotoLama" value="<?= $row["foto"]; ?>">

												<label for="nama">Nama Barang</label>
												<input type="text" class="form-control" name="nama" id="nama"
													value="<?= $row["nama"]; ?>">

												<label for="harga" style="padding-top: 8px;">Harga Sewa</label>
												<input type="text" class="form-control" name="harga" id="harga"
													value="<?= $row["harga"]; ?>">

												<label for="stok" style="padding-top: 8px;">Stok</label>
												<input type="text" class="form-control" name="stok" id="stok"
													value="<?= $row["stok"]; ?>">

												<label for="ket" style="padding-top: 8px;">Keterangan /
													Ukuran</label>
												<input type="text" class="form-control" name="ket" id="ket"
													value="<?= $row["keterangan"]; ?>">

												<label for="kategori" style="padding-top: 8px;">Kategori</label>
												<input type="text" class="form-control" name="kategori" id="kategori"
													value="<?= $row["kategori"]; ?>">

												<label for="foto" style="padding-top: 8px;">Foto</label>
												<input type="file" class="form-control" name="foto" id="foto"
													value="<?= $row["foto"]; ?>">
										</div>
										<div class="modal-footer">
											<button type="submit" class="btn btn-primary" name="edit"><i
													class="fa fa-edit"></i> UBAH</button>
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