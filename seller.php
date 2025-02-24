<?php 
    require_once './includes/db.php';
    
    $user_id = $_SESSION['user_id'];
    
    $total_order = 0;
    $query3 = "SELECT COUNT(*) AS count2, SUM(order_total) AS total_order FROM orders WHERE seller_id = '$user_id'";
    $res2 = mysqli_query($conn, $query3);
    $row3 = mysqli_fetch_assoc($res2);
    
    $count2 = $row3['count2']; 
    $total_order = $row3['total_order'];
    
    $query4 = "SELECT COUNT(*) AS count3 FROM products WHERE seller_id = '$user_id' AND product_status = 'On Sale'";
    $re2 = mysqli_query($conn, $query4);
    $row4 = mysqli_fetch_assoc($re2);
    $count3 = $row4['count3']; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <?php require_once './includes/head.php'; ?>
    <style>

    </style>
</head>
<body class="pad">
    <div class="container">
        <?php require_once './includes/sidenav.php';?>
        <div class="row">
            <div class="col-10">
                <h1 style="padding-top: 10px;">SELLER DASHBOARD</h1>
            </div>
            <div class="col-2 d-flex float-end">
                <button type="button"style=" color: green;" class="btn position-relative m-2" data-bs-toggle="offcanvas" data-bs-target="#chat" aria-controls="offcanvasRight">
                <ion-icon size="large" name="chatbubbles-outline"></ion-icon></button>
                <?php require_once './extension/notif_seller.php';?>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card card-custom shadow py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-primary text-uppercase mb-1" style="font-size: small;">
                                    TOTAL ORDERS</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: x-large;"><?php echo $count2; ?></div>
                            </div>
                            <div class="col-auto text-primary">
                                <ion-icon size="large" name="receipt-outline"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card shadow py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-success text-uppercase mb-1" style="font-size: small;">
                                    TOTAL SALES</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: x-large;"><?php echo CURRENCY . number_format($total_order, 2); ?></div>
                            </div>
                            <div class="col-auto text-success">
                                <ion-icon size="large" name="cash-outline"></ion-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 mb-4">
                <div class="card shadow py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="font-weight-bold text-warning text-uppercase mb-1" style="font-size: small;">
                                    PRODUCT ON SALE</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800" style="font-size: x-large;"><?php echo $count3; ?></div>
                            </div>
                            <div class="col-auto text-warning">
                                <ion-icon size="large" name="trending-up-outline"></ion-icon>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-8">
                <div class="card shadow mb-2" style="height: 17.5em; display:block; overflow-y:scroll;">
                    <div class="table">
                        <table class="table table-responsive">
                            <thead class="text-center">
                                <tr>
                                    <td colspan="3">PRODUCTS ON CART</td>
                                </tr>
                            </thead>
                            <thead class="table-light text-center">
                                <tr>
                                    <td>BUYER</td>
                                    <td>MINIMUM ORDER</td>
                                    <td>PRODUCT STOCK LEFT</td>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            <?php
                                $sql = "SELECT * FROM products WHERE seller_id = '$user_id' AND product_stock < min_order AND product_status = 'On Sale' 
                                    ORDER BY product_stock ASC";
                                $result = mysqli_query($conn, $sql);
                                foreach($result as $row){
                            ?>
                                <tr class="table-danger">
                                    <td><?php echo $row['product_name'] ?></td>
                                    <td><?php echo $row['min_order'] ?></td>
                                    <td><?php echo $row['product_stock'] ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card shadow">
                    <div class="table">
                        <table class="table table-responsive">
                            <thead class="text-center">
                                <tr>
                                    <td colspan="3">PRODUCTS ON CART</td>
                                </tr>
                            </thead>
                            <thead class="table-light text-center">
                                <tr>
                                    <td>BUYER</td>
                                    <td>PRODUCT</td>
                                    <td>QTY</td>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            <?php
                                // Assuming you have a database connection established earlier
                                $sql = "SELECT c.order_qty, u.fullname, p.product_name
                                        FROM cart c
                                        INNER JOIN users u ON c.user_id = u.user_id
                                        INNER JOIN products p ON c.product_id = p.product_id
                                        WHERE p.seller_id = $user_id"; 
                                $result = mysqli_query($conn, $sql);
                                foreach ($result as $row) {
                            ?>
                                <tr class="table-danger">
                                    <td><?php echo $row['fullname']; ?></td>
                                    <td><?php echo $row['product_name']; ?></td>
                                    <td><?php echo $row['order_qty']; ?></td>
                                </tr>
                            <?php
                                }
                            ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow dash-scroll"  style="height: 35.6em; display:block; overflow-y:scroll;">
                    <div class="table">
                        <table class="table table-responsive">
                            <thead class="text-center">
                                <tr>
                                    <td colspan="3">PRODUCT OUT OF STOCK</td>
                                </tr>
                            </thead>
                            <thead class="table-light text-center">
                                <tr>
                                    <td>NAME</td>
                                    <td>PRODUCT STOCK LEFT</td>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                            <?php
                                $sql = "SELECT * FROM products WHERE seller_id = '$user_id' AND product_stock < min_order AND product_status = 'On Sale' 
                                    ORDER BY product_stock ASC";
                                $result = mysqli_query($conn, $sql);
                                foreach($result as $row){
                            ?>
                                <tr class="table-danger">
                                    <td><?php echo $row['product_name'] ?></td>
                                    <td><?php echo $row['product_stock'] ?></td>
                                    <td></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>