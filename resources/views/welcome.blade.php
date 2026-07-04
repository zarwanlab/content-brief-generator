<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.title') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Vazirmatn:wght@300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
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
        /* Custom Tooltip */
        [data-tooltip] {
            position: relative;
        }
        [data-tooltip]:before {
            content: attr(data-tooltip);
            position: absolute;
            bottom: 100%;
            left: 50%;
            transform: translateX(-50%) translateY(-5px);
            padding: 5px 10px;
            background: #0f172a;
            color: white;
            font-size: 10px;
            font-weight: bold;
            border-radius: 8px;
            white-space: nowrap;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s ease;
            z-index: 60;
        }
        [data-tooltip]:hover:before {
            opacity: 1;
            visibility: visible;
            transform: translateX(-50%) translateY(-10px);
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
            </div>
        </div>
    </nav>

    <main class="max-w-4xl mx-auto px-4 py-8 md:py-12">
        <header class="text-center mb-8 md:mb-12">
            <h2 class="text-2xl md:text-5xl font-black text-slate-900 mb-4 leading-tight">
                {!! __('messages.header_title') !!}
            </h2>
            <p class="text-slate-500 text-base md:text-lg max-w-2xl mx-auto px-2">
                {{ __('messages.header_desc') }}
            </p>
        </header>

        <section class="bg-white rounded-3xl md:rounded-[2.5rem] border border-slate-200 p-4 md:p-10 shadow-2xl shadow-blue-100/50 mb-10 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-50 rounded-full blur-3xl -mr-32 -mt-32 opacity-50"></div>
            
            <form id="briefForm" class="relative z-10 space-y-5 md:space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 md:gap-6">
                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs md:text-sm font-black text-slate-700 mx-2">{{ __('messages.form_keyword') }}</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 {{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'right-4' : 'left-4' }} flex items-center text-slate-400">
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </span>
                            <input type="text" name="keyword" required placeholder="{{ __('messages.form_keyword_placeholder') }}"
                                class="w-full {{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'pr-11 md:pr-12 pl-4' : 'pl-11 md:pl-12 pr-4' }} py-3.5 md:py-4 bg-[#F8FAFC] border-2 border-slate-100 rounded-xl md:rounded-2xl focus:border-[#0D47A1] focus:bg-white outline-none transition-all font-bold text-slate-900 text-sm md:text-base">
                        </div>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs md:text-sm font-black text-slate-700 mx-2">{{ __('messages.form_language') }}</label>
                        <select name="language" class="w-full px-4 py-3.5 md:py-4 bg-[#F8FAFC] border-2 border-slate-100 rounded-xl md:rounded-2xl focus:border-[#0D47A1] outline-none transition-all font-bold text-sm md:text-base">
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


                    <div class="space-y-2 md:col-span-2">
                        <label class="text-xs md:text-sm font-black text-slate-700 mx-2">{{ __('messages.form_description') }}</label>
                        <textarea name="description" rows="3" placeholder="{{ __('messages.form_description_placeholder') }}"
                            class="w-full px-4 py-3.5 md:py-4 bg-[#F8FAFC] border-2 border-slate-100 rounded-xl md:rounded-2xl focus:border-[#0D47A1] outline-none transition-all font-bold text-sm md:text-base"></textarea>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="submit" id="submitBtn"
                        class="w-full md:w-2/3 py-4 md:py-5 bg-gradient-to-r from-[#0D47A1] to-[#00BCD4] text-white rounded-xl md:rounded-2xl font-black text-base md:text-lg shadow-xl shadow-blue-200 hover:shadow-2xl hover:scale-[1.01] active:scale-[0.99] transition-all flex items-center justify-center gap-3">
                        <span>{{ __('messages.btn_generate') }}</span>
                        <i class="fa-solid fa-wand-magic-sparkles animate-pulse"></i>
                    </button>
                </div>
            </form>
        </section>

        <div id="loadingState" class="hidden mb-12 space-y-8 py-8 md:py-10">
            <div class="text-center space-y-4 mb-8">
                <div class="inline-flex relative">
                    <div class="w-14 h-14 md:w-16 md:h-16 border-4 border-blue-100 border-t-[#0D47A1] rounded-full animate-spin"></div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <i class="fa-solid fa-robot text-[#0D47A1] text-lg md:text-xl animate-bounce"></i>
                    </div>
                </div>
                <p class="text-slate-500 font-bold text-sm md:text-base animate-pulse">{{ __('messages.loading_text') }}</p>
            </div>
            
            <!-- Skeleton Screen -->
            <div class="space-y-5 md:space-y-6 opacity-40">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-6">
                    <div class="md:col-span-2 h-28 md:h-32 bg-slate-200 rounded-2xl md:rounded-[2rem] animate-pulse"></div>
                    <div class="h-28 md:h-32 bg-slate-200 rounded-2xl md:rounded-[2rem] animate-pulse"></div>
                </div>
                <div class="h-20 md:h-24 bg-slate-200 rounded-2xl md:rounded-[2rem] animate-pulse"></div>
                <div class="h-56 md:h-64 bg-slate-200 rounded-3xl md:rounded-[2.5rem] animate-pulse"></div>
            </div>
        </div>

        <div id="resultsArea" class="hidden space-y-6 md:space-y-8 animate-fade-in mb-12 md:mb-16">
            <div class="flex flex-col md:flex-row items-center justify-between gap-4 mb-4 md:mb-6">
                <h3 class="text-xl md:text-2xl font-black text-slate-900">{{ __('messages.results_title') }}</h3>
                <div class="flex gap-2 w-full md:w-auto">
                    <button id="copyBtn" data-tooltip="{{ __('messages.btn_copy') }}" class="flex-1 md:flex-none px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                        <i class="fa-regular fa-copy text-[#0D47A1]"></i>
                        {{ __('messages.btn_copy') }}
                    </button>
                </div>
            </div>

            <div id="briefContent" class="space-y-6 md:space-y-8">
                <!-- H1 & Meta -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-5 md:gap-6">
                    <div class="md:col-span-2 bg-white p-5 md:p-6 rounded-2xl md:rounded-[2rem] border border-slate-100 shadow-sm relative group">
                        <label class="text-[9px] md:text-[10px] font-black text-[#0D47A1] uppercase mb-1 md:mb-2 block">{{ __('messages.out_h1') }}</label>
                        <h1 id="outH1" class="text-xl md:text-2xl font-black text-slate-900 leading-tight"></h1>
                        <button onclick="copyElementText('outH1')" class="absolute top-4 {{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'left-4' : 'right-4' }} opacity-0 md:group-hover:opacity-100 transition-all text-slate-400 hover:text-[#0D47A1]">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                    <div class="bg-[#0D47A1] text-white p-5 md:p-6 rounded-2xl md:rounded-[2rem] shadow-xl shadow-blue-200">
                        <label class="text-[9px] md:text-[10px] font-black text-blue-100 uppercase mb-1 md:mb-2 block">{{ __('messages.out_target') }}</label>
                        <div id="outTarget" class="text-lg md:text-xl font-black"></div>
                    </div>
                </div>

                <div class="bg-white p-5 md:p-6 rounded-2xl md:rounded-[2rem] border border-slate-100 shadow-sm relative group">
                    <label class="text-[9px] md:text-[10px] font-black text-[#0D47A1] uppercase mb-1 md:mb-2 block">{{ __('messages.out_meta') }}</label>
                    <p id="outMeta" class="text-slate-600 leading-relaxed font-medium text-sm md:text-base"></p>
                    <button onclick="copyElementText('outMeta')" class="absolute top-4 {{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'left-4' : 'right-4' }} opacity-0 md:group-hover:opacity-100 transition-all text-slate-400 hover:text-[#0D47A1]">
                        <i class="fa-regular fa-copy"></i>
                    </button>
                </div>

                <!-- Structure -->
                <div class="bg-white rounded-3xl md:rounded-[2.5rem] border border-slate-200 overflow-hidden shadow-sm">
                    <div class="bg-slate-50 px-5 md:px-8 py-4 md:py-5 border-b border-slate-100 flex items-center justify-between">
                        <span class="font-black text-sm md:text-base text-slate-900">{{ __('messages.out_structure') }}</span>
                        <div class="flex items-center gap-3 md:gap-4">
                            <button onclick="copyElementText('outStructure')" class="text-[10px] md:text-xs font-bold text-slate-400 hover:text-[#0D47A1] flex items-center gap-1">
                                <i class="fa-regular fa-copy"></i>
                                {{ __('messages.btn_copy') }}
                            </button>
                            <i class="fa-solid fa-list-ul text-slate-400 text-sm md:text-base"></i>
                        </div>
                    </div>
                    <div id="outStructure" class="p-5 md:p-8 space-y-5 md:space-y-6">
                        <!-- Headings will be injected here -->
                    </div>
                </div>

                <!-- LSI & FAQ -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                    <div class="bg-white p-5 md:p-6 rounded-3xl md:rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                        <h4 class="font-black text-sm md:text-base text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-key text-amber-500"></i>
                            {{ __('messages.out_lsi') }}
                        </h4>
                        <div id="outLSI" class="flex flex-wrap gap-2">
                            <!-- Keywords -->
                        </div>
                    </div>
                    <div class="bg-white p-5 md:p-6 rounded-3xl md:rounded-[2.5rem] border border-slate-200 shadow-sm overflow-hidden">
                        <h4 class="font-black text-sm md:text-base text-slate-900 mb-4 flex items-center gap-2">
                            <i class="fa-solid fa-circle-question text-[#00BCD4]"></i>
                            {{ __('messages.out_faq') }}
                        </h4>
                        <div id="outFAQ" class="space-y-4">
                            <!-- FAQs -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-white border-t border-slate-100 py-12">
        <div class="max-w-6xl mx-auto px-4 text-center">
            <p class="text-slate-400 text-sm font-medium">{{ __('messages.footer_made_with') }} <i class="fa-solid fa-heart text-rose-500 mx-1"></i> <a href="https://zarwan.co" target="_blank" class="text-[#0D47A1] font-black hover:text-[#00BCD4] transition-colors">Zarwan</a></p>
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

            // Smooth scroll to loading state with offset
            setTimeout(() => {
                const yOffset = -150; // Stop 150px above the element
                const y = loadingState.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }, 100);

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
                div.className = 'bg-white p-4 rounded-2xl border border-slate-100 shadow-sm hover:shadow-md transition-all cursor-pointer group relative';
                div.innerHTML = `
                    <div class="flex items-center justify-between" onclick="renderResults(${JSON.stringify(item.data).replace(/"/g, '&quot;')}, '${item.keyword}')">
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
                    <button onclick="deleteRecentItem(event, ${item.id})" class="absolute top-2 {{ in_array(app()->getLocale(), ['fa', 'ar']) ? 'left-2' : 'right-2' }} w-6 h-6 bg-rose-50 text-rose-500 rounded-full opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center hover:bg-rose-500 hover:text-white" title="{{ __('messages.delete_item') }}">
                        <i class="fa-solid fa-times text-[10px]"></i>
                    </button>
                `;
                recentBriefsList.appendChild(div);
            });
        }

        function deleteRecentItem(e, id) {
            e.stopPropagation();
            let recents = JSON.parse(localStorage.getItem('recent_briefs') || '[]');
            recents = recents.filter(r => r.id !== id);
            localStorage.setItem('recent_briefs', JSON.stringify(recents));
            renderRecentBriefs();
            showToast('{{ __("messages.delete_item") }}');
        }

        function clearRecentBriefs() {
            if (confirm('{{ __("messages.confirm_delete_history") }}')) {
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
                div.className = 'border-r-4 border-blue-500 pr-3 md:pr-4 py-1.5 md:py-2';
                div.innerHTML = `
                    <div class="flex items-center gap-2 mb-1">
                        <h5 class="font-black text-slate-900 text-sm md:text-base">${item.heading}</h5>
                        <span class="text-[9px] md:text-[10px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded-md font-black border border-blue-100">${item.tag || 'H2'}</span>
                    </div>
                    <p class="text-slate-500 text-xs md:text-sm font-medium leading-relaxed">${item.description}</p>
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
                div.className = 'bg-slate-50 p-4 rounded-xl md:rounded-2xl';
                div.innerHTML = `
                    <p class="font-black text-slate-900 text-xs md:text-sm mb-1">{{ in_array(app()->getLocale(), ['fa', 'ar']) ? '؟' : '?' }} ${item.question}</p>
                    <p class="text-slate-600 text-[11px] md:text-xs leading-relaxed font-medium">${item.answer}</p>
                `;
                faqContainer.appendChild(div);
            });

            // Scroll to results
            setTimeout(() => {
                const yOffset = -100; // Stop 100px above the results
                const y = resultsArea.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });
            }, 100);
        }

        // Copy Feature
        document.getElementById('copyBtn').addEventListener('click', () => {
            const h1 = document.getElementById('outH1').innerText;
            const target = document.getElementById('outTarget').innerText;
            const meta = document.getElementById('outMeta').innerText;
            
            let structure = "";
            document.querySelectorAll('#outStructure > div').forEach(div => {
                const heading = div.querySelector('h5').innerText;
                const tag = div.querySelector('span').innerText;
                const desc = div.querySelector('p').innerText;
                structure += `- [${tag}] ${heading}\n  ${desc}\n\n`;
            });

            let lsi = "";
            document.querySelectorAll('#outLSI > span').forEach(span => {
                lsi += `- ${span.innerText}\n`;
            });

            let faq = "";
            document.querySelectorAll('#outFAQ > div').forEach(div => {
                const q = div.querySelector('p:first-child').innerText;
                const a = div.querySelector('p:last-child').innerText;
                faq += `${q}\n${a}\n\n`;
            });

            const fullText = `
${target}
====================
H1: ${h1}
Meta Description: ${meta}

Structure:
--------------------
${structure}

LSI Keywords:
--------------------
${lsi}

FAQ:
--------------------
${faq}
            `.trim();

            copyToClipboard(fullText);
        });

        function copyToClipboard(text) {
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    showToast('{{ __("messages.copy_success") }}');
                }).catch(err => {
                    console.error('Clipboard error:', err);
                    fallbackCopyTextToClipboard(text);
                });
            } else {
                fallbackCopyTextToClipboard(text);
            }
        }

        function fallbackCopyTextToClipboard(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            textArea.style.left = "-9999px";
            textArea.style.top = "0";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            try {
                const successful = document.execCommand('copy');
                if (successful) {
                    showToast('{{ __("messages.copy_success") }}');
                }
            } catch (err) {
                console.error('Fallback copy error:', err);
            }
            document.body.removeChild(textArea);
        }

        function copyElementText(id) {
            const text = document.getElementById(id).innerText;
            copyToClipboard(text);
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
    </script>
</body>
</html>
