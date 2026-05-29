@extends('layouts.auth')

@section('title', 'Chatbot AI - SIMBRO')

@section('content')
<style>
    /* Layout utama */
    .chat-layout {
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow: hidden;
    }
    /* Header oranye */
    .orange-header {
        flex-shrink: 0;
        background: linear-gradient(to bottom right, #FF7A1D, #CD5500);
        padding: 1.5rem 2rem;
    }
    .orange-header .container {
        max-width: 1280px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .header-left {
        display: flex;
        align-items: center;
        gap: 1rem;
    }
    .header-left img {
        height: 48px;
        width: auto;
    }
    .header-left h1 {
        font-size: 1.5rem;
        font-weight: bold;
        margin: 0;
        color: white !important;
    }
    .header-left p {
        font-size: 0.875rem;
        margin: 0;
        color: white !important;
        opacity: 0.9;
    }
    .back-link {
        color: white !important;
        text-decoration: none;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }
    .back-link:hover {
        text-decoration: underline;
    }
    /* Area chat scroll */
    .chat-scroll-area {
        flex: 1;
        overflow-y: auto;
        background: white;
        padding: 1rem 2rem;
    }
    /* Welcome section */
    .welcome-section {
        max-width: 800px;
        margin: 4rem auto 4rem auto; /* sesuaikan jarak */
        text-align: center;
    }
    .welcome-greeting {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }
    .greeting-text {
        color: #FF6B00;
    }
    .user-name {
        color: #1f2937;
    }
    .welcome-sub {
        font-size: 1.125rem;
        color: #4b5563;
    }
    /* Input area */
    .input-area {
        flex-shrink: 0;
        background: white;
        padding: 1rem 1.5rem;
        border-top: none;
    }
    .input-container {
        max-width: 800px;
        margin: 0 auto;
    }
    input:focus {
        outline: none;
        box-shadow: none;
    }
    /* Gaya pesan */
    .chat-message-container {
        margin-bottom: 1.5rem;
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
        max-width: 1000px;
        margin-left: auto;
        margin-right: auto;
    }
    .chat-message-container.flex-row-reverse {
        flex-direction: row-reverse;
    }
    .chat-message-wrapper {
        max-width: 70%;
        display: flex;
        flex-direction: column;
    }
    .chat-message-container.flex-row-reverse .chat-message-wrapper {
        margin-left: auto;
    }
    .chat-message {
        border-radius: 1.25rem;
        padding: 0.75rem 1rem;
        word-wrap: break-word;
        box-shadow: 0 1px 2px rgba(0,0,0,0.05);
    }
    .user-message {
        background-color: #FF6B00;
        color: white;
        border-top-right-radius: 0.25rem;
    }
    .assistant-message {
        background-color: #f3f4f6;
        color: #1f2937;
        border-top-left-radius: 0.25rem;
        border: 1px solid #e5e7eb;
    }
    /* Gaya untuk list yang dihasilkan dari markdown */
    .assistant-message ul {
        list-style-type: disc;
        padding-left: 1.5rem;
        margin: 0.5rem 0;
    }
    .assistant-message li {
        margin: 0.25rem 0;
    }
    .assistant-message strong {
        font-weight: 600;
    }
    .message-actions {
        display: flex;
        gap: 0.75rem;
        margin-top: 0.25rem;
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }
    .message-actions button {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 0.7rem;
        color: #9ca3af;
        transition: color 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 0.25rem;
    }
    .message-actions button:hover {
        color: #FF6B00;
    }
    .typing-indicator span {
        display: inline-block;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: #9ca3af;
        animation: typing 1.4s infinite ease-in-out both;
    }
    .typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
    .typing-indicator span:nth-child(2) { animation-delay: -0.16s; }
    @keyframes typing {
        0%, 80%, 100% { transform: scale(0.6); opacity: 0.5; }
        40% { transform: scale(1); opacity: 1; }
    }
    @media (max-width: 768px) {
        .chat-message-wrapper {
            max-width: 85%;
        }
        .chat-scroll-area {
            padding: 1rem;
        }
        .welcome-greeting {
            font-size: 1.5rem;
        }
    }
</style>

<div class="chat-layout">
    <div class="bg-gradient-to-br from-[#FF7A1D] to-[#CD5500] text-white px-6 py-6 md:px-10 z-10 shadow-sm flex-shrink-0">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div class="flex items-center gap-4">
                <img src="{{ asset('images/logo-simbro-2.png') }}" class="h-12 w-auto">
                <div>
                    <h1 class="text-2xl font-bold">Chatbot AI SIMBRO </h1>
                    <p class="text-orange-100 text-sm">Tanya seputar peternakan ayam broiler dan layanan SIMBRO</p>
                </div>
            </div>
            <div>
             <i class="fas fa-arrow-left"></i> <a href="{{ url()->previous() }}" class="inline-flex items-center gap-2 text-white hover:underline text-sm font-bold"> Kembali ke Beranda</a>
            </div>
        </div>
    </div>

    <!-- Area Chat Scrollable -->
    <div id="chatMessages" class="chat-scroll-area">
        <div class="welcome-section" id="welcomeSection">
            @php
                $hour = date('H');
                if ($hour >= 4 && $hour < 10) $greeting = 'Pagi';
                elseif ($hour >= 10 && $hour < 14) $greeting = 'Siang';
                elseif ($hour >= 14 && $hour < 18) $greeting = 'Sore';
                else $greeting = 'Malam';
                $userName = session('nama_lengkap', 'Pengunjung');
            @endphp
            <div class="welcome-greeting">
                <span class="greeting-text">Selamat {{ $greeting }},</span>
                <span class="user-name"> {{ $userName }}!</span>
            </div>
            <div class="welcome-sub">Katakan apa yang bisa kami bantu.</div>
        </div>
        <!-- Percakapan akan dimuat di sini oleh JavaScript -->
    </div>

    <!-- Input Area -->
    <div class="input-area">
        <div class="input-container">
            <form id="chatForm" class="flex gap-3">
                @csrf
                <input type="text" id="messageInput" placeholder="Tanyakan sesuatu..." class="flex-1 border border-gray-300 rounded-full px-5 py-2.5 focus:outline-none focus:ring-0 focus:border-[#FF6B00] text-sm">
                <button type="submit" id="sendBtn" class="bg-[#FF6B00] hover:bg-orange-700 text-white rounded-full w-10 h-10 flex items-center justify-center transition flex-shrink-0">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
            <div class="flex justify-between items-center mt-2">
                <p class="text-xs text-gray-400">Pengetahuan AI terbatas pada peternakan ayam broiler & layanan SIMBRO</p>
                <button id="refreshChatBtn" class="text-gray-400 hover:text-[#FF6B00] transition text-xs flex items-center gap-1">
                    <i class="fas fa-sync-alt"></i> <span>Refresh</span>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const chatMessages = document.getElementById('chatMessages');
    const messageInput = document.getElementById('messageInput');
    const chatForm = document.getElementById('chatForm');
    const sendBtn = document.getElementById('sendBtn');
    const refreshBtn = document.getElementById('refreshChatBtn');
    const welcomeSection = document.getElementById('welcomeSection');

    // Data percakapan dari server
    const existingConversation = @json($conversation ?? []);

    function scrollToBottom() {
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML.replace(/\n/g, '<br>');
    }

    // Fungsi parse markdown sederhana: bold dan list dengan *
    function parseMarkdown(text) {
        // Bold **teks**
        let html = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        // Garis baru menjadi <br> sementara, tapi kita butuh per baris untuk list
        const lines = html.split('\n');
        let inList = false;
        let result = [];
        for (let line of lines) {
            if (line.trim().startsWith('* ')) {
                if (!inList) {
                    result.push('<ul class="list-disc pl-5 my-1">');
                    inList = true;
                }
                let item = line.trim().substring(2);
                result.push(`<li>${item}</li>`);
            } else {
                if (inList) {
                    result.push('</ul>');
                    inList = false;
                }
                if (line.trim() === '') {
                    result.push('<br>');
                } else {
                    result.push(line);
                }
            }
        }
        if (inList) result.push('</ul>');
        return result.join('\n');
    }

    let typingIndicatorDiv = null;
    function showTypingIndicator() {
        if (typingIndicatorDiv) return;
        typingIndicatorDiv = document.createElement('div');
        typingIndicatorDiv.className = 'flex items-start gap-3 max-w-3xl mx-auto chat-message-container';
        typingIndicatorDiv.innerHTML = `
            <div class="w-8 h-8 bg-[#FF6B00] rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-robot text-white text-xs"></i>
            </div>
            <div class="chat-message-wrapper">
                <div class="chat-message assistant-message">
                    <div class="typing-indicator flex gap-1">
                        <span></span><span></span><span></span>
                    </div>
                </div>
            </div>
        `;
        chatMessages.appendChild(typingIndicatorDiv);
        scrollToBottom();
    }
    function hideTypingIndicator() {
        if (typingIndicatorDiv) {
            typingIndicatorDiv.remove();
            typingIndicatorDiv = null;
        }
    }

    // Menambah pesan ke chat
    function addMessage(role, content, index = null) {
        const isUser = role === 'user';
        const containerDiv = document.createElement('div');
        containerDiv.className = `chat-message-container ${isUser ? 'flex-row-reverse' : ''}`;
        if (index !== null) containerDiv.setAttribute('data-index', index);

        // Avatar
        const avatarDiv = document.createElement('div');
        avatarDiv.className = 'w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0';
        if (isUser) {
            avatarDiv.classList.add('bg-gray-200');
            avatarDiv.innerHTML = '<i class="fas fa-user text-gray-500 text-xs"></i>';
        } else {
            avatarDiv.classList.add('bg-[#FF6B00]');
            avatarDiv.innerHTML = '<i class="fas fa-robot text-white text-xs"></i>';
        }

        const wrapperDiv = document.createElement('div');
        wrapperDiv.className = 'chat-message-wrapper';

        const bubbleDiv = document.createElement('div');
        bubbleDiv.className = `chat-message ${isUser ? 'user-message' : 'assistant-message'}`;

        if (isUser) {
            // User: escape HTML untuk keamanan
            const safeContent = escapeHtml(content);
            bubbleDiv.innerHTML = `<p class="text-sm">${safeContent}</p>`;
        } else {
            // AI: parse markdown (tidak di-escape agar tag HTML list dan strong muncul)
            const parsed = parseMarkdown(content);
            bubbleDiv.innerHTML = `<div class="text-sm">${parsed}</div>`;
        }
        wrapperDiv.appendChild(bubbleDiv);

        // Actions: copy untuk AI
        if (!isUser) {
            const actionsDiv = document.createElement('div');
            actionsDiv.className = 'message-actions';
            const copyBtn = document.createElement('button');
            copyBtn.innerHTML = '<i class="fas fa-copy"></i> Salin';
            copyBtn.onclick = (e) => {
                e.stopPropagation();
                navigator.clipboard.writeText(content);
                if (typeof showLightbox === 'function') {
                    showLightbox('Teks disalin', 'success');
                }
            };
            actionsDiv.appendChild(copyBtn);
            wrapperDiv.appendChild(actionsDiv);
        }

        containerDiv.appendChild(avatarDiv);
        containerDiv.appendChild(wrapperDiv);
        chatMessages.appendChild(containerDiv);
        scrollToBottom();
    }

    // Memuat percakapan dari server
    function loadConversation() {
        const children = [...chatMessages.children];
        children.forEach(child => {
            if (child.id !== 'welcomeSection') child.remove();
        });
        if (existingConversation.length > 0) {
            existingConversation.forEach((msg, idx) => {
                addMessage(msg.role, msg.content, idx);
            });
        } else {
            addMessage('assistant', 'Halo! 👋 Saya asisten SIMBRO. Saya bisa membantu menjawab pertanyaan seputar peternakan ayam broiler, produk SIMBRO, dan cara menggunakan website ini. Ada yang bisa saya bantu?');
        }
        scrollToBottom();
    }

    // Kirim pesan baru
    async function sendMessage(message) {
        addMessage('user', message);
        messageInput.value = '';
        showTypingIndicator();
        sendBtn.disabled = true;
        try {
            const response = await fetch('{{ route("chatbot.send") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ message: message })
            });
            const data = await response.json();
            hideTypingIndicator();
            if (data.success) {
                addMessage('assistant', data.message);
            } else {
                addMessage('assistant', data.message || 'Maaf, terjadi kesalahan. Silakan coba lagi.');
            }
        } catch (error) {
            console.error('Error:', error);
            hideTypingIndicator();
            addMessage('assistant', 'Maaf, terjadi kesalahan koneksi. Silakan coba lagi.');
        } finally {
            sendBtn.disabled = false;
            messageInput.focus();
        }
    }

    // Event listeners
    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;
        await sendMessage(message);
    });

    refreshBtn.addEventListener('click', () => {
        chatMessages.style.transition = 'opacity 0.15s ease';
        chatMessages.style.opacity = '0';
        setTimeout(() => {
            window.location.reload();
        }, 150);
    });

    // Inisialisasi
    loadConversation();
    messageInput.focus();
    scrollToBottom();
</script>
@endsection
