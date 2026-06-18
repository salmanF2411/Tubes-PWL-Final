<aside class="w-64 bg-white text-slate-800 min-h-screen p-4 shadow-md border-r border-slate-200">
    <ul class="space-y-1">
        <li>
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200
                {{ request()->routeIs('dashboard') 
                    ? 'bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10' 
                    : 'text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm' }}">
                <i class="fa-solid fa-chart-line w-5"></i>
                <span>Dashboard</span>
            </a>
        </li>

        @can('view products')
        <li>
            <a href="{{ route('produk') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200
                {{ request()->routeIs('produk') 
                    ? 'bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10' 
                    : 'text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm' }}">
                <i class="fa-solid fa-box w-5"></i>
                <span>Produk</span>
            </a>
        </li>
        @endcan

        @can('view transactions')
        <li>
            <a href="{{ route('transaksi') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200
                {{ request()->routeIs('transaksi') 
                    ? 'bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10' 
                    : 'text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm' }}">
                <i class="fa-solid fa-receipt w-5"></i>
                <span>Transaksi</span>
            </a>
        </li>
        @endcan

        @can('view inventory')
        <li>
            <a href="{{ route('stok') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200
                {{ request()->routeIs('stok') 
                    ? 'bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10' 
                    : 'text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm' }}">
                <i class="fa-solid fa-warehouse w-5"></i>
                <span>Stok</span>
            </a>
        </li>
        @endcan

        @can('view reports')
        <li>
            <button onclick="toggleReports()"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200 cursor-pointer
                {{ request()->routeIs('laporan-*') 
                    ? 'bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10' 
                    : 'text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm' }}">

                <i class="fa-solid fa-chart-bar w-5"></i>
                <span>Laporan</span>

                <i class="fa-solid fa-chevron-down w-4 ml-auto text-xs transition-transform duration-200 
                    {{ request()->routeIs('laporan-*') ? 'rotate-180' : '' }}"
                    id="reportChevron">
                </i>
            </button>

            <ul id="reportsMenu"
                class="space-y-1 ml-6 mt-1 border-l border-slate-200 pl-3 {{ request()->routeIs('laporan-*') ? '' : 'hidden' }}">
                <li>
                    <a href="{{ route('laporan-transaksi') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded font-medium transition-all duration-200 text-sm
                        {{ request()->routeIs('laporan-transaksi') 
                            ? 'bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10' 
                            : 'text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm' }}">

                        <i class="fa-solid fa-receipt w-4"></i>
                        <span>Laporan Transaksi</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan-stok') }}"
                        class="flex items-center gap-3 px-4 py-2 rounded font-medium transition-all duration-200 text-sm
                        {{ request()->routeIs('laporan-stok') 
                            ? 'bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10' 
                            : 'text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm' }}">

                        <i class="fa-solid fa-boxes-stacked w-4"></i>
                        <span>Laporan Stok</span>
                    </a>
                </li>
            </ul>
        </li>
        @endcan

        @can('view users')
        <li>
            <a href="{{ route('kelola-user') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition-all duration-200
                {{ request()->routeIs('kelola-user') 
                    ? 'bg-[#dbeafe] text-[#062f5f] shadow-sm ring-1 ring-[#062f5f]/10' 
                    : 'text-slate-700 hover:bg-[#dbeafe] hover:text-[#062f5f] hover:shadow-sm' }}">
                <i class="fa-solid fa-users-gear w-5"></i>
                <span>Kelola User</span>
            </a>
        </li>
        @endcan
    </ul>
</aside>

<script>
    function toggleReports() {
        const menu = document.getElementById('reportsMenu');
        const chevron = document.getElementById('reportChevron');

        menu.classList.toggle('hidden');
        chevron.classList.toggle('rotate-180');
    }
</script>