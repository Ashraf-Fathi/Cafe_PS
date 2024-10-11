<?php
ob_start();   
session_start();
$pageTitle = 'Stock';

if (isset($_SESSION['username'])) {
    include "init.php";

    $do = isset($_GET['do']) ? $_GET['do'] : "Manage";

    if ($do == "Manage") {
        $stmt2 = $con->prepare("SELECT * FROM stock");
        $stmt2->execute();
        $stock = $stmt2->fetchAll();
        echo "<h1 class='text-center'>Stock Page</h1>";
        ?>
        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Control</th>
                        </tr>
                    </thead>
                    <tfoot class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Control</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <?php
                        foreach ($stock as $item) {
                            echo "<tr>";
                                echo "<td>" . $item['S_ID'] . "</td>";
                                echo "<td>" . $item['s_name'] . "</td>";
                                echo "<td>" . $item['s_price'] . "</td>";
                                echo "<td>" . $item['s_quantity'] . "<a href='stock.php?do=Edit&doo=Add-quantity&id=" . $item['S_ID'] . "' class='btn btn-success'><i class='fa fa-plus'></i></a>" . "</td>";
                                echo "<td>";
                                    echo "<a href='stock.php?do=Edit&doo=Edit&id=" . $item['S_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>";
                                    echo " ";
                                    echo "<a href='stock.php?do=Delete&id=" . $item['S_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-trash'></i>Delete</a>";
                                echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <a href='stock.php?do=Add' class="btn btn-primary"><i class="fa fa-plus"></i> New Item</a>
        </div>
        <?php
    } elseif ($do == "Add") {
        ?>
        <h1 class='text-center'>Add New Item</h1>  
        <br/> 
        <div class="container">
            <form class="form-horizontal" action="?do=Insert" method="POST">
                <div class="form-group">
                    <label class="col-sm-2 control-label">Name</label>
                    <div class="col-sm-4">
                        <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Name of the device" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Price</label>
                    <div class="col-sm-4">
                        <input type="text" name="price" class="form-control" placeholder="Price of the device" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">Quantity</label>
                    <div class="col-sm-4">
                        <input type="text" name="quantity" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-4">
                        <input type="submit" value="Add Item" class="btn btn-primary" />
                    </div>
                </div>
            </form>
        </div>
        <?php
    } elseif ($do == 'Insert') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $quantity = $_POST['quantity'];

            $check = checkItem("s_name", "stock", $name);

            if ($check == 1) {
                $theMsg = "<div class='alert alert-danger'>Sorry, this item already exists</div>";
                redirectHome($theMsg, 'back');
            } else {
                $stmt = $con->prepare("INSERT INTO stock (s_name, s_price, s_quantity) VALUES (:iname, :iprice, :iquantity)");
                $stmt->execute([
                    'iname' => $name,
                    'iprice' => $price,
                    'iquantity' => $quantity
                ]);
                $icount = $stmt->rowCount();
                
                echo "<div class='container'>";
                $theMsg = "<div class='alert alert-success'>" . $icount . " Record Inserted</div>";
                //redirectHome($theMsg, 'back', 0.1);
                header('Location: stock.php');
                echo "</div>";
            }
        } else {
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-danger'>Sorry, you cannot browse this page directly</div>";
            //redirectHome($theMsg, 'back');
            header('Location: stock.php');
            echo "</div>";
        }
    } elseif ($do == 'Edit') {
        $doo = isset($_GET['doo']) ? $_GET['doo'] : "Edit";

        if ($doo == "Edit") {
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

            $stmt = $con->prepare("SELECT * FROM stock WHERE S_ID = ? LIMIT 1");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) {
                ?>
                <h1 class='text-center'>Edit Item</h1>
                <br/>
                <div class="container">
                    <form class="form-horizontal" action="?do=Update" method="POST">
                        <input type="hidden" name="id" value="<?php echo $id ?>" />
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-4">
                                <input type="text" name="name" class="form-control" autocomplete="off" placeholder="Name of the device" value="<?php echo $row['s_name'] ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Price</label>
                            <div class="col-sm-4">
                                <input type="text" name="price" class="form-control" placeholder="Price of the device" value="<?php echo $row['s_price'] ?>" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-4">
                                <input type="submit" value="Edit Item" class="btn btn-primary" />
                            </div>
                        </div>
                    </form>
                </div>
                <?php
            } else {
                echo "<div class='container'>";
                $theMsg = "<div class='alert alert-danger'>There is no such ID</div>";
                //redirectHome($theMsg, 'back', 3);
                header('Location: stock.php');
                echo "</div>";
            }
        } elseif ($doo == "Add-quantity") {
            $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

            $stmt = $con->prepare("SELECT * FROM stock WHERE S_ID = ? LIMIT 1");
            $stmt->execute([$id]);
            $row = $stmt->fetch();
            $count = $stmt->rowCount();

            if ($count > 0) {
                ?>
                <form class="form-horizontal" action="?do=Edit&doo=Add-action" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id ?>" />
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Add Quantity</label>
                        <div class="col-sm-4">
                            <input type="number" step="1" name="quantity" class="form-control" autocomplete="off" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-4">
                            <input type="submit" value="Add Quantity" class="btn btn-primary" />
                        </div>
                    </div>
                </form>
                <?php
            } else {
                echo "<div class='container'>";
                $theMsg = "<div class='alert alert-danger'>There is no such ID</div>";
                //redirectHome($theMsg, 'back', 3);
                header('Location: stock.php');
                echo "</div>";
            }
        } elseif ($doo == "Add-action") {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $id = $_POST['id'];
                $quantity = $_POST['quantity'];

                $stmt = $con->prepare("UPDATE stock SET s_quantity = s_quantity + ? WHERE S_ID = ?");
                $stmt->execute([$quantity, $id]);
                $icount = $stmt->rowCount();

                echo "<h1 class='text-center'>Update Item</h1>";
                echo "<div class='container'>";
                $theMsg = "<div class='alert alert-success'>" . $icount . " new quantity added</div>";
                //redirectHome($theMsg, 'back', 2);
                header('Location: stock.php');
                echo "</div>";
            } else {
                echo "<div class='container'>";
                $theMsg = "<div class='alert alert-danger'>Sorry, you cannot browse this page directly</div>";
                //redirectHome($theMsg, 'back');
                header('Location: stock.php');
                echo "</div>";
            }
        }
    } elseif ($do == 'Update') {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $name = $_POST['name'];
            $price = $_POST['price'];

            $stmt = $con->prepare("UPDATE stock SET s_name = ?, s_price = ? WHERE S_ID = ?");
            $stmt->execute([$name, $price, $id]);
            $icount = $stmt->rowCount();

            echo "<h1 class='text-center'>Update Item</h1>";
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-success'>" . $icount . " Item Updated</div>";
            redirectHome($theMsg, 'back', 2);
            echo "</div>";
        } else {
            echo "<div class='container'>";
            $theMsg = "<div class='alert alert-danger'>Sorry, you cannot browse this page directly</div>";
            redirectHome($theMsg, 'back');
            echo "</div>";
        }
    } elseif ($do == 'Delete') {
        $id = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

        $check = checkItem("S_ID", "stock", $id);

        if ($check > 0) {
            $stmt = $con->prepare("DELETE FROM stock WHERE S_ID = :zid");
            $stmt->bindParam(":zid", $id);
            $stmt->execute();

            $theMsg = "<div class='alert alert-success'>" . $stmt->rowCount() . " Record Deleted</div>";
            //redirectHome($theMsg, 'back');
            header('Location: stock.php');
        } else {
            $theMsg = "<div class='alert alert-danger'>This ID is not exist</div>";
            //redirectHome($theMsg);
            header('Location: stock.php');
        }
    }

    include $tpl . 'footer.php';
} else {
    header('Location: home.php');
    exit();
}

ob_end_flush();
?>
