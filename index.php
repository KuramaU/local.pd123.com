<?php include $_SERVER["DOCUMENT_ROOT"] . "/head.php" ?>
    <main>
        <div class="container">
            <h1 class="text-center mt-3">Список користувачів</h1>
            <!--
        <?php
            echo "<h2>Текст через echo</h2>"; д
            ?>
        -->
            <a class="btn btn-success mb-3 fs-5" href="/register.php">
                Створити Користувача
                <i class="fa fa-user-plus fs-3" aria-hidden="true"></i>
            </a>
            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Ім'я</th>
                    <th scope="col">Пошта</th>
                    <th scope="col">Телефон</th>
                    <th></th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
                include $_SERVER["DOCUMENT_ROOT"] . "/connection_database.php";
                if (isset($dbh)) {

                    $stm = $dbh->query('SELECT id, name, surname, email, phone FROM users');


                    $rows = $stm->fetchAll();


                    foreach ($rows as $row) {
                        echo "<tr>
                                    <th>$row[0]</th>
                                    <td>$row[1]</td>
                                    <td>$row[2]</td>
                                    <td>$row[3]</td>
                                    <td>$row[4]</td>
                                    <td>
                                        <a href='/editUser.php?id=$row[0]' class='text-warning' data-edit='$row[0]'>
                                            <i class='fa fa-pencil fs-4' aria-hidden=true></i>
                                        </a>
                                    </td>
                                    <td>
                                        <a href='/delete.php?id=$row[0]' class='text-danger' data-delete='$row[0]'>
                                            <i class='fa fa-times fs-4'></i>
                                        </a>
                                    </td>
                                </tr>";
                    }
                }
                ?>
                </tbody>
            </table>
        </div>
    </main>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/modals/deleteModal.php"; ?>

    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/axios.min.js"></script>

    <script>
        window.addEventListener("load", (event) => {
            let hrefDelete = "";
            let imageDeletePath = "";
            const rootDirectory = window.location.protocol + '//' + window.location.host + '/';
            const delBtns = document.querySelectorAll("[data-delete]");
            const images = document.querySelectorAll("[img-data]");
            const deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
            for (i = 0; i < delBtns.length; i++) {
                const imgSrc = images[i].getAttribute("src");
                delBtns[i].onclick =  function(e) {
                    e.preventDefault();
                    console.log("Ви хочете видалити елемент");
                    hrefDelete = this.href;

                    if (imgSrc !== "assets/userImages/") {
                        imageDeletePath = rootDirectory + imgSrc;
                        console.log("Image Delete Src", imageDeletePath);
                    }

                    deleteModal.show();
                }
            }
            document.getElementById("modalDeleteYes").onclick=function() {
                axios.post(hrefDelete)
                    .then((resp) => {
                        deleteModal.hide();



                        location.reload();
                    })
            }
        });
    </script>
<?php include $_SERVER["DOCUMENT_ROOT"] . "/footer.php" ?>