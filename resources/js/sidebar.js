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
        console.log('Updating sidebar state:', { isSidebarOpen });
        if (isSidebarOpen) {
            // Buka sidebar
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
            console.log('Sidebar opened');
        } else {
            // Tutup sidebar
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
            console.log('Sidebar closed');
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
            const isActive = link.classList.contains('bg-[#0A0E5C]'); // Deteksi halaman aktif
            console.log('Icon clicked:', { isActive, isSidebarOpen, href: link.getAttribute('href') });

            // Jika sidebar terbuka, biarkan navigasi normal
            if (isSidebarOpen) {
                console.log('Sidebar open, navigating normally');
                return; // Biarkan <a> berfungsi normal
            }

            // Jika sidebar tertutup
            if (!isSidebarOpen) {
                if (isActive) {
                    // Sudah di halaman tujuan → Toggle sidebar (buka/tutup)
                    e.preventDefault();
                    toggleSidebarFunction(e);
                    console.log('Toggling sidebar for active page');
                } else {
                    // Bukan halaman tujuan → Navigasi normal tanpa buka sidebar
                    console.log('Navigating to new page without opening sidebar');
                }
            }
        });
    });
});