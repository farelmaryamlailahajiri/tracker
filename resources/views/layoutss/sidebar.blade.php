<!-- Sidebar -->
<div class="sidebar-container">
    <div class="sidebar">
        <!-- Sidebar - Brand -->
        <div class="sidebar-brand">
            <a href="dashboard">
                <img src="tempdashboard/img/logo-tracker.png" alt="Logo">
            </a>
        </div>

        <div class="sidebar-menu">
            <!-- Main Menu -->
            <div class="menu-item active">
                <a href="dashboard">
                    <div class="menu-icon">
                        <div class="icon-bg">
                            <i class="fas fa-fw fa-tachometer-alt"></i>
                        </div>
                    </div>
                    <span>Dashboard</span>
                </a>
            </div>

            <!-- Data Section -->
            <div class="menu-section">DATA</div>
            <div class="menu-item">
                <a href="{{ route('lulusan.index') }}">
                    <div class="menu-icon">
                        <div class="icon-bg">
                            <i class="fas fa-fw fa-file-import"></i>
                        </div>
                    </div>
                    <span>Import Lulusan</span>
                </a>
            </div>

            <div class="menu-item">
                <a href="{{ route('profesi.index') }}">
                    <div class="menu-icon">
                        <div class="icon-bg">
                            <i class="fas fa-fw fa-briefcase"></i>
                        </div>
                    </div>
                    <span>Kelola Profesi</span>
                </a>
            </div>

            <!-- Report Section -->
            <div class="menu-section">LAPORAN</div>
            
            <div class="menu-item">
                <a href="laporan">
                    <div class="menu-icon">
                        <div class="icon-bg">
                            <i class="fas fa-fw fa-file-alt"></i>
                        </div>
                    </div>
                    <span>Laporan</span>
                </a>
            </div>

            <!-- Communication Section -->
            <div class="menu-section">KOMUNIKASI</div>
            
            <div class="menu-item">
                <a href="kirim-email">
                    <div class="menu-icon">
                        <div class="icon-bg">
                            <i class="fas fa-fw fa-envelope"></i>
                        </div>
                    </div>
                    <span>Kirim Email</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
:root {
    --primary-color: #7367f0;
    --primary-light: rgba(115, 103, 240, 0.1);
    --secondary-color: #28c76f;
    --danger-color: #ea5455;
    --warning-color: #ff9f43;
    --info-color: #00cfe8;
    --text-color: #6e6b7b;
    --text-dark: #5e5873;
    --text-active: #7367f0;
    --bg-color: #ffffff;
    --border-color: #ebe9f1;
    --transition-speed: 0.3s;
}

/* Sidebar Container */
.sidebar-container {
    position: relative;
    height: 100vh;
    min-height: 100%;
    background: var(--bg-color);
}

/* Sidebar Styling */
.sidebar {
    background: var(--bg-color);
    width: 260px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    transition: all var(--transition-speed) ease;
    box-shadow: 0 0 15px 0 rgba(34, 41, 47, 0.05);
    border-right: 1px solid var(--border-color);
    overflow: hidden;
    display: flex;
    flex-direction: column;
}

/* Sidebar Brand */
.sidebar-brand {
    padding: 1.5rem 1.5rem 1rem;
    display: flex;
    justify-content: center;
    margin-bottom: 0.5rem;
    border-bottom: 1px solid var(--border-color);
}

.sidebar-brand a {
    display: flex;
    align-items: center;
    justify-content: center;
}

.sidebar-brand img {
    height: 40px;
    transition: all 0.3s ease;
}

.sidebar-brand:hover img {
    transform: scale(1.05);
}

/* Sidebar Menu */
.sidebar-menu {
    padding: 0.5rem 1rem;
    flex: 1;
    overflow-y: auto;
    scrollbar-width: thin;
    scrollbar-color: rgba(0, 0, 0, 0.1) transparent;
}

.sidebar-menu::-webkit-scrollbar {
    width: 4px;
}

.sidebar-menu::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

