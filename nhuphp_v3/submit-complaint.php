<?php
require_once('DataProvider.php');  // Đảm bảo bạn đã include DataProvider để thực thi các truy vấn

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ form
    $invoiceID = $_POST['invoiceID'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (isset($invoiceID) && isset($title) && isset($description)) {
        // Xử lý truy vấn để thêm khiếu nại vào cơ sở dữ liệu
        $sql = "INSERT INTO complaint (InvoiceID, Title, Description, DateSubmitted, AdminReply) 
                VALUES ('$invoiceID', '$title', '$description', NOW(), 'Kính gửi Quý khách, Cảm ơn quý khách đã liên hệ với chúng tôi. Chúng tôi rất tiếc khi nghe về sự bất tiện mà quý khách gặp phải. Chúng tôi đang tiến hành kiểm tra vấn đề của quý khách và sẽ sớm phản hồi lại với giải pháp thích hợp. Chúng tôi cam kết sẽ nỗ lực hết mình để khắc phục sự cố và mang lại trải nghiệm tốt nhất cho quý khách. Nếu quý khách có thêm bất kỳ câu hỏi hay yêu cầu nào, xin đừng ngần ngại liên hệ lại với chúng tôi. Xin chân thành cảm ơn quý khách đã thông cảm và kiên nhẫn. Trân trọng.')";
    
        // Thực thi truy vấn sử dụng DataProvider::executeQuery
        $result = DataProvider::executeQuery($sql);
    
        if ($result) {
            echo "<script>
                alert('Khiếu nại đã được gửi thành công.');
                window.location.href = 'check-invoice-user.php'; // Điều hướng về trang index.php
              </script>";
        } else {
            // Kiểm tra lỗi nếu truy vấn không thực thi thành công
            echo "Có lỗi xảy ra khi gửi khiếu nại: " . $error;
        }
    } 
    
}
?>
