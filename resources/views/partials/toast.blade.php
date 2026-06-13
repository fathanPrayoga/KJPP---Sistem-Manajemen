<div id="global-toast" class="fixed bottom-8 right-8 z-[100] max-w-sm w-full bg-white border-l-4 rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] overflow-hidden flex items-start p-4 transition-all duration-300 transform translate-x-full opacity-0" style="display: none;">
    <!-- Icon -->
    <div class="flex-shrink-0 mt-0.5" id="toast-icon-container">
        <!-- Icon will be injected here -->
    </div>
    
    <!-- Content -->
    <div class="ml-4 w-0 flex-1 pt-0.5">
        <p id="toast-title" class="text-[15px] font-bold text-gray-800"></p>
        <p id="toast-message" class="mt-1 text-sm text-gray-500 font-medium leading-relaxed"></p>
    </div>
    
    <!-- Close Button -->
    <div class="ml-4 flex-shrink-0 flex">
        <button onclick="hideToast()" class="bg-white rounded-md inline-flex text-gray-400 hover:text-gray-600 focus:outline-none transition-colors">
            <span class="sr-only">Tutup</span>
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
            </svg>
        </button>
    </div>
</div>

<script>
    let toastTimeout;

    window.showToast = function(type, message) {
        const toast = document.getElementById('global-toast');
        const title = document.getElementById('toast-title');
        const msg = document.getElementById('toast-message');
        const iconContainer = document.getElementById('toast-icon-container');

        // Reset classes
        toast.className = "fixed bottom-8 right-8 z-[100] max-w-sm w-full bg-white border-l-4 rounded-xl shadow-[0_10px_40px_rgba(0,0,0,0.1)] overflow-hidden flex items-start p-4 transition-all duration-300 transform translate-x-10 opacity-0";
        
        if (type === 'success') {
            toast.classList.add('border-[#82C17D]');
            toast.classList.remove('border-red-500');
            title.innerText = 'Sukses!';
            iconContainer.innerHTML = `<div class="w-9 h-9 rounded-full bg-green-50 flex items-center justify-center text-[#82C17D]">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
            </div>`;
        } else {
            toast.classList.add('border-red-500');
            toast.classList.remove('border-[#82C17D]');
            title.innerText = 'Peringatan!';
            iconContainer.innerHTML = `<div class="w-9 h-9 rounded-full bg-red-50 flex items-center justify-center text-red-500">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </div>`;
        }

        msg.innerText = message;
        toast.style.display = 'flex';

        // Trigger reflow
        void toast.offsetWidth;

        // Slide in
        toast.classList.remove('translate-x-10', 'opacity-0');
        toast.classList.add('translate-x-0', 'opacity-100');

        clearTimeout(toastTimeout);
        toastTimeout = setTimeout(() => {
            hideToast();
        }, 4000);
    };

    window.hideToast = function() {
        const toast = document.getElementById('global-toast');
        toast.classList.remove('translate-x-0', 'opacity-100');
        toast.classList.add('translate-x-10', 'opacity-0');
        
        setTimeout(() => {
            toast.style.display = 'none';
        }, 300);
    };

    // Auto-trigger if session exists
    document.addEventListener('DOMContentLoaded', () => {
        @if(session()->has('success') || session()->has('error') || session()->has('status'))
            let sessionType = '{{ session()->has('error') ? 'error' : 'success' }}';
            let sessionMessage = {!! json_encode(session('success') ?? session('error') ?? session('status')) !!};
            window.showToast(sessionType, sessionMessage);
        @endif
    });
</script>
