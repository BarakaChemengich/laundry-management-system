<div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-md mx-auto">
    <div class="flex justify-center mb-4">
        <img src="https://developer.safaricom.co.ke/assets/img/mpesa_logo.png" alt="M-Pesa" class="h-10">
    </div>

    <div id="stkStatus" class="hidden mb-4 p-3 rounded text-sm font-medium"></div>

    <form id="stkForm">
        @csrf
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Amount (KES)</label>
            <input type="number" id="payAmount" value="1" min="1" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" readonly>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Phone Number</label>
            <input type="text" id="payPhone" placeholder="e.g. 254712345678" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
        </div>

        <button type="submit" id="stkBtn" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded transition">
            Pay via M-Pesa
        </button>
    </form>
</div>

<script>
    document.getElementById('stkForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const btn = document.getElementById('stkBtn');
        const banner = document.getElementById('stkStatus');
        const phone = document.getElementById('payPhone').value;
        const amount = document.getElementById('payAmount').value;

        btn.disabled = true;
        btn.innerText = 'Prompting Handset...';
        banner.className = 'mb-4 p-3 rounded text-sm font-medium bg-blue-50 text-blue-800';
        banner.innerText = 'Initializing Daraja connection...';
        banner.classList.remove('hidden');

        try {
            const response = await fetch('/api/v1/mpesa/stk-push', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ phone: phone, amount: amount })
            });

            const data = await response.json();

            if(data.ResponseCode === "0") {
                banner.className = 'mb-4 p-3 rounded text-sm font-medium bg-green-50 text-green-800';
                banner.innerText = 'STK Push sent successfully! Check your phone for the PIN prompt.';
            } else {
                throw new Error(data.ResponseDescription || 'Failed to dispatch request.');
            }
        } catch (error) {
            banner.className = 'mb-4 p-3 rounded text-sm font-medium bg-red-50 text-red-800';
            banner.innerText = error.message;
            btn.disabled = false;
            btn.innerText = 'Pay via M-Pesa';
        }
    });
</script>
