<!-- menu nav -->
<div class="menu-nav">
    <span class="menu-header">Menu <i class="fa fa-bars"></i></span>
    <ul class="menu-list">
        <li><a href="index.php">Trang chủ</a></li>
        <li><a href="products.php">Sản phẩm</a></li>
        <?php
                    // Lấy danh sách thương hiệu từ cơ sở dữ liệu
                $sql = "SELECT DISTINCT Brand FROM Product WHERE block = 0";
                $rs = DataProvider::executeQuery($sql);

                // Hiển thị danh sách thương hiệu trong menu
                echo "<li class='dropdown side-dropdown'>";
                echo "<a class='dropdown-toggle brand' data-toggle='dropdown' aria-expanded='true'>Thương hiệu</a>";
                echo "<div class='custom-menu custom-menu-brand'>";
                echo "<ul class='list-links'>";

                // Lặp qua từng thương hiệu và tạo liên kết
                while ($row = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
                    $brand = $row['Brand'];

                    // Kiểm tra nếu tham số slcBrand trong URL trùng với thương hiệu hiện tại
                    $activeClass = (isset($_GET['slcBrand']) && $_GET['slcBrand'] == $brand) ? 'active' : '';

                    // Hiển thị liên kết cho từng thương hiệu
                    echo "<li><a href='products.php?slcBrand=$brand' class='filter-link $activeClass'>$brand</a></li>";
                }

                echo "</ul>";
                echo "</div>";
                echo "</li>";

                ?>
                <?php
                // Lấy danh sách dịch vụ từ cơ sở dữ liệu
                $sql = "SELECT ServiceID, ServiceName FROM service";
                $rs = DataProvider::executeQuery($sql);

                // Hiển thị danh sách dịch vụ trong menu
                echo "<li class='dropdown side-dropdown'>";
                echo "<a class='dropdown-toggle brand' data-toggle='dropdown' aria-expanded='true'>Dịch vụ</a>";
                echo "<div class='custom-menu custom-menu-brand'>";
                echo "<ul class='list-links'>";

                // Lặp qua từng dịch vụ và tạo liên kết
                while ($row = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
                    $serviceID = $row['ServiceID'];
                    $serviceName = $row['ServiceName'];

                    // Kiểm tra nếu tham số slcService trong URL trùng với dịch vụ hiện tại
                    $activeClass = (isset($_GET['slcService']) && $_GET['slcService'] == $serviceID) ? 'active' : '';

                    // Hiển thị liên kết cho từng dịch vụ
                    echo "<li><a href='services.php?slcService=$serviceID' class='filter-link $activeClass'>$serviceName</a></li>";
                }

                echo "</ul>";
                echo "</div>";
                echo "</li>";

                
         ?>  
                 <li><a href="news.php">Tin Tức</a></li>
    
    </ul>
</div>
<!-- menu nav -->