/* Menu Sections */
.menu-section {
    color: var(--text-color);
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1.5rem 1rem 0.75rem;
    margin-top: 0.5rem;
    font-weight: 600;
    position: relative;
}

.menu-section::after {
    content: '';
    position: absolute;
    left: 1rem;
    right: 1rem;
    bottom: -0.5rem;
    height: 1px;
    background: var(--border-color);
}

/* Menu Items */
.menu-item {
    margin-bottom: 0.25rem;
    position: relative;
}

.menu-item a {
    display: flex;
    align-items: center;
    color: var(--text-dark);
    padding: 0.75rem 1rem;
    border-radius: 6px;
    text-decoration: none;
    transition: all var(--transition-speed) ease;
    position: relative;
    overflow: hidden;
    background: transparent;
}

.menu-item .menu-icon {
    margin-right: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

.menu-item .icon-bg {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(115, 103, 240, 0.12);
    color: var(--primary-color);
    transition: all var(--transition-speed) ease;
}

.menu-item:nth-child(2) .icon-bg {
    background: rgba(40, 199, 111, 0.12);
    color: var(--secondary-color);
}

.menu-item:nth-child(3) .icon-bg {
    background: rgba(234, 84, 85, 0.12);
    color: var(--danger-color);
}

.menu-item:nth-child(4) .icon-bg {
    background: rgba(255, 159, 67, 0.12);
    color: var(--warning-color);
}

.menu-item:nth-child(5) .icon-bg {
    background: rgba(0, 207, 232, 0.12);
    color: var(--info-color);
}

.menu-item span {
    font-weight: 500;
    transition: all var(--transition-speed) ease;
    font-size: 0.95rem;
}

/* Hover Effects */
.menu-item:hover a {
    background: var(--primary-light);
    color: var(--text-active);
}

.menu-item:hover .icon-bg {
    transform: scale(1.1);
    box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
}

/* Active State */
.menu-item.active a {
    background: var(--primary-light);
    color: var(--text-active);
    font-weight: 600;
}

.menu-item.active .icon-bg {
    background: var(--primary-color);
    color: white;
    box-shadow: 0 3px 10px rgba(115, 103, 240, 0.3);
}

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        width: 80px;
    }
    
    .sidebar-brand {
        padding: 1rem 0.5rem;
    }
    
    .sidebar-brand img {
        height: 35px;
    }
    
    .menu-section, .menu-item span {
        display: none;
    }
    
    .menu-item a {
        justify-content: center;
        padding: 0.75rem 0.5rem;
    }
    
    .menu-item .menu-icon {
        margin-right: 0;
    }
    
    .sidebar:hover {
        width: 260px;
    }
    
    .sidebar:hover .menu-section,
    .sidebar:hover .menu-item span {
        display: block;
    }
    
    .sidebar:hover .menu-item a {
        justify-content: flex-start;
        padding: 0.75rem 1rem;
    }
    
    .sidebar:hover .menu-item .menu-icon {
        margin-right: 1rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menuItems = document.querySelectorAll('.menu-item');
    
    // Set active item based on current URL
    function setActiveItem() {
        const currentPath = window.location.pathname.split('/').pop() || 'dashboard';
        
        menuItems.forEach(item => {
            const link = item.querySelector('a');
            const href = link.getAttribute('href');
            const linkPath = href.split('/').pop();
            
            if (currentPath === linkPath || 
                (currentPath === '' && linkPath === 'dashboard') ||
                (currentPath.includes('lulusan') && linkPath.includes('lulusan')) ||
                (currentPath.includes('profesi') && linkPath.includes('profesi'))) {
                item.classList.add('active');
            } else {
                item.classList.remove('active');
            }
        });
    }
    
    // Click effect
    menuItems.forEach(item => {
        item.addEventListener('click', function() {
            menuItems.forEach(i => i.classList.remove('clicked'));
            this.classList.add('clicked');
            setTimeout(() => this.classList.remove('clicked'), 300);
        });
    });
    
    setActiveItem();
});
</script>