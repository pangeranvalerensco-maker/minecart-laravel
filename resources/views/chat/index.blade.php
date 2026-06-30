@extends('layouts.app')

@section('title', 'Pesan')

@section('content')
<main class="main-content" style="background-color: var(--body-bg); padding: 20px 0;">
    <div class="container" style="max-width: 1000px;">
        <div style="display: flex; height: 75vh; background: var(--card-bg); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); border: 1px solid var(--subtle-border-color);">
            
            <!-- Sidebar: Daftar Obrolan -->
            <div style="width: 300px; border-right: 1px solid var(--subtle-border-color); display: flex; flex-direction: column;">
                <div style="padding: 20px; border-bottom: 1px solid var(--subtle-border-color); background: var(--header-main-bg);">
                    <h2 style="font-size: 1.2rem; margin: 0; font-weight: 600;">Pesan</h2>
                </div>
                
                <div style="flex-grow: 1; overflow-y: auto;">
                    @forelse($conversations as $conv)
                        @php
                            $otherUser = $conv->otherUser;
                            $isActive = request('conversation') == $conv->id;
                        @endphp
                        <a href="{{ route('chat.index', ['conversation' => $conv->id]) }}" 
                           style="display: flex; align-items: center; gap: 15px; padding: 15px 20px; text-decoration: none; border-bottom: 1px solid var(--subtle-border-color); transition: background 0.2s; background: {{ $isActive ? 'var(--section-bg)' : 'transparent' }}; color: var(--text-color);"
                           onmouseover="this.style.background='var(--section-bg)'"
                           onmouseout="this.style.background='{{ $isActive ? 'var(--section-bg)' : 'transparent' }}'">
                            
                            <div style="width: 45px; height: 45px; border-radius: 50%; background: var(--accent-color); color: var(--accent-text-color); display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.2rem; flex-shrink: 0;">
                                {{ substr($otherUser->store_name ?? $otherUser->name, 0, 1) }}
                            </div>
                            
                            <div style="flex-grow: 1; overflow: hidden;">
                                <div style="font-weight: 600; font-size: 0.95rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $otherUser->store_name ?? $otherUser->name }}
                                </div>
                                <div style="font-size: 0.85rem; color: #666; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    @if($conv->messages->first())
                                        {{ $conv->messages->first()->message }}
                                    @else
                                        <i style="opacity: 0.6;">Belum ada pesan</i>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @empty
                        <div style="padding: 30px 20px; text-align: center; color: #888; font-size: 0.9rem;">
                            Belum ada obrolan.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Area Obrolan -->
            <div style="flex-grow: 1; display: flex; flex-direction: column; background: var(--body-bg);">
                @if(request('conversation'))
                    @php
                        $activeConv = $conversations->firstWhere('id', request('conversation'));
                        $otherUser = $activeConv ? $activeConv->otherUser : null;
                    @endphp

                    @if($activeConv && $otherUser)
                        <!-- Header Obrolan -->
                        <div style="padding: 15px 20px; border-bottom: 1px solid var(--subtle-border-color); background: var(--header-main-bg); display: flex; align-items: center; gap: 15px;">
                            <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--accent-color); color: var(--accent-text-color); display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                {{ substr($otherUser->store_name ?? $otherUser->name, 0, 1) }}
                            </div>
                            <div style="font-weight: 600; font-size: 1.1rem;">
                                {{ $otherUser->store_name ?? $otherUser->name }}
                            </div>
                        </div>

                        <!-- Area Pesan -->
                        <div id="messages-container" style="flex-grow: 1; padding: 20px; overflow-y: auto; display: flex; flex-direction: column; gap: 15px;">
                            <!-- Pesan akan dimuat via JS -->
                            <div style="text-align: center; color: #888; font-size: 0.9rem;">Memuat pesan...</div>
                        </div>

                        <!-- Form Input Pesan -->
                        <div style="padding: 15px 20px; border-top: 1px solid var(--subtle-border-color); background: var(--header-main-bg);">
                            <form id="chat-form" style="display: flex; gap: 10px;">
                                <input type="text" id="chat-input" placeholder="Tulis pesan..." required style="flex-grow: 1; padding: 12px 15px; border: 1px solid var(--subtle-border-color); border-radius: 20px; background: var(--body-bg); color: var(--text-color); outline: none;">
                                <button type="submit" class="primary-btn" style="border-radius: 20px; padding: 0 25px; border: none; cursor: pointer; background: var(--accent-color); color: var(--accent-text-color); font-weight: 600;">Kirim</button>
                            </form>
                        </div>
                    @else
                        <div style="flex-grow: 1; display: flex; align-items: center; justify-content: center; color: #888;">
                            Obrolan tidak ditemukan.
                        </div>
                    @endif
                @else
                    <div style="flex-grow: 1; display: flex; align-items: center; justify-content: center; color: #888; flex-direction: column; gap: 15px;">
                        <img src="{{ asset('assets/logo-minecart.png') }}" style="width: 80px; opacity: 0.2;">
                        <div>Pilih obrolan untuk mulai mengirim pesan.</div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</main>

