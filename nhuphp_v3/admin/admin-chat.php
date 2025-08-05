<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Chat</title>
    <style>
        /* Chatbox styles */
/* Chatbox styles */
#chatbox-wrapper {
    position: fixed;
    bottom: 20px;
    right: 20px;
    width: 60px; /* Kích thước nhỏ cho icon */
    height: 60px; /* Kích thước nhỏ cho icon */
    z-index: 999;
    cursor: pointer;
}

/* Icon nhỏ chat */
#toggle-btn {
    position: relative;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s ease;
    background-color: white;
}

/* Thêm hiệu ứng nhấp nháy cho icon khi có tin nhắn mới */
#toggle-btn.blink {
    animation: blink 1s infinite;
}

@keyframes blink {
    50% {
        background-color: #ff6347; /* Màu nhấp nháy */
    }
}

/* Style cho icon */
#chat-icon {
    width: 30px;
    height: 30px;
}

/* Chatbox khi mở */
#chatbox {
    display: none; /* Bắt đầu ẩn */
    position: fixed;
    bottom: 80px;
    right: 20px;
    width: 300px;
    height: 400px;
    border: 1px solid #ccc;
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    flex-direction: column;
}

#chatbox-body {
    flex-grow: 1;
    padding: 15px;
    overflow-y: auto;
    background-color: #f9f9f9;
    height: calc(100% - 50px);
    border-bottom: 1px solid #ccc;
}

#chatbox-footer {
    display: flex;
    padding: 10px;
    border-top: 1px solid #ccc;
    background-color: #fff;
}

#chat-input {
    flex-grow: 1;
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 14px;
    margin-right: 10px;
}

#send-btn {
    padding: 10px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
}

    </style>
</head>
<body>
<div id="chatbox-wrapper">
    <div id="toggle-btn">
        <img src="../images/logochat.png" alt="Chat Icon" id="chat-icon"> <!-- Icon nhỏ, thay 'chat-icon.png' bằng đường dẫn tới file icon của bạn -->  
    </div>
    <div id="chatbox">
        <div id="chatbox-body"></div>
        <div id="chatbox-footer">
            <input type="text" id="chat-input" placeholder="Nhập tin nhắn..." />
            <button id="send-btn">Gửi</button>
        </div>
    </div>
</div>
<script>
    // Kết nối tới WebSocket server
    const socket = new WebSocket('ws://localhost:3000');
    
    // Mở kết nối và gửi tin nhắn khi người dùng gửi
    socket.onopen = () => {
        console.log("Kết nối thành công");
    };

    socket.onmessage = (event) => {
    let message = event.data;

    // Kiểm tra nếu message là một Blob, chuyển nó thành chuỗi
    if (message instanceof Blob) {
        const reader = new FileReader();
        reader.onload = function() {
            message = reader.result;  // Chuyển Blob thành chuỗi
            const messageElement = document.createElement("div");
            messageElement.textContent = `${message}`;
            document.getElementById("chatbox-body").appendChild(messageElement);
            document.getElementById('toggle-btn').classList.add('blink');

        };
        reader.readAsText(message); // Đọc Blob dưới dạng chuỗi
    } else {
        // Nếu message là chuỗi bình thường
        const messageElement = document.createElement("div");
        messageElement.textContent = `${message}`;
        document.getElementById("chatbox-body").appendChild(messageElement);

        // Thêm hiệu ứng nhấp nháy
        document.getElementById('toggle-btn').classList.add('blink');
    }
};


    // Gửi tin nhắn từ người dùng đến server
    document.getElementById("send-btn").addEventListener("click", function () {
        const messageInput = document.getElementById("chat-input");
        const messageText = messageInput.value.trim();

        if (messageText !== "") {
            // Gửi tin nhắn người dùng đến WebSocket server
            socket.send(messageText);

            // Hiển thị tin nhắn trong chatbox
            const userMessageElement = document.createElement("div");
            userMessageElement.textContent = `Bạn: ${messageText}`;
            document.getElementById("chatbox-body").appendChild(userMessageElement);

            // Xoá input và cuộn xuống cuối
            messageInput.value = "";
            document.getElementById("chatbox-body").scrollTop = document.getElementById("chatbox-body").scrollHeight;

            // Xóa hiệu ứng nhấp nháy khi người dùng trả lời
        document.getElementById('toggle-btn').classList.remove('blink');
        }
    });
    
    // Chuyển đổi hiển thị chatbox khi nhấn vào nút toggle
document.getElementById('toggle-btn').addEventListener('click', function () {
    const chatbox = document.getElementById('chatbox');
    
    // Kiểm tra trạng thái hiện tại của chatbox và thay đổi
    if (chatbox.style.display === 'none' || chatbox.style.display === '') {
        chatbox.style.display = 'flex';  // Mở chatbox
    } else {
        chatbox.style.display = 'none';  // Ẩn chatbox
    }
});

</script>

</body>
</html>
