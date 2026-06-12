@extends('layouts.V_Auth')

@section('title', 'Chatbot AI - SIMBRO')

@section('header_title', 'Chatbot AI SIMBRO')
@section('header_desc', 'Asisten virtual cerdas siap membantu Anda')

@php
    $backUrl = url('/#gallery');
    if (session('user_logged_in')) {
        $backUrl = session('role') == 1 ? route('admin.home') . '#gallery' : route('customer.home') . '#gallery';
    }
@endphp

@section('header_back_url', $backUrl)
@section('header_back_text', 'Kembali ke Beranda')

@push('styles')
<style>
    /* Stop entire page from scrolling */
    html, body {
        overflow: hidden !important;
        height: 100%;
    }
    main {
        overflow: hidden !important;
    }

    /* Fixed layout constraints */
    .chat-layout {
        height: 100%;
        overflow: hidden;
        position: relative;
        background: transparent !important;
    }
    
    .chat-scroll-area {
        background: transparent !important;
        scroll-behavior: smooth;
        height: 100%;
        overflow-y: auto;
        padding-bottom: 140px; /* Space for the absolute input area */
    }
    
    /* Hide standard scrollbar completely */
    .chat-scroll-area::-webkit-scrollbar {
        display: none;
    }
    .chat-scroll-area {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
    
    /* Messages */
    .chat-message-container {
        margin-bottom: 1.5rem;
        display: flex;
        gap: 0.75rem;
        align-items: flex-start;
        max-width: 1000px;
    }
    .chat-message-container.flex-row-reverse {
        flex-direction: row-reverse;
    }
    .chat-message-wrapper {
        max-width: 80%;
        display: flex;
        flex-direction: column;
    }
    .chat-message-container.flex-row-reverse .chat-message-wrapper {
        margin-left: auto;
    }
    
    .bubble-ai {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 107, 0, 0.15);
        border-radius: 1.5rem 1.5rem 1.5rem 0.25rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        color: #374151;
        padding: 1rem 1.25rem;
    }
    
    .bubble-user {
        background: linear-gradient(135deg, #FF7A1D, #FF5500);
        color: white;
        border-radius: 1.5rem 1.5rem 0.25rem 1.5rem;
        box-shadow: 0 4px 15px rgba(255, 107, 0, 0.25);
        padding: 0.75rem 1.25rem;
    }
    
    /* Input Area */
    .input-glass {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(16px);
        border-top: 1px solid rgba(255, 255, 255, 0.6);
    }
    
    /* Suggestion Chips */
    .suggestion-chip {
        transition: all 0.2s ease;
    }
    .suggestion-chip:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(255, 107, 0, 0.15);
        border-color: #FF6B00;
        background: #FFF9F5;
    }
    
    /* Typing Indicator */
    .typing-dot {
        animation: typing 1.4s infinite ease-in-out both;
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background-color: #FF6B00;
        display: inline-block;
    }
    .typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .typing-dot:nth-child(2) { animation-delay: -0.16s; }
    
    @keyframes typing {
        0%, 80%, 100% { transform: scale(0.4); opacity: 0.5; }
        40% { transform: scale(1); opacity: 1; }
    }
    
    .message-actions {
        margin-top: 0.5rem;
        margin-left: 0.5rem;
    }
    
    @media (max-width: 768px) {
        .chat-message-wrapper { max-width: 90%; }
    }
</style>
@endpush

@section('content')

