<div x-data="minGapChatbot()" class="relative">

    <button @click="toggleChat()"
        class="fixed bottom-6 right-6 z-50 flex items-center justify-center w-14 h-14 bg-brand-500 hover:bg-brand-600 dark:bg-brand-600 dark:hover:bg-brand-500 rounded-full text-white shadow-lg hover:shadow-brand-500/30 transition-all duration-300 transform hover:scale-105 active:scale-95 focus:outline-none animate-bounce"
        style="animation-duration: 2s;" aria-label="Tanya MinGAP">

        <div class="relative w-6 h-6">
            <span x-show="!terbuka" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 rotate-90 scale-50" x-transition:enter-end="opacity-100 rotate-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 rotate-0 scale-100" x-transition:leave-end="opacity-0 -rotate-90 scale-50" class="absolute inset-0 flex items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                </svg>
            </span>

            <span x-show="terbuka" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 rotate-90 scale-50" x-transition:enter-end="opacity-100 rotate-0 scale-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 rotate-0 scale-100" x-transition:leave-end="opacity-0 -rotate-90 scale-50" class="absolute inset-0 flex items-center justify-center" style="display: none;">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </span>
        </div>

        <span
            class="absolute top-0 right-0 block h-3.5 w-3.5 rounded-full ring-2 ring-white dark:ring-slate-900 bg-emerald-400"></span>
    </button>

    <div x-show="terbuka" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-8 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-8 scale-95"
        class="fixed bottom-24 right-6 w-96 h-[520px] max-w-[calc(100vw-3rem)] z-50 rounded-2xl shadow-2xl border border-stone-200 dark:border-slate-800 bg-white/95 dark:bg-slate-900/95 backdrop-blur flex flex-col overflow-hidden transition-all duration-300"
        style="display: none;">

        <div
            class="bg-brand-500 dark:bg-slate-900 px-4 py-3.5 flex items-center justify-between text-white border-b border-brand-600 dark:border-slate-800 shadow-sm">
            <div class="flex items-center gap-2.5">
                <div class="relative">
                    <img src="{{ asset('images/ikon chat ai.jpeg') }}" alt="MinGAP" class="w-9 h-9 rounded-full object-cover border border-white/20">
                    <span
                        class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full ring-2 ring-brand-500 dark:ring-slate-900 bg-emerald-400 animate-pulse"></span>
                </div>
                <div>
                    <div class="text-xs font-bold tracking-wide">MinGAP (Admin AI)</div>
                    <div class="text-[10px] text-white/70 dark:text-slate-400 flex items-center gap-1 mt-0.5">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                        Aktif Melayani Bandung
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-1">

                <button @click="tampilKonfirmasiHapus()"
                    class="p-1.5 hover:bg-white/10 dark:hover:bg-slate-800 rounded-lg text-white/80 hover:text-white transition"
                    title="Reset Obrolan">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>

                <button @click="toggleChat()"
                    class="p-1.5 hover:bg-white/10 dark:hover:bg-slate-800 rounded-lg text-white/80 hover:text-white transition"
                    title="Tutup Chat">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>


        <div id="minGapMessageContainer" class="flex-1 overflow-y-auto scroll-smooth">

            {{-- Welcome Screen (Gemini/ChatGPT style) --}}
            <div x-show="!adaRiwayatAsli && !sedangMemuat" class="flex flex-col items-center justify-center h-full px-5 py-6 text-center select-none">
                <div class="mb-4">
                    <img src="{{ asset('images/ikon chat ai.jpeg') }}" alt="MinGAP" class="w-16 h-16 rounded-2xl object-cover shadow-lg ring-2 ring-brand-500/20 dark:ring-brand-400/20 mx-auto mingap-welcome-pulse">
                </div>
                <h3 class="text-base font-bold text-stone-900 dark:text-white mb-1">Halo, Warga Bandung! 👋</h3>
                <p class="text-[11px] text-stone-500 dark:text-slate-400 leading-relaxed max-w-[260px] mb-5">Saya <strong class="text-brand-500">MinGAP</strong>, asisten AI SIGAP BDG. Ada yang bisa saya bantu hari ini?</p>

                <div class="grid grid-cols-2 gap-2 w-full max-w-[300px]">
                    <button @click="kirimTemplate('Bagaimana cara membuat laporan di SIGAP BDG? 📝')"
                        class="flex flex-col items-center gap-1.5 p-3 rounded-xl border border-stone-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-brand-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                        <span class="text-lg">📝</span>
                        <span class="text-[10px] font-semibold text-stone-600 dark:text-slate-400 group-hover:text-brand-500 transition">Cara Melapor</span>
                    </button>
                    <button @click="kirimTemplate('Saya mau melacak status laporan saya 🔍')"
                        class="flex flex-col items-center gap-1.5 p-3 rounded-xl border border-stone-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-brand-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                        <span class="text-lg">🔍</span>
                        <span class="text-[10px] font-semibold text-stone-600 dark:text-slate-400 group-hover:text-brand-500 transition">Lacak Laporan</span>
                    </button>
                    <button @click="kirimTemplate('Apa nomor darurat Kota Bandung? 🚨')"
                        class="flex flex-col items-center gap-1.5 p-3 rounded-xl border border-stone-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-brand-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                        <span class="text-lg">🚨</span>
                        <span class="text-[10px] font-semibold text-stone-600 dark:text-slate-400 group-hover:text-brand-500 transition">Darurat 112</span>
                    </button>
                    <button @click="kirimTemplate('Siapa kamu? Jelaskan tentang MinGAP! 🤖')"
                        class="flex flex-col items-center gap-1.5 p-3 rounded-xl border border-stone-200 dark:border-slate-700 bg-white dark:bg-slate-800 hover:border-brand-500 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
                        <span class="text-lg">🤖</span>
                        <span class="text-[10px] font-semibold text-stone-600 dark:text-slate-400 group-hover:text-brand-500 transition">Tentang MinGAP</span>
                    </button>
                </div>
            </div>

            {{-- Chat Messages --}}
            <div x-show="adaRiwayatAsli || sedangMemuat" class="p-4 space-y-4">
                <template x-for="(chat, index) in riwayat" :key="index">
                    <div :class="chat.role === 'user' ? 'flex justify-end' : 'flex justify-start gap-2'">

                        <template x-if="chat.role !== 'user'">
                            <img src="{{ asset('images/ikon chat ai.jpeg') }}" alt="MinGAP" class="w-7 h-7 rounded-full object-cover border border-brand-100 dark:border-slate-700 flex-shrink-0">
                        </template>

                        <div
                            :class="chat.role === 'user' 
                            ? 'bg-brand-500 text-white rounded-2xl rounded-tr-none px-3.5 py-2 text-xs max-w-[80%] shadow-sm' 
                            : 'bg-stone-100 dark:bg-slate-800 text-stone-800 dark:text-slate-100 rounded-2xl rounded-tl-none px-3.5 py-2.5 text-xs max-w-[80%] shadow-sm leading-relaxed border border-stone-200/50 dark:border-slate-700/60'">
                            <div x-html="formatPesan(chat.content)"></div>
                        </div>
                    </div>
                </template>

                <div x-show="sedangMemuat" class="flex justify-start gap-2" style="display: none;">
                    <img src="{{ asset('images/ikon chat ai.jpeg') }}" alt="MinGAP" class="w-7 h-7 rounded-full object-cover border border-brand-100 dark:border-slate-700 flex-shrink-0">
                    <div
                        class="bg-stone-100 dark:bg-slate-800 px-4 py-3 rounded-2xl rounded-tl-none border border-stone-200/50 dark:border-slate-700/60 flex items-center gap-1 shadow-sm">
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 dark:bg-slate-500 animate-bounce"
                            style="animation-delay: 0.1s;"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 dark:bg-slate-500 animate-bounce"
                            style="animation-delay: 0.2s;"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-stone-400 dark:bg-slate-500 animate-bounce"
                            style="animation-delay: 0.3s;"></span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Quick reply bar only shows when in active chat --}}
        <div x-show="adaRiwayatAsli"
            class="px-4 py-2 border-t border-stone-100 dark:border-slate-800 flex gap-1.5 overflow-x-auto whitespace-nowrap bg-stone-50/50 dark:bg-slate-900/50 scrollbar-none select-none">
            <button @click="kirimTemplate('Bagaimana cara membuat laporan di SIGAP BDG? 📝')"
                class="text-[10px] font-semibold bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 hover:border-brand-500 text-stone-600 dark:text-slate-400 hover:text-brand-500 rounded-full px-2.5 py-1 transition flex-shrink-0">
                Cara Melapor 📝
            </button>
            <button @click="kirimTemplate('Saya mau melacak status laporan saya 🔍')"
                class="text-[10px] font-semibold bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 hover:border-brand-500 text-stone-600 dark:text-slate-400 hover:text-brand-500 rounded-full px-2.5 py-1 transition flex-shrink-0">
                Lacak Laporan 🔍
            </button>
            <button @click="kirimTemplate('Apa nomor darurat Kota Bandung? 🚨')"
                class="text-[10px] font-semibold bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 hover:border-brand-500 text-stone-600 dark:text-slate-400 hover:text-brand-500 rounded-full px-2.5 py-1 transition flex-shrink-0">
                Darurat 112 🚨
            </button>
            <button @click="kirimTemplate('Siapa kamu? Jelaskan tentang MinGAP! 🤖')"
                class="text-[10px] font-semibold bg-white dark:bg-slate-800 border border-stone-200 dark:border-slate-700 hover:border-brand-500 text-stone-600 dark:text-slate-400 hover:text-brand-500 rounded-full px-2.5 py-1 transition flex-shrink-0">
                Tentang MinGAP 🤖
            </button>
        </div>

        {{-- Inline Delete Confirmation Overlay --}}
        <div x-show="konfirmasiHapus" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="absolute inset-0 z-50 flex items-center justify-center bg-black/40 dark:bg-black/60 backdrop-blur-sm rounded-2xl"
            style="display: none;">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-2xl border border-stone-200 dark:border-slate-700 p-5 mx-6 max-w-[280px] w-full text-center" @click.outside="konfirmasiHapus = false">
                <div class="w-10 h-10 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center mx-auto mb-3">
                    <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </div>
                <p class="text-sm font-semibold text-stone-800 dark:text-white mb-1">Hapus Obrolan?</p>
                <p class="text-[11px] text-stone-500 dark:text-slate-400 mb-4">Apakah Anda yakin ingin menghapus chat?</p>
                <div class="flex gap-2">
                    <button @click="konfirmasiHapus = false"
                        class="flex-1 text-xs font-semibold py-2 rounded-lg border border-stone-200 dark:border-slate-700 bg-white dark:bg-slate-700 text-stone-600 dark:text-slate-300 hover:bg-stone-50 dark:hover:bg-slate-600 transition">
                        Tidak
                    </button>
                    <button @click="konfirmasiYaHapus()"
                        class="flex-1 text-xs font-semibold py-2 rounded-lg bg-red-500 hover:bg-red-600 text-white transition shadow-sm">
                        Iya
                    </button>
                </div>
            </div>
        </div>

        <form @submit.prevent="kirimPesan()"
            class="p-3 border-t border-stone-100 dark:border-slate-800 flex items-center gap-2 bg-stone-50/50 dark:bg-slate-900/50">
            <input type="text" x-model="pesanBaru" placeholder="Tulis pesan ke MinGAP..."
                class="flex-1 text-xs px-3.5 py-2.5 rounded-full border border-stone-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-stone-800 dark:text-white placeholder-stone-400 focus:outline-none focus:ring-2 focus:ring-brand-500 dark:focus:ring-brand-600 transition"
                :disabled="sedangMemuat">
            <button type="submit"
                class="flex items-center justify-center w-8 h-8 bg-brand-500 hover:bg-brand-600 text-white rounded-full transition shadow-md shadow-brand-500/10 active:scale-95 flex-shrink-0"
                :disabled="sedangMemuat || !pesanBaru.trim()">
                <svg class="w-4 h-4 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>
    </div>
