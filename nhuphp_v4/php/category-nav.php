<span class="category-header">Danh mục <i class="fa fa-list"></i></span>
<ul class="category-list">
    <?php
    // Kết nối với cơ sở dữ liệu
    require_once('DataProvider.php');

    // Truy vấn tất cả các loại sản phẩm duy nhất
    $sql = "SELECT DISTINCT ProductTypeName FROM ProductType ORDER BY ProductTypeName";
    $rs = DataProvider::executeQuery($sql);

    if ($rs && mysqli_num_rows($rs) > 0) {
        while ($row = mysqli_fetch_array($rs, MYSQLI_ASSOC)) {
            $typeName = htmlspecialchars($row['ProductTypeName']); // chống ký tự lạ
            echo "<li><a href='products.php?slcType={$typeName}'>$typeName</a></li>";
        }
    } else {
        echo "<li>Không có loại sản phẩm nào</li>";
    }
    ?>
</ul>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.category-header');
    const list = document.querySelector('.category-list');
    list.style.display = 'none';
    header.addEventListener('click', function() {
        list.style.display = (list.style.display === 'block') ? 'none' : 'block';
    });

    document.querySelector('body').addEventListener('scroll', function () {
    if (list.style.display === 'block') {
        list.style.display = 'none';
    }
});
});
</script>