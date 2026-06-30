<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    
    <style>
        body {
            font-family: 'Vazirmatn', sans-serif;
            background: radial-gradient(circle at top left, #F8FAFC, #eff6ff);
        }
        .glass {
            background: rgba(248, 250, 252, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out forwards;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .step-card:hover {
            transform: translateY(-5px);
            transition: all 0.3s ease;
        }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #F8FAFC; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        
        :root {
            --primary-color: #0D47A1;
            --secondary-color: #00BCD4;
            --bg-white: #F8FAFC;
        }

        /* Adjustments for LTR */
        [dir="ltr"] .border-r-4 {
            border-right-width: 0;
            border-left-width: 4px;
            padding-right: 0;
            padding-left: 1rem;
        }
    </style>
</head>
<body class="min-h-screen text-slate-800 bg-[#F8FAFC]">

    <nav class="sticky top-0 z-50 glass border-b border-slate-200">
        <div class="max-w-6xl mx-auto px-4 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="bg-[#0D47A1] text-white p-2.5 rounded-2xl shadow-lg shadow-blue-200">
                    <i class="fa-solid fa-pen-nib text-xl"></i>
                </div>
                <div>
                    <h1 class="text-xl font-black text-slate-900">{{ __('messages.title') }}</h1>
                    <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider">{{ __('messages.subtitle') }}</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="relative group">
                    <button class="flex items-center gap-2 px-3 py-2 bg-white border border-slate-200 rounded-xl text-xs font-bold hover:bg-slate-50 transition-all">
                        <i class="fa-solid fa-globe text-blue-600"></i>
                        <span>{{ __('messages.lang_' . app()->getLocale()) }}</span>
                        <i class="fa-solid fa-chevron-down text-[10px] text-slate-400"></i>
                    </button>
                    <div class="absolute {{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'left-0' : 'right-0' }} mt-2 w-32 bg-white border border-slate-200 rounded-xl shadow-xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50">
                        <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 {{ app()->getLocale() == 'en' ? 'text-blue-600' : '' }}">{{ __('messages.lang_en') }}</a>
                        <a href="{{ route('lang.switch', 'fa') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 {{ app()->getLocale() == 'fa' ? 'text-blue-600' : '' }}">{{ __('messages.lang_fa') }}</a>
                        <a href="{{ route('lang.switch', 'ar') }}" class="block px-4 py-2 text-xs font-bold hover:bg-slate-50 {{ app()->getLocale() == 'ar' ? 'text-blue-600' : '' }}">{{ __('messages.lang_ar') }}</a>
                    </div>
                </div>
                <span class="hidden md:inline-flex text-xs font-bold text-slate-500 bg-slate-100 px-3 py-1.5 rounded-full">v1.0.0</span>
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-12">
        <header class="text-center mb-12">
            <h2 class="text-3xl md:text-5xl font-black text-slate-900 mb-4 leading-tight">
                {!! __('messages.header_title') !!}
            </h2>
            <p class="text-slate-500 text-lg max-w-2xl mx-auto">
                {{ __('messages.header_desc') }}
            </p>
        </header>

        <section class="bg-white rounded-[2.5rem] border border-slate-200 p-6 md:p-10 shadow-2xl shadow-blue-100/50 mb-12 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl -mr-32 -mt-32 opacity-50"></div>
            
            <form id="briefForm" class="relative z-10 space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-sm font-black text-slate-700 mx-2">{{ __('messages.form_keyword') }}</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 {{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'right-4' : 'left-4' }} flex items-center text-slate-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="keyword" required placeholder="{{ __('messages.form_keyword_placeholder') }}"
                                class="w-full {{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'pr-12 pl-4' : 'pl-12 pr-4' }} py-4 bg-[#F8FAFC] border-2 border-slate-100 rounded-2xl focus:border-[#0D47A1] focus:bg-white outline-none transition-all font-bold text-slate-900">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-black text-slate-700 mx-2">{{ __('messages.form_language') }}</label>
                        <select name="language" class="w-full px-4 py-4 bg-[#F8FAFC] border-2 border-slate-100 rounded-2xl focus:border-[#0D47A1] outline-none transition-all font-bold">
                            <option value="fa">فارسی (Persian) - IR</option>
                            <option value="en">انگلیسی (English) - US</option>
                            <option value="en-GB">English (United Kingdom) - UK</option>
                            <option value="ar">العربية (Arabic) - SA</option>
                            <option value="ar-AE">العربية (Arabic) - UAE</option>
                            <option value="de">Deutsch (German) - DE</option>
                            <option value="es">Español (Spanish) - ES</option>
                            <option value="fr">Français (French) - FR</option>
                            <option value="ru">Русский (Russian) - RU</option>
                            <option value="zh">中文 (Chinese) - CN</option>
                            <option value="ja">日本語 (Japanese) - JP</option>
                            <option value="tr">Türkçe (Turkish) - TR</option>
                            <option value="it">Italiano (Italian) - IT</option>
                            <option value="pt">Português (Portuguese) - BR</option>
                            <option value="hi">हिन्दी (Hindi) - IN</option>
                            <option value="ur">اردو (Urdu) - PK</option>
                            <option value="nl">Nederlands (Dutch) - NL</option>
                            <option value="sv">Svenska (Swedish) - SE</option>
                            <option value="pl">Polski (Polish) - PL</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-black text-slate-700 mx-2">{{ __('messages.form_competitors') }}</label>
                        <input type="text" name="competitors" placeholder="{{ __('messages.form_competitors_placeholder') }}"
                            class="w-full px-4 py-4 bg-[#F8FAFC] border-2 border-slate-100 rounded-2xl focus:border-[#0D47A1] outline-none transition-all font-bold">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-sm font-black text-slate-700 mx-2">{{ __('messages.form_description') }}</label>
                        <textarea name="description" rows="3" placeholder="{{ __('messages.form_description_placeholder') }}"
                            class="w-full px-4 py-4 bg-[#F8FAFC] border-2 border-slate-100 rounded-2xl focus:border-[#0D47A1] outline-none transition-all font-bold"></textarea>
                    </div>
                </div>

                <button type="submit" id="submitBtn"
                    class="w-full py-5 bg-gradient-to-r from-[#0D47A1] to-[#00BCD4] text-white rounded-2xl font-black text-lg shadow-xl shadow-blue-200 hover:shadow-2xl hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-3">
                    <span>{{ __('messages.btn_generate') }}</span>
                    <i class="fa-solid fa-wand-magic-sparkles animate-pulse"></i>
                </button>
            </form>
        </section>

        <!-- Recent Briefs Section -->
        <section id="recentBriefsSection" class="hidden mb-12">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-xl font-black text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-clock-rotate-left text-blue-600"></i>
                    {{ __('messages.recent_briefs') }}
                </h3>
                <button onclick="clearRecentBriefs()" class="text-xs font-bold text-rose-500 hover:text-rose-700 transition-colors">
                    {{ __('messages.clear_history') }}
                </button>
            </div>
            <div id="recentBriefsList" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Recent items injected here -->
            </div>
        </section>

        <div id="loadingState" class="hidden mb-12 space-y-8 py-10">
            <div class="text-center space-y-4 mb-8">
                <div class="inline-flex relative">
                    <div class="w-16 h-16 border-4 border-blue-100 border-t-[#0D47A1] rounded-full animate-spin"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fa-solid fa-robot text-[#0D47A1] animate-bounce"></i>
                    </div>
                </div>
                <p class="text-slate-500 font-bold animate-pulse">{{ __('messages.loading_text') }}</p>
            </div>
            
            <!-- Skeleton Screen -->
            <div class="space-y-6 opacity-40">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 h-32 bg-slate-200 rounded-[2rem] animate-pulse"></div>
                    <div class="h-32 bg-slate-200 rounded-[2rem] animate-pulse"></div>
                </div>
                <div class="h-24 bg-slate-200 rounded-[2rem] animate-pulse"></div>
                <div class="h-64 bg-slate-200 rounded-[2.5rem] animate-pulse"></div>
            </div>
        </div>

        <div id="resultsArea" class="hidden space-y-8 animate-fade-in">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-6">
                <h3 class="text-2xl font-black text-slate-900">{{ __('messages.results_title') }}</h3>
                <div class="flex gap-2">
                    <button id="copyBtn" class="px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold hover:bg-slate-50 transition-all flex items-center gap-2">
                        <i class="fa-regular fa-copy text-[#0D47A1]"></i>
                        {{ __('messages.btn_copy') }}
                    </button>
                    <button id="downloadPdfBtn" class="px-4 py-2.5 bg-slate-900 text-white rounded-xl text-xs font-bold hover:bg-slate-800 transition-all flex items-center gap-2">
                        <i class="fa-solid fa-file-pdf text-rose-500"></i>
                        {{ __('messages.btn_download_pdf') }}
                    </button>
                </div>
            </div>

            <div id="briefContent" class="space-y-8">
                <!-- H1 & Meta -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-2 bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative group">
                        <label class="text-[10px] font-black text-[#0D47A1] uppercase mb-2 block">{{ __('messages.out_h1') }}</label>
                        <h1 id="outH1" class="text-2xl font-black text-slate-900"></h1>
                        <button onclick="copyElementText('outH1')" class="absolute top-4 {{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'left-4' : 'right-4' }} opacity-0 group-hover:opacity-100 transition-all text-slate-400 hover:text-[#0D47A1]">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                    <div class="bg-[#0D47A1] text-white p-6 rounded-[2rem] shadow-xl shadow-blue-200">
                        <label class="text-[10px] font-black text-blue-100 uppercase mb-2 block">{{ __('messages.out_target') }}</label>
                        <div id="outTarget" class="text-xl font-black"></div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm relative group">
                    <label class="text-[10px] font-black text-[#0D47A1] uppercase mb-2 block">{{ __('messages.out_meta') }}</label>
                    <p id="outMeta" class="text-slate-600 leading-relaxed font-medium"></p>
                    <button onclick="copyElementText('outMeta')" class="absolute top-4 {{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'left-4' : 'right-4' }} opacity-0 group-hover:opacity-100 transition-all text-slate-400 hover:text-[#0D47A1]">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>

                <!-- Structure -->
                <div class="bg-white rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-sm">
                    <div class="bg-slate-50 px-8 py-5 border-b border-slate-100 flex items-center justify-between">
                        <span class="font-black text-slate-900">{{ __('messages.out_structure') }}</span>
                        <div class="flex items-center gap-4">
                            <button onclick="copyElementText('outStructure')" class="text-xs font-bold text-slate-400 hover:text-[#0D47A1] flex items-center gap-1">
                                <i class="fa-regular fa-copy"></i>
                                {{ __('messages.btn_copy') }}
                            </button>
                            <i class="fa-solid fa-list-ul text-slate-400"></i>
                        </div>
                    </div>
                    <div id="outStructure" class="p-8 space-y-6">
                        <!-- Headings will be injected here -->
                    </div>
                </div>

                <!-- LSI & FAQ -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm">
                        <h4 class="font-black text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-key text-amber-500"></i>
                            {{ __('messages.out_lsi') }}
                        </h4>
                        <div id="outLSI" class="flex flex-wrap gap-2">
                            <!-- Keywords -->
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-[2.5rem] border border-slate-200 shadow-sm">
                        <h4 class="font-black text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-circle-question text-[#00BCD4]"></i>
                            {{ __('messages.out_faq') }}
                        </h4>
                        <div id="outFAQ" class="space-y-4">
                            <!-- FAQs -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gradient-to-br from-[#0D47A1] to-[#00BCD4] p-8 rounded-[2.5rem] text-center text-white shadow-2xl shadow-blue-200 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full blur-2xl -mr-16 -mt-16"></div>
                <h4 class="text-xl font-black mb-2">{{ __('messages.ready_to_write') }}</h4>
                <p class="text-blue-50 mb-6 font-medium">{{ __('messages.ready_to_write_desc') }}</p>
                <button onclick="window.print()" class="px-8 py-4 bg-white text-[#0D47A1] rounded-2xl font-black shadow-lg hover:bg-blue-50 transition-all">
                    {{ __('messages.btn_download_brief') }}
                </button>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-100 py-12">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-slate-400 text-sm font-medium">{{ __('messages.footer_made_with') }} <i class="fa-solid fa-heart text-rose-500 mx-1"></i> <a href="https://zarwan.co" target="_blank" class="text-[#0D47A1] font-black hover:text-[#00BCD4] transition-colors">زروان</a></p>
        </div>
    </footer>

    <script>
        const briefForm = document.getElementById('briefForm');
        const submitBtn = document.getElementById('submitBtn');
        const loadingState = document.getElementById('loadingState');
        const resultsArea = document.getElementById('resultsArea');
        const recentBriefsSection = document.getElementById('recentBriefsSection');
        const recentBriefsList = document.getElementById('recentBriefsList');

        // Load recent briefs on init
        document.addEventListener('DOMContentLoaded', () => {
            renderRecentBriefs();
        });

        briefForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(briefForm);
            const data = Object.fromEntries(formData.entries());

            // UI State
            briefForm.style.opacity = '0.5';
            briefForm.style.pointerEvents = 'none';
            submitBtn.disabled = true;
            loadingState.classList.remove('hidden');
            resultsArea.classList.add('hidden');
            recentBriefsSection.classList.add('hidden');

            try {
                const response = await fetch('{{ route("brief.generate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                });

                const result = await response.json();

                if (response.ok) {
                    saveToRecent(result, data.keyword);
                    renderResults(result, data.keyword);
                } else {
                    alert('Error: ' + (result.error || 'Unknown error'));
                }
            } catch (error) {
                alert('System Error: ' + error.message);
            } finally {
                briefForm.style.opacity = '1';
                briefForm.style.pointerEvents = 'all';
                submitBtn.disabled = false;
                loadingState.classList.add('hidden');
                renderRecentBriefs();
            }
        });

        function saveToRecent(brief, keyword) {
            let recents = JSON.parse(localStorage.getItem('recent_briefs') || '[]');
            const newEntry = {
                id: Date.now(),
                keyword: keyword,
                data: brief,
                date: new Date().toLocaleDateString(undefined, { month: 'short', day: 'numeric' })
            };
            // Keep only last 6
            recents = [newEntry, ...recents.filter(r => r.keyword !== keyword)].slice(0, 6);
            localStorage.setItem('recent_briefs', JSON.stringify(recents));
        }

        function renderRecentBriefs() {
            const recents = JSON.parse(localStorage.getItem('recent_briefs') || '[]');
            if (recents.length === 0) {
                recentBriefsSection.classList.add('hidden');
                return;
            }

            recentBriefsSection.classList.remove('hidden');
            recentBriefsList.innerHTML = '';

            recents.forEach(item => {
                const div = document.createElement('div');
                div.className = 'bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all cursor-pointer group';
                div.onclick = () => renderResults(item.data, item.keyword);
                div.innerHTML = `
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center text-xs">
                                <i class="fa-solid fa-file-lines"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-slate-900 group-hover:text-blue-600 transition-colors">${item.keyword}</h4>
                                <p class="text-[10px] text-slate-400 font-bold uppercase">${item.date}</p>
                            </div>
                        </div>
                        <i class="fa-solid fa-chevron-{{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'left' : 'right' }} text-[10px] text-slate-300 group-hover:translate-x-{{ in_array(app()->getLocale(), ['fa', 'ar']) ? '-2' : '2' }} transition-transform"></i>
                    </div>
                `;
                recentBriefsList.appendChild(div);
            });
        }

        function clearRecentBriefs() {
            if (confirm('Are you sure you want to clear your history?')) {
                localStorage.removeItem('recent_briefs');
                renderRecentBriefs();
            }
        }

        function renderResults(data, keyword) {
            resultsArea.classList.remove('hidden');
            
            document.getElementById('outH1').textContent = data.h1_title;
            document.getElementById('outTarget').textContent = keyword;
            document.getElementById('outMeta').textContent = data.meta_description;

            // Structure
            const structureContainer = document.getElementById('outStructure');
            structureContainer.innerHTML = '';
            data.structure.forEach(item => {
                const div = document.createElement('div');
                div.className = 'border-r-4 border-blue-500 pr-4 py-2';
                div.innerHTML = `
                    <h5 class="font-black text-slate-900 mb-1">${item.heading}</h5>
                    <p class="text-slate-500 text-sm font-medium leading-relaxed">${item.description}</p>
                `;
                structureContainer.appendChild(div);
            });

            // LSI
            const lsiContainer = document.getElementById('outLSI');
            lsiContainer.innerHTML = '';
            data.lsi_keywords.forEach(kw => {
                const span = document.createElement('span');
                span.className = 'px-3 py-1.5 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold';
                span.textContent = kw;
                lsiContainer.appendChild(span);
            });

            // FAQ
            const faqContainer = document.getElementById('outFAQ');
            faqContainer.innerHTML = '';
            data.faq.forEach(item => {
                const div = document.createElement('div');
                div.className = 'bg-slate-50 p-4 rounded-2xl';
                div.innerHTML = `
                    <p class="font-black text-slate-900 text-sm mb-1">{{ in_array(app()->getLocale(), ['fa', 'ar']) ? '؟' : '?' }} ${item.question}</p>
                    <p class="text-slate-600 text-xs leading-relaxed font-medium">${item.answer}</p>
                `;
                faqContainer.appendChild(div);
            });

            // Scroll to results
            resultsArea.scrollIntoView({ behavior: 'smooth' });
        }

        // Copy Feature
        document.getElementById('copyBtn').addEventListener('click', () => {
            const content = document.getElementById('briefContent').innerText;
            navigator.clipboard.writeText(content).then(() => {
                showToast('{{ __("messages.copy_success") }}');
            });
        });

        function copyElementText(id) {
            const text = document.getElementById(id).innerText;
            navigator.clipboard.writeText(text).then(() => {
                showToast('{{ __("messages.copy_success") }}');
            });
        }

        function showToast(message) {
            // Simple toast notification
            const toast = document.createElement('div');
            toast.className = 'fixed bottom-8 right-8 bg-slate-900 text-white px-6 py-4 rounded-3xl shadow-2xl z-[100] animate-fade-in flex items-center gap-3 border border-slate-800';
            toast.innerHTML = `<i class="fa-solid fa-check-circle text-emerald-400 text-lg"></i><span class="font-bold text-sm">${message}</span>`;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(10px)';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        // PDF Download (Using window.print for simplicity and better RTL support, but providing a hook)
        document.getElementById('downloadPdfBtn').addEventListener('click', () => {
            window.print();
        });
    </script>
</body>
</html>