</div>

<script>
    function minGapChatbot() {
        return {
            terbuka: false,
            pesanBaru: '',
            sedangMemuat: false,
            konfirmasiHapus: false,
            riwayat: [],
            csrf: '{{ csrf_token() }}',

            get adaRiwayatAsli() {
                return this.riwayat.length > 0;
            },

            init() {
                fetch('{{ route("chatbot.riwayat") }}')
                    .then(res => res.json())
                    .then(data => {
                        if (data.riwayat && data.riwayat.length > 0) {
                            this.riwayat = data.riwayat;
                        } else {
                            this.riwayat = [];
                        }
                        this.scrollToBottom();
                    })
                    .catch(() => {
                        this.riwayat = [];
                    });
            },

            toggleChat() {
                this.terbuka = !this.terbuka;
                if (this.terbuka) {
                    this.scrollToBottom();
                }
            },

            kirimTemplate(teks) {
                this.pesanBaru = teks;
                this.kirimPesan();
            },

            kirimPesan() {
                const pesan = this.pesanBaru.trim();
                if (!pesan || this.sedangMemuat) return;

                this.riwayat.push({ role: 'user', content: pesan });
                this.pesanBaru = '';
                this.sedangMemuat = true;
                this.scrollToBottom();

                fetch('{{ route("chatbot.kirim") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrf
                    },
                    body: JSON.stringify({ pesan: pesan })
                })
                    .then(res => {
                        if (!res.ok) throw new Error('API Error');
                        return res.json();
                    })
                    .then(data => {
                        this.riwayat = data.riwayat;
                        this.sedangMemuat = false;
                        this.scrollToBottom();
                    })
                    .catch(() => {
                        this.riwayat.push({
                            role: 'assistant',
                            content: 'Waduh, sepertinya jaringan MinGAP sedang terganggu. Mari coba bicara beberapa saat lagi ya, Warga Bandung!'
                        });
                        this.sedangMemuat = false;
                        this.scrollToBottom();
                    });
            },

            tampilKonfirmasiHapus() {
                this.konfirmasiHapus = true;
            },

            konfirmasiYaHapus() {
                this.konfirmasiHapus = false;
                fetch('{{ route("chatbot.reset") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': this.csrf
                    }
                })
                    .then(res => res.json())
                    .then(data => {
                        if (data.sukses) {
                            this.riwayat = [];
                        }
                    });
            },

            scrollToBottom() {
                setTimeout(() => {
                    const container = document.getElementById('minGapMessageContainer');
                    if (container) {
                        container.scrollTop = container.scrollHeight;
                    }
                }, 100);
            },

            formatPesan(content) {
                if (!content) return '';
                let html = content;

                html = html.replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;");

                html = html.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');

                html = html.replace(/\*(.*?)\*/g, '<em>$1</em>');

                html = html.replace(/\n/g, '<br>');

                return html;
            }
        }
    }
</script>

<style>
    #minGapMessageContainer::-webkit-scrollbar {
        width: 4px;
    }

    #minGapMessageContainer::-webkit-scrollbar-track {
        background: transparent;
    }

    #minGapMessageContainer::-webkit-scrollbar-thumb {
        background: rgba(156, 163, 175, 0.3);
        border-radius: 9999px;
    }

    #minGapMessageContainer::-webkit-scrollbar-thumb:hover {
        background: rgba(156, 163, 175, 0.5);
    }

    .scrollbar-none::-webkit-scrollbar {
        display: none;
    }

    .scrollbar-none {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    @keyframes mingapPulse {
        0%, 100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(249, 115, 22, 0.3); }
        50% { transform: scale(1.05); box-shadow: 0 0 0 8px rgba(249, 115, 22, 0); }
    }
    .mingap-welcome-pulse {
        animation: mingapPulse 2.5s ease-in-out infinite;
    }
</style>