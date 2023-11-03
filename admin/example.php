<?php
include 'fungsi-example.php';

$data_user = mysqli_query($konek_db, 'SELECT * FROM tb_user');

if (isset($_POST["btn-create"])) {
    if (tambahUser($_POST)) {
        header("Location: example.php");
    }
}

include 'header.php';
?>

<section class="p-4" id="main-content">
    <div class="container">
        <form action="" method="post">
            <div class="row">
                <label for="nama_user" class="form-label">Nama</label>
                <div class="col-md-3">
                    <input id="nama_user" type="text" class="form-control" name="nama_user">
                </div>
            </div>
            <div class="row">
                <label for="username" class="form-label">Username</label>
                <div class="col-md-3">
                    <input id="username" type="text" class="form-control" name="username">
                </div>
            </div>
            <div class="row">
                <label for="password" class="form-label">Password</label>
                <div class="col-md-3">
                    <input id="password" type="password" class="form-control" name="password">
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mt-2">
                    <button type="submit" class="btn btn-success" name="btn-create">Submit</button>
                </div>
            </div>
        </form>
    </div>

    <!-- tabel user -->
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($data_user)) {
                    ?>
                    <tr>
                        <th scope="row">1</th>
                        <td>
                            <?php echo $row["nama_user"]; ?>
                        </td>
                        <td>
                            <?php echo $row["username"]; ?>
                        </td>
                        <td>
                            <?php echo $row["password"]; ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
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