import { test, expect } from '@playwright/test';

test.describe('User Full Journey E2E', () => {
    
    // Ganti URL ini sesuai dengan URL lokal Anda, misal http://127.0.0.1:8000
    const BASE_URL = 'http://127.0.0.1:8000';

    test('User can login, create profesi, and logout', async ({ page }) => {
        // 1. Login
        await page.goto(`${BASE_URL}/`); 
        
        // Klik tombol Login di navbar untuk membuka modal
        await page.click('button.main-red-button:has-text("Login")');
        
        // Tunggu modal muncul
        await expect(page.locator('#loginModal')).toBeVisible();

        // Isi form login
        await page.fill('input[name="username"]', 'admin2'); // Pastikan user ini ada di DB
        await page.fill('input[name="password"]', 'admin2');
        await page.click('#loginModal button[type="submit"]'); // Klik tombol login di dalam modal

        // Assert: Berhasil login dan masuk dashboard
        await expect(page).toHaveURL(`${BASE_URL}/dashboard`);
        await expect(page.locator('body')).toContainText('Dashboard');

        // 2. Create Profesi
        // Navigasi ke halaman profesi
        await page.goto(`${BASE_URL}/profesi`); 
        
        // Klik tombol Tambah Profesi untuk membuka modal
        await page.click('button[data-bs-target="#modalTambahProfesi"]');
        
        // Tunggu modal muncul
        await expect(page.locator('#modalTambahProfesi')).toBeVisible();
        
        // Isi form create (gunakan selector spesifik dalam modal agar tidak ambigu)
        await page.fill('#modalTambahProfesi input[name="nama_profesi"]', 'Playwright Engineer');
        await page.selectOption('#modalTambahProfesi select[name="kategori"]', 'Infokom');
        
        // Klik tombol simpan di dalam modal tambah
        await page.click('#modalTambahProfesi button[type="submit"]'); 

        // Assert: Data muncul di tabel (tunggu sebentar karena mungkin pakai AJAX)
        await expect(page.locator('body')).toContainText('Playwright Engineer');

        // 3. Logout
        // Klik tombol "Keluar" di header untuk memunculkan modal konfirmasi
        await page.click('#logoutButton');
        
        // Tunggu modal logout muncul
        await expect(page.locator('#logoutModal')).toBeVisible();
        
        // Klik tombol "Ya, Logout" di dalam modal
        await page.click('#confirmLogout');
        
        // Tunggu sampai URL berubah ke landing page (timeout diperpanjang jadi 10 detik)
        await page.waitForURL(`${BASE_URL}/`, { timeout: 10000 });
        
        // Assert: Kembali ke landing page
        await expect(page).toHaveURL(`${BASE_URL}/`);
    });
});
