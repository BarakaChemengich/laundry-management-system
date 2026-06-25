<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WashEase Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-50 font-sans text-slate-800 antialiased">

    <div class="flex min-h-screen">
        
        <aside class="w-64 bg-white border-r border-slate-100 flex flex-col shrink-0">
            <div class="p-6 flex items-center gap-3">
                <div class="bg-blue-600 text-white p-2 rounded-xl shadow-md shadow-blue-200">
                    <i class="fa-solid fa-shirt text-lg"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold text-slate-900 tracking-tight">WashEase</h1>
                    <p class="text-xs text-slate-400 font-medium">Clean clothes, easy life.</p>
                </div>
            </div>

            <nav class="flex-1 px-4 py-3 space-y-1" id="sidebar-nav">
                <a href="#" data-page="home" class="nav-item flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl bg-blue-50 text-blue-600 transition">
                    <i class="fa-solid fa-house text-base"></i> Home
                </a>
                <a href="#" data-page="new-order" class="nav-item flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition">
                    <i class="fa-solid fa-circle-plus text-base"></i> New Order
                </a>
                <a href="#" data-page="orders" class="nav-item flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition">
                    <i class="fa-solid fa-list-check text-base"></i> Orders
                </a>
                <a href="#" data-page="wallet" class="nav-item flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition">
                    <i class="fa-solid fa-wallet text-base"></i> Wallet
                </a>
                <a href="#" data-page="settings" class="nav-item flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition">
                    <i class="fa-solid fa-gear text-base"></i> Settings
                </a>
            </nav>

            <div class="p-4 m-4 bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl border border-blue-100">
                <div class="flex items-center gap-3 mb-2">
                    <span class="text-xl">🎁</span>
                    <h4 class="text-sm font-bold text-slate-900">Refer & Earn</h4>
                </div>
                <p class="text-xs text-slate-500 leading-relaxed">Invite friends and earn KSh 200 credit automatically.</p>
            </div>
        </aside>

        <div class="flex-1 flex flex-col min-w-0">
            
            <header class="bg-white border-b border-slate-100 h-16 flex items-center justify-between px-8 shrink-0">
                <div class="flex items-center gap-2 text-sm font-medium text-slate-600">
                    <i class="fa-solid fa-location-dot text-blue-600"></i>
                    <span>Deliver to: <strong class="text-slate-900 font-semibold">H&B Apartments, Nairobi</strong></span>
                    <i class="fa-solid fa-chevron-down text-xs ml-1 text-slate-400"></i>
                </div>

                <div class="w-full max-w-md mx-8 relative">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" placeholder="Search services, laundrymats, offers..." class="w-full pl-11 pr-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-sm focus:outline-none focus:border-blue-500 transition">
                </div>

                <div class="flex items-center gap-6">
                    <button class="relative text-slate-400 hover:text-slate-600">
                        <i class="fa-solid fa-bell text-xl"></i>
                        <span class="absolute -top-1 -right-1 bg-blue-600 text-white size-4 rounded-full text-[10px] flex items-center justify-center font-bold">2</span>
                    </button>
                    <div class="flex items-center gap-3 border-l border-slate-100 pl-6">
                        <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=100" alt="Michelle Profile" class="size-9 rounded-full object-cover ring-2 ring-slate-100">
                        <div>
                            <p class="text-sm font-bold text-slate-900">Michelle</p>
                            <p class="text-xs text-slate-400 font-medium">Premium Member</p>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-y-auto p-8">
                
                <div id="view-home" class="space-y-8 page-view">
                    <div>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight flex items-center gap-2">Hi, Michelle 👋</h2>
                        <p class="text-slate-500 font-medium text-sm mt-0.5">What would you like cleaned today?</p>
                    </div>

                    <div class="grid grid-cols-7 gap-4">
                        <button onclick="selectService('Wash & Fold', 120)" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center gap-3 group hover:border-blue-500 transition">
                            <div class="size-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl group-hover:bg-blue-600 group-hover:text-white transition">
                                <i class="fa-solid fa-basket-shopping"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Wash & Fold</span>
                        </button>
                        <button onclick="selectService('Dry Cleaning', 250)" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center gap-3 group hover:border-blue-500 transition">
                            <div class="size-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl group-hover:bg-purple-600 group-hover:text-white transition">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Dry Cleaning</span>
                        </button>
                        <button onclick="selectService('Ironing', 80)" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center gap-3 group hover:border-blue-500 transition">
                            <div class="size-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl group-hover:bg-orange-600 group-hover:text-white transition">
                                <i class="fa-solid fa-mattress-pillow"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Ironing</span>
                        </button>
                        <button onclick="selectService('Bedding', 150)" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center gap-3 group hover:border-blue-500 transition">
                            <div class="size-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:bg-emerald-600 group-hover:text-white transition">
                                <i class="fa-solid fa-bed"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Bedding</span>
                        </button>
                        <button onclick="selectService('Curtains', 200)" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center gap-3 group hover:border-blue-500 transition">
                            <div class="size-12 rounded-xl bg-pink-50 text-pink-600 flex items-center justify-center text-xl group-hover:bg-pink-600 group-hover:text-white transition">
                                <i class="fa-solid fa-scroll"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Curtains</span>
                        </button>
                        <button onclick="selectService('Shoes', 300)" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center gap-3 group hover:border-blue-500 transition">
                            <div class="size-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl group-hover:bg-amber-600 group-hover:text-white transition">
                                <i class="fa-solid fa-shoe-prints"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">Shoes</span>
                        </button>
                        <button onclick="switchView('new-order')" class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col items-center justify-center gap-3 group hover:border-blue-500 transition">
                            <div class="size-12 rounded-xl bg-slate-50 text-slate-600 flex items-center justify-center text-xl group-hover:bg-slate-600 group-hover:text-white transition">
                                <i class="fa-solid fa-ellipsis"></i>
                            </div>
                            <span class="text-xs font-bold text-slate-700">More</span>
                        </button>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-3xl p-6 text-white relative overflow-hidden flex flex-col justify-between h-44 shadow-lg shadow-blue-100">
                            <div class="space-y-1">
                                <span class="bg-white/20 text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">PROMO CODE: WELCOME20</span>
                                <h3 class="text-xl font-black tracking-tight pt-2">20% OFF <br>Your First Order</h3>
                            </div>
                            <button onclick="switchView('new-order')" class="bg-white text-blue-600 font-bold text-xs px-4 py-2 rounded-xl w-fit shadow-md shadow-blue-900/10 hover:bg-slate-50 transition">Order Now</button>
                        </div>

                        <div class="bg-gradient-to-br from-emerald-500 to-teal-600 rounded-3xl p-6 text-white relative overflow-hidden flex flex-col justify-between h-44 shadow-lg shadow-emerald-100">
                            <div class="space-y-1">
                                <span class="bg-white/20 text-xs font-bold px-2.5 py-1 rounded-full backdrop-blur-sm">FREE DELIVERY</span>
                                <h3 class="text-xl font-black tracking-tight pt-2">Free Pickup & <br>Delivery</h3>
                                <p class="text-xs text-emerald-100">On all orders above KSh 1,000</p>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-8">
                        <div class="col-span-2 space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-base font-bold text-slate-900">Laundrymats Near You</h3>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex gap-4 items-start">
                                    <div class="size-12 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 font-bold shrink-0 text-sm">CW</div>
                                    <div class="space-y-1 min-w-0">
                                        <h4 class="text-sm font-bold text-slate-900 truncate">CleanWave Laundry</h4>
                                        <p class="text-xs text-slate-400">⭐ 4.8 • 0.8 km</p>
                                        <p class="text-[11px] font-semibold text-blue-600 pt-1">KSh 120/kg</p>
                                    </div>
                                </div>
                                <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex gap-4 items-start">
                                    <div class="size-12 bg-emerald-50 rounded-xl flex items-center justify-center text-emerald-600 font-bold shrink-0 text-sm">FF</div>
                                    <div class="space-y-1 min-w-0">
                                        <h4 class="text-sm font-bold text-slate-900 truncate">FreshFold Laundry</h4>
                                        <p class="text-xs text-slate-400">⭐ 4.6 • 1.2 km</p>
                                        <p class="text-[11px] font-semibold text-blue-600 pt-1">KSh 110/kg</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <h3 class="text-base font-bold text-slate-900">Recent Orders</h3>
                            <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm space-y-3">
                                <div class="flex items-center justify-between border-b border-slate-50 pb-2">
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-900">Order #LAU-2913</h4>
                                        <p class="text-[10px] text-slate-400 font-medium">Wash & Fold • 8 kg</p>
                                    </div>
                                    <span class="bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-0.5 rounded-md">In Progress</span>
                                </div>
                                <div class="flex items-center justify-between text-xs">
                                    <span class="text-slate-400 font-medium">Est. Delivery</span>
                                    <strong class="text-slate-700 font-semibold">June 26, 2026</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="view-new-order" class="hidden space-y-6 page-view">
                    <div>
                        <button onclick="switchView('home')" class="text-sm font-bold text-blue-600 hover:text-blue-700 flex items-center gap-2 mb-2 transition">
                            <i class="fa-solid fa-arrow-left"></i> Back to Home
                        </button>
                        <h2 class="text-2xl font-black text-slate-900 tracking-tight">Configure New Order</h2>
                        <p class="text-slate-500 text-sm mt-0.5">Review details and secure processing via M-Pesa instant payment node.</p>
                    </div>

                    <div class="grid grid-cols-3 gap-8 items-start">
                        <div class="col-span-2 bg-white border border-slate-100 rounded-3xl p-6 space-y-6 shadow-sm">
                            <h3 class="text-base font-bold text-slate-900 border-b border-slate-50 pb-3">1. Order Configurations</h3>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-2">Service Selection</label>
                                    <select id="order-service-select" onchange="calculateOrderPrice()" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-3 text-sm font-medium focus:outline-none focus:border-blue-500 transition">
                                        <option value="120" data-name="Wash & Fold">Wash & Fold — KSh 120 / kg</option>
                                        <option value="250" data-name="Dry Cleaning">Dry Cleaning — KSh 250 / kg</option>
                                        <option value="80" data-name="Ironing">Ironing Only — KSh 80 / kg</option>
                                        <option value="150" data-name="Bedding">Bedding Sheets — KSh 150 / kg</option>
                                        <option value="200" data-name="Curtains">Curtains — KSh 200 / kg</option>
                                        <option value="300" data-name="Shoes">Premium Shoe Care — KSh 300 / pair</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-500 mb-2">Estimated Weight / Quantity</label>
                                    <input type="number" id="order-weight" value="5" min="1" oninput=\"calculateOrderPrice()\" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-4 py-2.5 text-sm font-bold focus:outline-none focus:border-blue-500 transition">
                                </div>
                            </div>

                            <div class="space-y-3 pt-2">
                                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Coupon Discounts</h4>
                                <div class="flex gap-2">
                                    <input type="text" id="promo-input-field" placeholder="Enter Promo Code (e.g. WELCOME20)" class="bg-slate-50 border border-slate-100 rounded-xl px-4 py-2 text-sm w-64 focus:outline-none focus:border-blue-500">
                                    <button onclick="applyPromoCode()" class="bg-slate-900 text-white font-bold text-xs px-5 py-2.5 rounded-xl hover:bg-slate-800 transition">Apply</button>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white border border-slate-100 shadow-sm rounded-3xl p-6 space-y-4">
                            <div class="flex items-center gap-2">
                                <div class="bg-emerald-600 text-white font-black text-xs px-2.5 py-1 rounded-lg">M-PESA</div>
                                <h3 class="text-sm font-bold text-slate-900">Secure Instant Checkout</h3>
                            </div>

                            <div id="mpesa-status-banner" class="hidden text-xs font-semibold p-3 rounded-xl"></div>

                            <div class="space-y-3">
                                <div>
                                    <label class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">Total Amount (KES)</label>
                                    <input type="number" id="checkout-amount" value="600" readonly class="w-full bg-slate-50 border border-slate-100 text-slate-500 rounded-xl px-3 py-2 text-sm font-bold cursor-not-allowed">
                                </div>
                                <div>
                                    <label class="block text-[10px] uppercase font-bold text-slate-400 tracking-wider mb-1">M-Pesa Registered Number</label>
                                    <input type="text" id="checkout-phone" placeholder="2547XXXXXXXX" class="w-full bg-slate-50 border border-slate-100 rounded-xl px-3 py-2 text-sm font-bold focus:outline-none focus:border-blue-500">
                                </div>
                            </div>

                            <button id="pay-button" onclick="triggerMpesaPush()" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold py-3.5 px-4 rounded-xl shadow-md shadow-emerald-100 transition flex items-center justify-center gap-2 pt-3">
                                <i class="fa-solid fa-mobile-screen-button"></i> Pay via M-Pesa Express
                            </button>
                        </div>
                    </div>
                </div>

                <div id="view-generic" class="hidden space-y-4 page-view">
                    <h2 id="generic-title" class="text-2xl font-black text-slate-900 tracking-tight capitalize">Interface</h2>
                    <p class="text-slate-500 text-sm">Systemic dashboard tracking modules are loaded here.</p>
                    <button onclick="switchView('home')" class="bg-blue-600 text-white text-xs font-bold px-4 py-2 rounded-xl">Return Home</button>
                </div>

            </main>
        </div>
    </div>

    <script>
        // 1. Centralized SPA Tab Window Engine
        function switchView(viewId, customTitle = "") {
            // Hide all active view panels safely
            document.querySelectorAll('.page-view').forEach(view => view.classList.add('hidden'));
            
            // Adjust sidebar navigation highlighting anchors
            document.querySelectorAll('.nav-item').forEach(nav => {
                const pageAttr = nav.getAttribute('data-page');
                if(pageAttr === viewId) {
                    nav.className = "nav-item flex items-center gap-3 px-4 py-3 text-sm font-semibold rounded-xl bg-blue-50 text-blue-600 transition";
                } else {
                    nav.className = "nav-item flex items-center gap-3 px-4 py-3 text-sm font-medium text-slate-500 rounded-xl hover:bg-slate-50 hover:text-slate-900 transition";
                }
            });

            // Trigger structural rendering target
            if (viewId === 'home') {
                document.getElementById('view-home').classList.remove('hidden');
            } else if (viewId === 'new-order') {
                document.getElementById('view-new-order').classList.remove('hidden');
                calculateOrderPrice(); // Sync invoice calculations instantly
            } else {
                const genericView = document.getElementById('view-generic');
                document.getElementById('generic-title').innerText = customTitle || viewId;
                genericView.classList.remove('hidden');
            }
        }

        // Bind clicking events on side navigation tabs
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const targetPage = this.getAttribute('data-page');
                const pageTitle = this.innerText.trim();
                switchView(targetPage, pageTitle);
            });
        });

        // 2. Click Intercept Layer on Home Categories: Routes directly to Order Configuration Setup
        function selectService(serviceName, ratePerUnit) {
            switchView('new-order');
            
            // Lock drop-down selection options to point to chosen category structure
            const selectDropdown = document.getElementById('order-service-select');
            for (let i = 0; i < selectDropdown.options.length; i++) {
                if (selectDropdown.options[i].text.includes(serviceName)) {
                    selectDropdown.selectedIndex = i;
                    break;
                }
            }
            calculateOrderPrice();
        }

        // 3. Dynamic Structural Bill Processing Pricing Calculator Pipeline
        let activeDiscountMultiplier = 1.0;

        function calculateOrderPrice() {
            const selectDropdown = document.getElementById('order-service-select');
            const ratePerUnit = parseFloat(selectDropdown.value);
            const weightInput = parseFloat(document.getElementById('order-weight').value) || 0;
            
            // Compound gross summary calculations
            const grossTotal = ratePerUnit * weightInput;
            const netTotal = Math.round(grossTotal * activeDiscountMultiplier);

            // Update DOM pricing state properties
            document.getElementById('checkout-amount').value = netTotal;

            const statusBanner = document.getElementById('mpesa-status-banner');
            if (activeDiscountMultiplier < 1.0) {
                statusBanner.className = "text-xs font-semibold p-3 rounded-xl mb-3 bg-emerald-50 text-emerald-800";
                statusBanner.innerText = `Promo verified. Invoice updated to KSh ${netTotal} (20% reduction active).`;
            } else {
                statusBanner.className = "text-xs font-semibold p-3 rounded-xl mb-3 bg-blue-50 text-blue-800";
                statusBanner.innerText = `Invoice verified. Total estimated charge is KSh ${netTotal}.`;
            }
            statusBanner.classList.remove('hidden');
        }

        // 4. Coupon Voucher Verification and Hashing Engine
        function applyPromoCode() {
            const codeInput = document.getElementById('promo-input-field').value.trim().toUpperCase();
            
            if (codeInput === 'WELCOME20') {
                activeDiscountMultiplier = 0.80; // 20% flat markdown deduction code mapping
                calculateOrderPrice();
            } else {
                alert("Invalid configuration profile string input for coupon vouchers.");
            }
        }

        // 5. Asynchronous Live AJAX Daraja Gateway Dispatch Manager
        async function triggerMpesaPush() {
            const amountInput = document.getElementById('checkout-amount').value;
            const phoneInput = document.getElementById('checkout-phone').value;
            const statusBanner = document.getElementById('mpesa-status-banner');
            const payButton = document.getElementById('pay-button');

            if (!phoneInput) {
                statusBanner.className = "text-xs font-semibold p-3 rounded-xl mb-3 bg-rose-50 text-rose-800";
                statusBanner.innerText = "Validation Failed: A mobile subscriber line payload is required.";
                statusBanner.classList.remove('hidden');
                return;
            }

            // Set loading interaction tracking configurations
            payButton.disabled = true;
            payButton.innerHTML = `<i class="fa-solid fa-spinner animate-spin"></i> Prompting Handset...`;
            statusBanner.className = "text-xs font-semibold p-3 rounded-xl mb-3 bg-amber-50 text-amber-800";
            statusBanner.innerText = "Connecting to Safaricom Daraja API nodes...";

            try {
                const response = await fetch('/api/v1/mpesa/stk-push', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        amount: amountInput,
                        phone: phoneInput
                    })
                });

                const data = await response.json();

                if (response.ok && data.ResponseCode === "0") {
                    statusBanner.className = "text-xs font-semibold p-3 rounded-xl mb-3 bg-emerald-50 text-emerald-800";
                    statusBanner.innerText = "STK Push sent successfully! Check your phone for the PIN prompt.";
                } else {
                    statusBanner.className = "text-xs font-semibold p-3 rounded-xl mb-3 bg-rose-50 text-rose-800";
                    statusBanner.innerText = data.ResponseDescription || "Gateway connection mismatch or invalid keys.";
                }
            } catch (error) {
                statusBanner.className = "text-xs font-semibold p-3 rounded-xl mb-3 bg-rose-50 text-rose-800";
                statusBanner.innerText = "Network Error: Internal payload parsing failed.";
            } finally {
                payButton.disabled = false;
                payButton.innerHTML = `<i class="fa-solid fa-mobile-screen-button"></i> Pay via M-Pesa Express`;
            }
        }
    </script>
</body>
</html>