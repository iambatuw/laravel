import './bootstrap';

// Custom JS for DevTools detection and Sidebar
document.addEventListener('DOMContentLoaded', function() {
    // DevTools Tespiti (Gelişmiş)
    const checkSafety = () => {
        const threshold = 160;
        const body = document.getElementById('safety-overlay');
        if (body && (window.outerWidth - window.innerWidth > threshold || window.outerHeight - window.innerHeight > threshold)) {
            body.style.display = 'flex';
            console.clear();
            console.log('%cDUR! BU ALANA ERIŞIM YASAKTIR.', 'color:red; font-size:30px; font-weight:bold;');
        }
    };
    setInterval(checkSafety, 1000);

    // Sağ Tık ve Tuş Engelleme
    document.addEventListener('contextmenu', e => e.preventDefault());
    document.onkeydown = function(e) {
        if(e.keyCode == 123) return false;
        if(e.ctrlKey && e.shiftKey && (e.keyCode == 73 || e.keyCode == 74 || e.keyCode == 67)) return false;
        if(e.ctrlKey && e.keyCode == 85) return false;
    };

    // Mobil Menü
    const mToggle = document.getElementById('mToggle');
    const sidebar = document.getElementById('mainSidebar');
    if(mToggle && sidebar) {
        mToggle.onclick = () => sidebar.classList.toggle('active');
    }
});