@if(request('conversation') && isset($activeConv))
<script>
    const convId = {{ $activeConv->id }};
    const currentUserId = {{ auth()->id() }};
    const messagesContainer = document.getElementById('messages-container');
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    
    // Polling interval
    let pollingInterval;

    function formatTime(dateString) {
        const date = new Date(dateString);
        return date.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'});
    }

    function renderMessage(msg) {
        const isMine = msg.sender_id === currentUserId;
        const align = isMine ? 'flex-end' : 'flex-start';
        const bg = isMine ? 'var(--accent-color)' : 'var(--card-bg)';
        const color = isMine ? 'var(--accent-text-color)' : 'var(--text-color)';
        const border = isMine ? 'none' : '1px solid var(--subtle-border-color)';
        const radius = isMine ? '15px 15px 0 15px' : '15px 15px 15px 0';
        
        return `
            <div style="align-self: ${align}; max-width: 70%; display: flex; flex-direction: column;">
                <div style="background: ${bg}; color: ${color}; padding: 10px 15px; border-radius: ${radius}; border: ${border}; box-shadow: 0 2px 5px rgba(0,0,0,0.02);">
                    ${msg.message}
                </div>
                <div style="font-size: 0.75rem; color: #888; margin-top: 5px; text-align: ${isMine ? 'right' : 'left'};">
                    ${formatTime(msg.created_at)}
                </div>
            </div>
        `;
    }

    async function fetchMessages() {
        try {
            const res = await fetch(`/chat/${convId}/messages`);
            const data = await res.json();
            
            messagesContainer.innerHTML = '';
            
            if(data.length === 0) {
                messagesContainer.innerHTML = '<div style="text-align: center; color: #888; margin-top: 20px;">Belum ada pesan. Mulai obrolan!</div>';
            } else {
                data.forEach(msg => {
                    messagesContainer.innerHTML += renderMessage(msg);
                });
                // Scroll to bottom
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        } catch(e) {
            console.error('Failed to fetch messages', e);
        }
    }

    chatForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const message = chatInput.value.trim();
        if(!message) return;

        // Optimistic UI update
        const tempMsg = {
            sender_id: currentUserId,
            message: message,
            created_at: new Date().toISOString()
        };
        
        if(messagesContainer.innerHTML.includes('Belum ada pesan')) {
            messagesContainer.innerHTML = '';
        }
        
        messagesContainer.innerHTML += renderMessage(tempMsg);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        chatInput.value = '';

        try {
            const res = await fetch(`/chat/${convId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ message })
            });
            
            // Re-fetch to get correct timestamp and ID
            fetchMessages();
        } catch(e) {
            console.error('Failed to send message', e);
        }
    });

    // Initial fetch
    fetchMessages();
    
    // Setup Database Polling (Option C) every 3 seconds
    pollingInterval = setInterval(fetchMessages, 3000);
</script>
@endif
@endsection
