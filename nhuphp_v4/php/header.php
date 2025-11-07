<!-- HEADER -->
<header>
    <!-- kiểm tra trangh thái đang nhập -->
    <?php
        include('checkLogin.php');
    ?>
    <!-- header -->
    <div id="header">
        <div class="container-menu">
            <div class="pull-left">
                <!-- Logo -->
                <div class="header-logo">
                    <a class="logo" href="index.php">
                        <img src="./images/logo.png" alt="">
                    </a>
                </div>
                <!-- /Logo -->

                <!-- Search -->
                <div class="header-search">
                    <form action="products.php" method="GET" onsubmit="return true" name="Search">
                        <input class="input search-input" type="text" placeholder="Search ..." name="txtSearch"
                            <?php
                                if (isset($_GET['txtSearch']))
                                    echo "value=\"".$_GET['txtSearch']."\"";
                            ?>
                        >
                        <button class="search-btn" type="submit"><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <!-- /Search -->

                <div class="hotline-logo header-logo">
                    <a class="logo" href="#">
                        <img src="./images/hotline.png" alt="">
                    </a>
                </div>
                
            </div>
            <div class="pull-right">
                <ul class="header-btns">
                    
                    
                     
                    
                    <!-- Cart -->
                    <?php
                        $Count=0;
                        if(isset($_SESSION['Cart']))
                        foreach($_SESSION['Cart'] as $id=>$SL)
                        if(isset($id)) $Count++;
                    ?>
                    <li class="header-cart dropdown default-dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                            <div class="header-btns-icon">
                                <i class="fa fa-shopping-cart"></i>
                                <?php echo "<span class='qty'>$Count</span>"; ?>
                            </div>
                            <strong class="text-uppercase"></strong>
                            <br>
                            <span></span>
                        </a>
                        <div class='custom-menu'>
                            <div id='shopping-cart'>
                                <div class='shopping-cart-list'>
                                <?php
                                    require_once('DataProvider.php');
                                    if(isset($_SESSION['Cart']))
                                    {
                                        $Price=0;
                                        foreach($_SESSION['Cart'] as $id=>$SL)
                                        if(isset($id))
                                        {
                                            $sql="SELECT * FROM Product WHERE ProductID=$id";
                                            $rs=DataProvider::executeQuery($sql);
                                            $row=mysqli_fetch_array($rs,MYSQLI_ASSOC);
                                            echo "            <form name='products' id='products' action='php/cart.php' method='POST'>";
                                            echo "              <div class='product product-widget'>";
                                            echo "                  <div class='product-thumb'>";
                                            echo "                      <img src='img/".$row['imgsrc']."' alt=''>";
                                            echo "                  </div>";
                                            echo "                  <div class='product-body'>";
                                            echo "                      <h3 class='product-price'><script>document.write(PriceDot(".$row["UnitPrice"]."))</script><span class='qty'>x$SL</span></h3>";
                                            echo "                      <h2 class='product-name'><a href='#'>".$row['ProductName']."</a></h2>";
                                            echo "                  </div>";
                                            echo "                  <button type='submit' name='btnDel' class='cancel-btn'><i class='fa fa-trash'></i></button>";
                                            echo "              </div>";
                                            echo "              <input name='txtProductID' type='hidden' value='".$row['ProductID']."' >";
                                            echo "              <input name='txtURL' type='hidden' value=".$_SERVER['REQUEST_URI']." >";
                                            echo "            </form>";
                                            $Price+=($row["UnitPrice"]*$SL);
                                        }
                                        echo "<br>Tổng cộng: <script>document.write(PriceDot($Price))</script>";
                                    }
                                    if($Count==0)
                                        echo "Bạn chưa mua hàng. Hãy thử mua vài món nhé";
                                ?>
                                </div>
                                <!-- mô tả action xem/xóa giỏ hàng -->
                                <div class='shopping-cart-btns'>
                                    <form name='delCart' id='delCart' action='php/cart.php' method='POST'>
                                        <?php echo "<input name='txtURL' type='hidden' value=".$_SERVER['REQUEST_URI']." >"; ?>
                                        <button type='submit' style='font-size:12px; padding:10px 0 10px 0; width:45%' name='btnDelAll' class='main-btn'>Xóa giỏ hàng</button>
                                        <a href='view-cart.php'><button type='button' style='font-size:12px; width:45%; padding:10px 0 10px 0;' class='primary-btn'>Xem giỏ hàng <i class='fa fa-arrow-circle-right'></i></button></a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <!-- /Cart -->
                     <!-- Account -->
                    <?php
                        include('account.php');
                    ?>
                    <!-- /Account -->
                    <!-- Location Store -->
                    <li class="header-location">
                        <a href="#" class="header-btns-icon">
                            <i class="fa fa-map-marker"></i> <!-- Thêm biểu tượng location ở đây -->
                        </a>
                    </li>
                    <!-- /Location Store -->
                    <!-- Mobile nav toggle-->
                    <li class="nav-toggle">
                        <button class="nav-toggle-btn main-btn icon-btn"><i class="fa fa-bars"></i></button>
                    </li>
                    <!-- / Mobile nav toggle -->
                </ul>
            </div>
        </div>
        <!-- header -->
    </div>
    <!-- container -->
</header>
<!-- /HEADER -->