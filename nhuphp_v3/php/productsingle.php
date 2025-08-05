<?php
    echo "<div class='product product-single'>";
    echo "<div class='product-thumb'>";
    echo "<a href='product-page.php?productid=".$row['ProductID']."'><button type='button' class='main-btn quick-view'><i class='fa fa-search-plus'></i> Chi tiết</button></a>";
    echo "<img src='./img/".$row["imgsrc"]."' width='258px' height='344px' alt='".$row["ProductName"]."'>";
    echo "</div>";
    echo "<div class='product-body'>";
    echo "<h4 class='product-price'><script>document.write(PriceDot(".$row["UnitPrice"]."))</script></h4>";
    echo "<h2 class='product-name'><a href='product-page.php?productid=".$row['ProductID']."'>" .$row["ProductName"]. "</a></h2>";
    echo "<div class='product-btns'>";
    echo "<input name='txtProductID' type='hidden' value='".$row['ProductID']."' >";
    echo "<input name='txtQuantity' type='hidden' value=1 >";
    echo "<input name='txtURL' type='hidden' value=".$_SERVER['REQUEST_URI']." >";						
    if ($row['Quantity'] > 0) {
        echo "<input name='btnAddToCart' type='submit' class='primary-btn add-to-cart' value='Thêm vào giỏ hàng' >";
    } else {
        echo "<span class='text-danger' style='font-weight:bold;'>Hết hàng</span>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
?>