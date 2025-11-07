<?php
require_once('../DataProvider.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form gửi lên
    $complaintID = intval($_POST['ComplaintID']);
    $adminReply = $_POST['AdminReply'];

    // Mặc định status là 0 (chưa xử lý)
    $status = 0;

    // Nội dung mặc định (nếu admin không thay đổi thì vẫn coi là chưa xử lý)
    $defaultReply = "Kính gửi Quý khách, Cảm ơn quý khách đã liên hệ với chúng tôi. Chúng tôi rất tiếc khi nghe về sự bất tiện mà quý khách gặp phải. Chúng tôi đang tiến hành kiểm tra vấn đề của quý khách và sẽ sớm phản hồi lại với giải pháp thích hợp. Chúng tôi cam kết sẽ nỗ lực hết mình để khắc phục sự cố và mang lại trải nghiệm tốt nhất cho quý khách. Nếu quý khách có thêm bất kỳ câu hỏi hay yêu cầu nào, xin đừng ngần ngại liên hệ lại với chúng tôi. Xin chân thành cảm ơn quý khách đã thông cảm và kiên nhẫn. Trân trọng.";

    // Nếu admin thay đổi phản hồi mặc định → coi là đã xử lý
    if (trim($adminReply) !== trim($defaultReply)) {
        $status = 1;
    }

    // Escape input thủ công nếu cần
    $adminReplyEscaped = str_replace("'", "\'", $adminReply);

    // Cập nhật vào CSDL
    $sql = "UPDATE complaint 
            SET AdminReply = '$adminReplyEscaped', Status = $status 
            WHERE ComplaintID = $complaintID";

    if (DataProvider::executeQuery($sql)) {
        echo "<script>alert('Cập nhật khiếu nại thành công'); window.location.href = 'admin-invoice.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi cập nhật khiếu nại'); window.history.back();</script>";
    }
}
?>
