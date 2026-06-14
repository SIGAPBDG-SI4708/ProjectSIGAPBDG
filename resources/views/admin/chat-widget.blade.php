<div x-data="chatWidget()" x-init="initChat()" class="fixed bottom-6 right-6 z-[999] font-sans">

    <button @click="toggleChat()"
        class="w-14 h-14 bg-brand-500 hover:bg-brand-600 text-white rounded-full shadow-xl flex items-center justify-center transition-transform hover:scale-110 relative">
        <svg x-show="!isOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <svg x-show="isOpen" style="display: none;" class="w-6 h-6" fill="none" stroke="currentColor"
            viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>

        <div x-show="totalUnread > 0" x-text="totalUnread"
            class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center border-2 border-white dark:border-slate-900"
            style="display: none;">
        </div>
    </button>

    <div x-show="isOpen" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="absolute bottom-20 right-0 w-80 sm:w-96 bg-white dark:bg-slate-900 rounded-2xl shadow-2xl border border-stone-200 dark:border-slate-700 overflow-hidden flex flex-col"
        style="display: none; height: 500px; max-height: calc(100vh - 120px);">

        <div x-show="currentView === 'contacts'" class="flex flex-col h-full">
            <div class="bg-brand-500 text-white p-4 flex justify-between items-center shrink-0">
                <div>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 mr-2 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <h3 class="font-bold">Chat Koordinasi</h3>
                    </div>
                    <p class="text-xs text-brand-100">SIGAP BDG Internal</p>
                </div>
                <button @click="openSearch()" class="p-1.5 bg-white/20 hover:bg-white/30 rounded-lg transition"
                    title="Pesan Baru">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-2">
                <template x-if="contacts.length === 0 && !isLoadingContacts">
                    <div
                        class="flex flex-col items-center justify-center h-full text-stone-400 dark:text-slate-500 p-6 text-center">
                        <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        <p class="text-sm">Belum ada percakapan.<br>Klik tombol (+) untuk memulai.</p>
                    </div>
                </template>

                <template x-if="isLoadingContacts">
                    <div class="flex justify-center p-4">
                        <svg class="animate-spin h-5 w-5 text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </template>

                <template x-for="contact in contacts" :key="contact.id">
                    <button @click="openChat(contact)"
                        class="w-full text-left p-3 hover:bg-stone-50 dark:hover:bg-slate-800 rounded-xl flex items-center gap-3 transition">
                        <div
                            class="w-10 h-10 rounded-full bg-stone-200 dark:bg-slate-700 flex items-center justify-center shrink-0 font-bold text-stone-500 dark:text-slate-400">
                            <span x-text="contact.nama.charAt(0)"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-0.5">
                                <h4 class="font-bold text-sm text-stone-800 dark:text-white truncate"
                                    x-text="contact.nama"></h4>
                                <span class="text-[10px] text-stone-400"
                                    x-text="formatTime(contact.last_message?.created_at)"></span>
                            </div>
                            <p class="text-xs text-stone-500 dark:text-slate-400 truncate mt-1"
                                x-text="contact.last_message?.message || ''"
                                :class="{'font-bold text-stone-800 dark:text-stone-200': contact.unread_count > 0}"></p>
                        </div>
                        <div x-show="contact.unread_count > 0"
                            class="w-5 h-5 rounded-full bg-brand-500 text-white text-[10px] font-bold flex items-center justify-center shrink-0"
                            x-text="contact.unread_count"></div>
                    </button>
                </template>
            </div>
        </div>

        <div x-show="currentView === 'search'" class="flex flex-col h-full" style="display: none;">
            <div class="bg-brand-500 text-white p-4 flex items-center gap-3 shrink-0">
                <button @click="currentView = 'contacts'" class="p-1 hover:bg-white/20 rounded-lg transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <h3 class="font-bold">Pesan Baru</h3>
            </div>

            <div class="p-3 border-b border-stone-100 dark:border-slate-800 shrink-0">
                <div class="relative">
                    <input type="text" x-model="searchQuery" placeholder="Cari nama atau daerah..."
                        class="w-full bg-stone-50 dark:bg-slate-800 border border-stone-200 dark:border-slate-700 text-sm rounded-xl pl-9 pr-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-500 dark:text-white">
                    <svg class="w-4 h-4 text-stone-400 absolute left-3 top-2.5" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-2">
                <template x-if="isSearching">
                    <div class="flex justify-center p-4">
                        <svg class="animate-spin h-5 w-5 text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </template>
                <template x-if="!isSearching && searchQuery !== '' && searchResults.length === 0">
                    <div class="text-center text-stone-400 p-4 text-sm">Tidak ada hasil ditemukan.</div>
                </template>
                <template x-for="user in searchResults" :key="user.id">
                    <button @click="openChat(user)"
                        class="w-full text-left p-3 hover:bg-stone-50 dark:hover:bg-slate-800 rounded-xl flex items-center gap-3 transition">
                        <div
                            class="w-10 h-10 rounded-full bg-stone-200 dark:bg-slate-700 flex items-center justify-center shrink-0 font-bold text-stone-500 dark:text-slate-400">
                            <span x-text="user.nama.charAt(0)"></span>
                        </div>
                        <div>
                            <h4 class="font-bold text-sm text-stone-800 dark:text-white" x-text="user.nama"></h4>
                        </div>
                    </button>
                </template>
            </div>
        </div>

        <div x-show="currentView === 'room'" class="flex flex-col h-full bg-stone-50 dark:bg-slate-950"
            style="display: none;">
            <div
                class="bg-white dark:bg-slate-900 border-b border-stone-200 dark:border-slate-800 p-3 flex items-center gap-3 shrink-0 shadow-sm z-10">
                <button @click="closeChat()"
                    class="p-1 hover:bg-stone-100 dark:hover:bg-slate-800 rounded-lg transition text-stone-500 dark:text-slate-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <div
                    class="w-9 h-9 rounded-full bg-brand-100 dark:bg-brand-900/30 text-brand-600 dark:text-brand-400 flex items-center justify-center shrink-0 font-bold">
                    <span x-text="activeChatUser?.nama.charAt(0)"></span>
                </div>
                <div class="min-w-0">
                    <h3 class="font-bold text-sm text-stone-800 dark:text-white truncate" x-text="activeChatUser?.nama">
                    </h3>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-3" id="chatMessagesArea">
                <template x-if="isLoadingMessages">
                    <div class="flex justify-center p-4">
                        <svg class="animate-spin h-5 w-5 text-brand-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </template>

                <template x-for="msg in messages" :key="msg.id">
                    <div class="flex" :class="msg.sender_id === myId ? 'justify-end' : 'justify-start'">
                        <div class="max-w-[80%] rounded-2xl px-4 py-2"
                            :class="msg.sender_id === myId 
                                ? 'bg-brand-500 text-white rounded-tr-sm' 
                                : 'bg-white dark:bg-slate-800 text-stone-800 dark:text-white border border-stone-200 dark:border-slate-700 rounded-tl-sm'">
                            <p class="text-sm" x-text="msg.message" style="word-break: break-word;"></p>
                            <div class="text-[9px] text-right mt-1 opacity-70 flex items-center justify-end gap-1">
                                <span x-text="formatTime(msg.created_at)"></span>
                                <template x-if="msg.sender_id === myId">
                                    <span>
                                        <svg x-show="!msg.is_read" class="w-3 h-3 text-white/80" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <svg x-show="msg.is_read" class="w-3 h-3 text-blue-200 drop-shadow-sm"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 17l4 4L23 11" style="stroke-opacity:0.8;" />
                                        </svg>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="bg-white dark:bg-slate-900 border-t border-stone-200 dark:border-slate-800 p-3 shrink-0">
                <form @submit.prevent="sendMessage" class="flex gap-2">
                    <input type="text" x-model="newMessage" placeholder="Ketik pesan..."
                        class="flex-1 bg-stone-50 dark:bg-slate-800 border border-stone-200 dark:border-slate-700 text-sm rounded-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-brand-500 dark:text-white"
                        :disabled="isSending">
                    <button type="submit" :disabled="!newMessage.trim() || isSending"
                        class="w-10 h-10 rounded-full bg-brand-500 hover:bg-brand-600 text-white flex items-center justify-center shrink-0 transition disabled:opacity-50 disabled:cursor-not-allowed">

                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10l18-7-7 18-2-8-9-3z" />
                        </svg>

                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('chatWidget', () => ({
            isOpen: false,
            currentView: 'contacts',
            contacts: [],
            searchResults: [],
            searchQuery: '',
            messages: [],
            newMessage: '',
            activeChatUser: null,
            myId: {{ Auth::id() }},

            isLoadingContacts: false,
            isSearching: false,
            isLoadingMessages: false,
            isSending: false,

            setupEchoListeners() {
                if (window.Echo) {
                    window.Echo.private(`chat.${this.myId}`)
                        .listen('ChatMessageSent', (e) => {
                            let audio = new Audio('{{ asset("sounds/notif-chat.mp3") }}');
                            audio.play().catch(err => {
                                console.log('Autoplay blocked:', err);
                            });

                            if (this.isOpen && this.currentView === 'room' && this.activeChatUser && this.activeChatUser.id === e.message.sender_id) {
                                this.messages.push(e.message);
                                this.scrollToBottom();
                                this.markAsRead(e.message.sender_id);
                            } else {
                                this.loadContacts();

                                window.dispatchEvent(new CustomEvent('tampilkan-notif', {
                                    detail: {
                                        jenis: 'info',
                                        judul: `Pesan baru dari ${e.message.sender.nama}`,
                                        pesan: e.message.message,
                                        actionChat: e.message.sender_id
                                    }
                                }));
                            }
                        })
                        .listen('ChatMessagesRead', (e) => {
                            if (this.activeChatUser && this.activeChatUser.id === e.readerId) {
                                this.messages.forEach(msg => {
                                    if (msg.sender_id === this.myId) {
                                        msg.is_read = true;
                                    }
                                });
                            }
                        });
                } else {
                    setTimeout(() => this.setupEchoListeners(), 500);
                }
            },

            initChat() {
                this.loadContacts();
                this.setupEchoListeners();

                this.$watch('searchQuery', (value) => {
                    if (this.searchTimeout) clearTimeout(this.searchTimeout);
                    if (value.trim() === '') {
                        this.searchResults = [];
                        this.isSearching = false;
                        return;
                    }

                    this.isSearching = true;
                    this.searchTimeout = setTimeout(() => {
                        fetch(`/admin/chat/search?q=${encodeURIComponent(value)}`)
                            .then(res => res.json())
                            .then(data => {
                                this.searchResults = data;
                                this.isSearching = false;
                            });
                    }, 300);
                });

                window.addEventListener('buka-chat', (e) => {
                    const userId = e.detail;
                    this.isOpen = true;

                    fetch(`/admin/chat/contacts`)
                        .then(res => res.json())
                        .then(data => {
                            this.contacts = data;
                            const user = this.contacts.find(c => c.id === userId);
                            if (user) {
                                this.openChat(user);
                            }
                        });
                });
            },

            get totalUnread() {
                return this.contacts.reduce((sum, contact) => sum + contact.unread_count, 0);
            },

            toggleChat() {
                this.isOpen = !this.isOpen;
                if (this.isOpen && this.currentView === 'contacts') {
                    this.loadContacts();
                }
            },

            openSearch() {
                this.currentView = 'search';
                this.searchQuery = '';
                this.searchResults = [];
                setTimeout(() => {
                    const searchInput = this.$el.querySelector('input[type="text"]');
                    if (searchInput) searchInput.focus();
                }, 200);
            },

            loadContacts() {
                this.isLoadingContacts = true;
                fetch('/admin/chat/contacts')
                    .then(res => res.json())
                    .then(data => {
                        this.contacts = data;
                        this.isLoadingContacts = false;
                    });
            },

            openChat(user) {
                this.activeChatUser = user;
                this.currentView = 'room';
                this.messages = [];
                this.isLoadingMessages = true;

                fetch(`/admin/chat/messages/${user.id}`)
                    .then(res => res.json())
                    .then(data => {
                        this.messages = data;
                        this.isLoadingMessages = false;
                        this.scrollToBottom();
                        this.markAsRead(user.id);

                        const contact = this.contacts.find(c => c.id === user.id);
                        if (contact) contact.unread_count = 0;
                    });
            },

            closeChat() {
                this.currentView = 'contacts';
                this.activeChatUser = null;
                this.loadContacts();
            },

            sendMessage() {
                if (!this.newMessage.trim() || this.isSending || !this.activeChatUser) return;

                this.isSending = true;
                const msgText = this.newMessage;
                this.newMessage = '';

                fetch(`/admin/chat/messages/${this.activeChatUser.id}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ message: msgText })
                })
                    .then(res => res.json())
                    .then(data => {
                        this.messages.push(data);
                        this.isSending = false;
                        this.scrollToBottom();
                    })
                    .catch(err => {
                        console.error('Error sending message:', err);
                        this.isSending = false;
                    });
            },

            markAsRead(userId) {
                fetch(`/admin/chat/messages/${userId}/read`, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(() => {
                    window.dispatchEvent(new CustomEvent('chat-dibaca-global', { detail: userId }));
                });
            },

            scrollToBottom() {
                setTimeout(() => {
                    const area = document.getElementById('chatMessagesArea');
                    if (area) {
                        area.scrollTop = area.scrollHeight;
                    }
                }, 100);
            },

            formatTime(dateString) {
                if (!dateString) return '';
                const date = new Date(dateString);
                return date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            }
        }));
    });
</script>