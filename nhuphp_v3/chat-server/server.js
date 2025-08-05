const WebSocket = require('ws');
const wss = new WebSocket.Server({ port: 3000 });

wss.on('connection', (ws) => {
    console.log('A new client connected');
    
    // Lắng nghe tin nhắn từ client (người dùng hoặc admin)
    ws.on('message', (message) => {
        console.log('Received message:', message);
        
        // Gửi lại tin nhắn cho tất cả client đang kết nối
        wss.clients.forEach(client => {
            if (client !== ws && client.readyState === WebSocket.OPEN) {
                client.send(message);  // Gửi tin nhắn tới tất cả các client (trừ bản thân)
            }
        });
    });

    // Khi client ngắt kết nối
    ws.on('close', () => {
        console.log('Client disconnected');
    });
});

console.log('WebSocket server is running on ws://localhost:3000');
