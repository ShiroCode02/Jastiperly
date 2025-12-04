// Jastiperly\resources\js\sidebar.js
document.addEventListener('DOMContentLoaded', function () {
    console.log('Sidebar JS loaded!');
    const sidebarContent = document.getElementById('sidebar-content');
    const logoContent = document.getElementById('toggle-sidebar'); // Sekarang hanya logo
    const logoText = document.getElementById('logo-text');
    const menuLinks = document.querySelectorAll('#sidebar-content .group');
    const menuTexts = document.querySelectorAll('.menu-text');
    const iconLinks = document.querySelectorAll('#icon-content .group'); // Link ikon statis
    const mainContent = document.getElementById('main-content');
    const navbarHeader = document.getElementById('navbar-header');
    const iconContent = document.getElementById('icon-content');

    console.log('Elements found:', { sidebarContent, logoContent, logoText, menuTexts: menuTexts.length, menuLinks: menuLinks.length, iconLinks: iconLinks.length, mainContent, navbarHeader, iconContent });

    if (!logoContent || !mainContent || !navbarHeader) {
        console.error('Required elements not found!');
        return;
    }

    // Default tertutup, ambil dari localStorage jika ada
    let isSidebarOpen = localStorage.getItem('sidebarState') === 'open' ? true : false;

    const updateSidebarState = function () {
        const sidebar = document.getElementById('main-sidebar');

        if (isSidebarOpen) {
            // Buka sidebar
            sidebar.classList.remove('w-[97px]');
            sidebar.classList.add('w-[312px]');
            sidebarContent.classList.remove('-translate-x-full');
            sidebarContent.classList.add('translate-x-0');
            if (iconContent) iconContent.classList.remove('overflow-hidden');
            menuLinks.forEach(link => {
                link.classList.remove('pointer-events-none');
            });
            menuTexts.forEach(text => {
                text.classList.remove('opacity-0', '-translate-x-full');
                text.classList.add('opacity-100', 'translate-x-0');
                text.style.pointerEvents = 'auto';
            });
            mainContent.classList.remove('ml-97');
            mainContent.classList.add('ml-312');
            navbarHeader.classList.remove('left-97');
            navbarHeader.classList.add('left-312');
            localStorage.setItem('sidebarState', 'open');
        } else {
            // Tutup sidebar
            sidebar.classList.remove('w-[312px]');
            sidebar.classList.add('w-[97px]');
            sidebarContent.classList.remove('translate-x-0');
            sidebarContent.classList.add('-translate-x-full');
            if (iconContent) iconContent.classList.add('overflow-hidden');
            menuLinks.forEach(link => {
                link.classList.add('pointer-events-none');
            });
            menuTexts.forEach(text => {
                text.classList.remove('opacity-100', 'translate-x-0');
                text.classList.add('opacity-0', '-translate-x-full');
                text.style.pointerEvents = 'none';
            });
            mainContent.classList.remove('ml-312');
            mainContent.classList.add('ml-97');
            navbarHeader.classList.remove('left-312');
            navbarHeader.classList.add('left-97');
            localStorage.setItem('sidebarState', 'closed');
        }
    };

    // Disable transisi sementara saat inisialisasi
    sidebarContent.classList.add('no-transition');
    mainContent.classList.add('no-transition');
    navbarHeader.classList.add('no-transition');

    // Inisialisasi state awal
    updateSidebarState();

    // Hapus disable transisi dan initial-hidden setelah render
    setTimeout(() => {
        console.log('Removing no-transition class');
        sidebarContent.classList.remove('no-transition');
        mainContent.classList.remove('no-transition');
        navbarHeader.classList.remove('no-transition');
    }, 0);

    const toggleSidebarFunction = function (e) {
        console.log('Toggle clicked!', { isSidebarOpen });
        e.preventDefault();
        isSidebarOpen = !isSidebarOpen;
        updateSidebarState();
    };

    // Toggle via logo
    logoContent.addEventListener('click', toggleSidebarFunction);

    // Toggle via teks logo (hanya jika terbuka)
    if (logoText) {
        logoText.addEventListener('click', function (e) {
            if (isSidebarOpen) {
                toggleSidebarFunction(e);
            }
        });
    }

    // Handle klik ikon statis
    iconLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            const href = link.getAttribute('href');
            const isActive = link.classList.contains('bg-[#0A0E5C]'); // halaman aktif
            const isSamePage = window.location.pathname === new URL(href, window.location.origin).pathname;

            console.log('Icon clicked:', { isActive, isSidebarOpen, href, isSamePage });

            // Kasus 1: Sidebar sedang terbuka
            if (isSidebarOpen) {
                // Jika klik ikon halaman yang sedang aktif → tutup sidebar
                if (isActive || isSamePage) {
                    e.preventDefault();
                    toggleSidebarFunction(e);
                    return;
                }
                // Jika klik ikon lain → biarkan navigasi normal
                return;
            }

            // Kasus 2: Sidebar tertutup
            if (!isSidebarOpen) {
                // Jika klik ikon halaman yang sedang aktif → buka sidebar
                if (isActive || isSamePage) {
                    e.preventDefault();
                    toggleSidebarFunction(e);
                    return;
                }
                // Jika klik ikon lain → navigasi normal (tidak buka sidebar)
                return;
            }
        });
    });
});