<div class="chat-layout w-full max-w-5xl mx-auto">
    <!-- Custom Scroll Indicator (5 bars) -->
    <div class="absolute right-2 md:right-4 top-1/2 -translate-y-1/2 flex flex-col gap-2 z-40 transition-opacity duration-300" id="scrollIndicator">
        <div class="scroll-dot w-1.5 h-5 rounded-full bg-gray-200 transition-all duration-300"></div>
        <div class="scroll-dot w-1.5 h-5 rounded-full bg-gray-200 transition-all duration-300"></div>
        <div class="scroll-dot w-1.5 h-5 rounded-full bg-gray-200 transition-all duration-300"></div>
        <div class="scroll-dot w-1.5 h-5 rounded-full bg-gray-200 transition-all duration-300"></div>
        <div class="scroll-dot w-1.5 h-5 rounded-full bg-gray-200 transition-all duration-300"></div>
    </div>

    <!-- Chat Messages Area -->
    <div id="chatMessages" class="chat-scroll-area pt-6 pl-4 pr-10 md:pl-8 md:pr-16">
        
        <!-- Welcome Section -->
        <div class="welcome-section flex flex-col items-center justify-center min-h-[45vh] text-center transition-all duration-500 mt-4 md:mt-8 mb-8" id="welcomeSection">
            <div class="w-24 h-24 bg-gradient-to-br from-[#FF7A1D] to-[#FF6B00] rounded-full flex items-center justify-center shadow-xl shadow-orange-500/30 mb-6 relative z-10">
                <i class="fas fa-robot text-white text-4xl"></i>
                <div class="absolute inset-0 rounded-full border-2 border-[#FF7A1D] animate-ping opacity-30 -z-10"></div>
            </div>
            
            @php
                $hour = date('H');
                if ($hour >= 4 && $hour < 10) $greeting = 'Pagi';
                elseif ($hour >= 10 && $hour < 14) $greeting = 'Siang';
                elseif ($hour >= 14 && $hour < 18) $greeting = 'Sore';
                else $greeting = 'Malam';
                $userName = session('nama_lengkap', 'Pengunjung');
            @endphp
            
            <h2 class="text-3xl md:text-4xl font-extrabold text-gray-800 mb-3 tracking-tight">
                Selamat {{ $greeting }}, <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#FF7A1D] to-[#FF6B00]">{{ $userName }}</span>
            </h2>
            <p class="text-gray-500 text-base md:text-lg max-w-lg mx-auto mb-10 leading-relaxed px-4">
                Tanyakan apa saja seputar peternakan ayam broiler, layanan SIMBRO, atau panduan transaksi.
            </p>

            <!-- Suggested Prompts -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 max-w-2xl w-full mx-auto px-4" id="suggestionBox">
                <button onclick="sendSuggestion('Bagaimana cara memesan ayam broiler di SIMBRO?')" class="suggestion-chip bg-white/80 backdrop-blur-sm border border-orange-100 rounded-md p-4 text-left flex items-start gap-4 group">
                    <div class="w-10 h-10 rounded-full bg-orange-50 text-[#FF6B00] flex items-center justify-center flex-shrink-0 group-hover:bg-[#FF6B00] group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-shopping-cart text-sm"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm mb-1 group-hover:text-[#FF6B00] transition-colors">Cara Pemesanan</p>
                        <p class="text-xs text-gray-500 leading-tight">Panduan langkah belanja produk</p>
                    </div>
                </button>
                <button onclick="sendSuggestion('Apa keunggulan ayam broiler SIMBRO?')" class="suggestion-chip bg-white/80 backdrop-blur-sm border border-orange-100 rounded-md p-4 text-left flex items-start gap-4 group">
                    <div class="w-10 h-10 rounded-full bg-orange-50 text-[#FF6B00] flex items-center justify-center flex-shrink-0 group-hover:bg-[#FF6B00] group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-egg text-sm"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm mb-1 group-hover:text-[#FF6B00] transition-colors">Kualitas Produk</p>
                        <p class="text-xs text-gray-500 leading-tight">Kenali standar mutu ayam broiler kami</p>
                    </div>
                </button>
                <button onclick="sendSuggestion('Berapa lama estimasi pengiriman pesanan?')" class="suggestion-chip bg-white/80 backdrop-blur-sm border border-orange-100 rounded-md p-4 text-left flex items-start gap-4 group">
                    <div class="w-10 h-10 rounded-full bg-orange-50 text-[#FF6B00] flex items-center justify-center flex-shrink-0 group-hover:bg-[#FF6B00] group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-truck-fast text-sm"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm mb-1 group-hover:text-[#FF6B00] transition-colors">Info Pengiriman</p>
                        <p class="text-xs text-gray-500 leading-tight">Estimasi waktu & prosedur kirim</p>
                    </div>
                </button>
                <button onclick="sendSuggestion('Bagaimana jika saya lupa password akun?')" class="suggestion-chip bg-white/80 backdrop-blur-sm border border-orange-100 rounded-md p-4 text-left flex items-start gap-4 group">
                    <div class="w-10 h-10 rounded-full bg-orange-50 text-[#FF6B00] flex items-center justify-center flex-shrink-0 group-hover:bg-[#FF6B00] group-hover:text-white transition-colors duration-300">
                        <i class="fas fa-key text-sm"></i>
                    </div>
                    <div>
                        <p class="font-bold text-gray-800 text-sm mb-1 group-hover:text-[#FF6B00] transition-colors">Lupa Password</p>
                        <p class="text-xs text-gray-500 leading-tight">Solusi jika tidak bisa login</p>
                    </div>
                </button>
            </div>
        </div>
    </div>

    <!-- Sticky Input Area Fixed on Top of Chat -->
    <div class="absolute bottom-0 left-0 right-0 w-full p-4 md:p-6 input-glass rounded-t-3xl shadow-[0_-15px_40px_rgba(0,0,0,0.06)] z-50">
        <div class="max-w-4xl mx-auto">
            <form id="chatForm" class="relative flex items-center shadow-lg rounded-full">
                @csrf
                <input type="text" id="messageInput" autocomplete="off" placeholder="Ketik pertanyaan Anda di sini..." class="w-full bg-white border-2 border-transparent rounded-full pl-6 pr-14 py-4 focus:outline-none focus:ring-4 focus:ring-[#FF6B00]/20 focus:border-[#FF6B00] text-sm text-gray-700 transition-all shadow-sm">
                <button type="submit" id="sendBtn" class="absolute right-2 top-1/2 -translate-y-1/2 bg-gradient-to-r from-[#FF7A1D] to-[#FF6B00] shadow-md shadow-orange-500/40 text-white rounded-full w-10 h-10 flex items-center justify-center transition-all transform hover:scale-105 active:scale-95 disabled:opacity-50 disabled:hover:scale-100">
                    <i class="fas fa-paper-plane ml-[-2px] text-sm"></i>
                </button>
            </form>
            <div class="flex flex-col sm:flex-row justify-between items-center mt-4 px-2 gap-3">
                <p class="text-[11px] text-gray-500 font-medium flex items-center gap-1.5 bg-gray-100/50 px-3 py-1 rounded-full"><i class="fas fa-shield-alt text-green-500"></i> AI menjawab seputar SIMBRO & broiler.</p>
                <button id="refreshChatBtn" type="button" title="Mulai obrolan baru" class="text-gray-400 hover:text-[#FF6B00] transition text-[11px] font-bold uppercase tracking-wider flex items-center gap-1.5 bg-gray-100 hover:bg-orange-50 px-4 py-1.5 rounded-md">
                    <i class="fas fa-broom"></i> Bersihkan Obrolan
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
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
        chatMessages.scrollTo({
            top: chatMessages.scrollHeight,
            behavior: 'smooth'
        });
        setTimeout(updateScrollIndicator, 100);
    }

    // Custom Scroll Indicator Logic
    const scrollDots = document.querySelectorAll('.scroll-dot');
    function updateScrollIndicator() {
        if (!scrollDots.length) return;
        const maxScroll = chatMessages.scrollHeight - chatMessages.clientHeight;
        
        if (maxScroll <= 0) {
            // Not scrollable, hide indicator or set first active
            scrollDots.forEach(dot => dot.classList.replace('bg-[#FF6B00]', 'bg-gray-200'));
            scrollDots[0].classList.replace('bg-gray-200', 'bg-[#FF6B00]');
            document.getElementById('scrollIndicator').style.opacity = '0';
            return;
        }
        
        document.getElementById('scrollIndicator').style.opacity = '1';
        const scrollPercentage = chatMessages.scrollTop / maxScroll;
        const numDots = scrollDots.length;
        
        let activeIndex = Math.floor(scrollPercentage * numDots);
        if (activeIndex >= numDots) activeIndex = numDots - 1;

        scrollDots.forEach((dot, index) => {
            if (index === activeIndex) {
                dot.classList.replace('bg-gray-200', 'bg-[#FF6B00]');
                dot.style.transform = 'scale(1.2)';
            } else {
                dot.classList.replace('bg-[#FF6B00]', 'bg-gray-200');
                dot.style.transform = 'scale(1)';
            }
        });
    }

    chatMessages.addEventListener('scroll', updateScrollIndicator);

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML.replace(/\n/g, '<br>');
    }

    function parseMarkdown(text) {
        let html = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        const lines = html.split('\n');
        let inList = false;
        let result = [];
        for (let line of lines) {
            if (line.trim().startsWith('* ') || line.trim().match(/^[0-9]+\. /)) {
                if (!inList) {
                    result.push('<ul class="list-disc pl-5 my-2 space-y-1">');
                    inList = true;
                }
                let item = line.trim().replace(/^(\* |[0-9]+\. )/, '');
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

    function sendSuggestion(text) {
        messageInput.value = text;
        chatForm.dispatchEvent(new Event('submit'));
    }

    let typingIndicatorDiv = null;
    function showTypingIndicator() {
        if (typingIndicatorDiv) return;
        typingIndicatorDiv = document.createElement('div');
        typingIndicatorDiv.className = 'chat-message-container w-full';
        typingIndicatorDiv.innerHTML = `
            <div class="w-10 h-10 bg-gradient-to-br from-[#FF7A1D] to-[#FF6B00] rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                <i class="fas fa-robot text-white text-sm"></i>
            </div>
            <div class="chat-message-wrapper">
                <div class="bubble-ai px-5 py-4 flex gap-1 items-center h-10">
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
                    <span class="typing-dot"></span>
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

    function addMessage(role, content, index = null) {
        const isUser = role === 'user';
        const containerDiv = document.createElement('div');
        containerDiv.className = `chat-message-container w-full ${isUser ? 'flex-row-reverse' : ''}`;
        if (index !== null) containerDiv.setAttribute('data-index', index);

        // Avatar
        const avatarDiv = document.createElement('div');
        avatarDiv.className = 'w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 shadow-sm';
        if (isUser) {
            avatarDiv.classList.add('bg-white', 'border', 'border-gray-200');
            avatarDiv.innerHTML = '<i class="fas fa-user text-gray-400 text-sm"></i>';
        } else {
            avatarDiv.classList.add('bg-gradient-to-br', 'from-[#FF7A1D]', 'to-[#FF6B00]', 'shadow-md', 'shadow-orange-500/20');
            avatarDiv.innerHTML = '<i class="fas fa-robot text-white text-sm"></i>';
        }

        const wrapperDiv = document.createElement('div');
        wrapperDiv.className = 'chat-message-wrapper';

        const bubbleDiv = document.createElement('div');
        bubbleDiv.className = isUser ? 'bubble-user' : 'bubble-ai';

        if (isUser) {
            const safeContent = escapeHtml(content);
            bubbleDiv.innerHTML = `<p class="text-sm md:text-[15px] font-medium tracking-wide">${safeContent}</p>`;
        } else {
            const parsed = parseMarkdown(content);
            bubbleDiv.innerHTML = `<div class="text-sm md:text-[15px] leading-relaxed space-y-2">${parsed}</div>`;
        }
        wrapperDiv.appendChild(bubbleDiv);

        if (!isUser) {
            const actionsDiv = document.createElement('div');
            actionsDiv.className = 'message-actions';
            const copyBtn = document.createElement('button');
            copyBtn.className = 'text-xs text-gray-400 hover:text-[#FF6B00] flex items-center gap-1.5 bg-white px-2.5 py-1 rounded-md shadow-sm border border-gray-100 transition-colors';
            copyBtn.innerHTML = '<i class="fas fa-copy"></i> Salin';
            copyBtn.onclick = (e) => {
                e.stopPropagation();
                
                // Fallback method for non-HTTPS (Laragon HTTP)
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(content).catch(err => console.error('Clipboard error:', err));
                } else {
                    let textArea = document.createElement("textarea");
                    textArea.value = content;
                    textArea.style.position = "fixed";
                    textArea.style.left = "-999999px";
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try {
                        document.execCommand('copy');
                    } catch (err) {
                        console.error('Fallback copy error:', err);
                    }
                    document.body.removeChild(textArea);
                }

                copyBtn.innerHTML = '<i class="fas fa-check text-green-500"></i> Disalin';
                setTimeout(() => {
                    copyBtn.innerHTML = '<i class="fas fa-copy"></i> Salin';
                }, 2000);
            };
            actionsDiv.appendChild(copyBtn);
            wrapperDiv.appendChild(actionsDiv);
        }

        containerDiv.appendChild(avatarDiv);
        containerDiv.appendChild(wrapperDiv);
        chatMessages.appendChild(containerDiv);
        
        // Hide welcome section if it's the first message
        if (welcomeSection && welcomeSection.style.display !== 'none') {
            welcomeSection.style.opacity = '0';
            setTimeout(() => {
                welcomeSection.style.display = 'none';
                scrollToBottom();
            }, 300);
        } else {
            scrollToBottom();
        }
    }

    function loadConversation() {
        const children = [...chatMessages.children];
        children.forEach(child => {
            if (child.id !== 'welcomeSection') child.remove();
        });
        
        if (existingConversation.length > 0) {
            welcomeSection.style.display = 'none';
            existingConversation.forEach((msg, idx) => {
                addMessage(msg.role, msg.content, idx);
            });
            scrollToBottom();
        }
    }

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

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = messageInput.value.trim();
        if (!message) return;
        await sendMessage(message);
    });

    refreshBtn.addEventListener('click', async () => {
        try {
            await fetch('{{ route("chatbot.clear") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                }
            });
            chatMessages.style.opacity = '0';
            setTimeout(() => {
                window.location.reload();
            }, 200);
        } catch(e) {
            window.location.reload();
        }
    });

    // Inisialisasi
    loadConversation();
    setTimeout(() => { messageInput.focus(); updateScrollIndicator(); }, 500);
</script>
@endpush
