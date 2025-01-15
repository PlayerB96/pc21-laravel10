const chatButton = document.getElementById('chat-button');
const chatWindow = document.getElementById('chat-window');
const closeChatButton = document.getElementById('close-chat');

chatButton.addEventListener('click', () => {
    chatWindow.style.display = 'block';
});

closeChatButton.addEventListener('click', () => {
    chatWindow.style.display = 'none';
});