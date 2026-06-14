<aside class="w-64 bg-white text-slate-800 min-h-screen p-4 shadow-md border-r border-slate-200">
    <ul class="space-y-1">
        <li>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200 bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10">
                <i class="fa-solid fa-chart-line w-5"></i>
                <span>Dashboard</span>
            </a>
        </li>

        <li>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200 bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10">
                <i class="fa-solid fa-chart-line w-5"></i>
                <span>Produk</span>
            </a>
        </li>
        
        <li>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200 bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10">
                <i class="fa-solid fa-chart-line w-5"></i>
                <span>Transaksi</span>
            </a>
        </li>
        <li>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200 bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10">
                <i class="fa-solid fa-chart-line w-5"></i>
                <span>Stok</span>
            </a>
        </li>
        <li>
            <button onclick="toggleReports()"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200 cursor-pointer text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm">

                <i class="fa-solid fa-chart-bar w-5"></i>
                <span>Laporan</span>

                <i class="fa-solid fa-chevron-down w-4 ml-auto text-xs transition-transform duration-200"
                    id="reportChevron">
                </i>
            </button>

            <ul id="reportsMenu"
                class="space-y-1 ml-6 mt-1 border-l border-slate-200 pl-3 hidden">

                <li>
                    <a href="#"
                        class="flex items-center gap-3 px-4 py-2 rounded font-medium transition-all duration-200 text-sm text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm">

                        <i class="fa-solid fa-receipt w-4"></i>
                        <span>Laporan Transaksi</span>
                    </a>
                </li>

                <li>
                    <a href="#"
                        class="flex items-center gap-3 px-4 py-2 rounded font-medium transition-all duration-200 text-sm text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm">

                        <i class="fa-solid fa-boxes-stacked w-4"></i>
                        <span>Laporan Stok</span>
                    </a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200 text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm">
                <i class="fa-solid fa-users-gear w-5"></i>
                <span>Kelola User</span>
            </a>
        </li>
    </ul>
</aside>