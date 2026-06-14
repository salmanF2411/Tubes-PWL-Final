<footer class="bg-white text-slate-600 border-t border-slate-200 py-4">
    <div class="px-8 flex items-center justify-between gap-6">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-store text-blue-600 text-lg"></i>
            <div>
                <p class="text-sm font-medium text-slate-900">Mini Market Management System</p>
                <p class="text-xs text-slate-500">Pak Jayusman</p>
            </div>
        </div>
        <!-- Kontak -->
        <div class="flex items-center gap-4 text-xs">
            <div class="flex items-center gap-1.5 text-slate-600">
                <i class="fa-solid fa-envelope w-4 text-slate-400"></i>
                <span>admin@minimarket.com</span>
            </div>
            <div class="hidden md:flex items-center gap-1.5 text-slate-600 border-l border-slate-300 pl-4">
                <i class="fa-solid fa-phone w-4 text-slate-400"></i>
                <span>+62 812-3456-7890</span>
            </div>
        </div>
        <!-- Sosmed -->
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-3">
                <a href="#" class="text-slate-400 hover:text-blue-600 transition text-sm" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" class="text-slate-400 hover:text-blue-600 transition text-sm" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" class="text-slate-400 hover:text-blue-600 transition text-sm" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" class="text-slate-400 hover:text-blue-600 transition text-sm" title="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
            <div class="hidden lg:block w-px h-6 bg-slate-200"></div>
            <div class="text-xs text-slate-500 whitespace-nowrap">
                © {{ date('Y') }} | All Rights Reserved
            </div>
        </div>
    </div>
</footer>