import { test, expect } from '@playwright/test';

test.describe('Profesi API Test', () => {
    
    const BASE_URL = 'http://127.0.0.1:8000';

    test('API: Create Profesi returns JSON', async ({ request }) => {
        // 1. Get CSRF Token from the login page
        const csrfResponse = await request.get(`${BASE_URL}/`);
        const csrfText = await csrfResponse.text();
        const csrfTokenMatch = csrfText.match(/name="_token" value="([^"]+)"/);
        const csrfToken = csrfTokenMatch ? csrfTokenMatch[1] : '';

        // 2. Login via endpoint web biasa
        const loginResponse = await request.post(`${BASE_URL}/login`, {
            form: {
                username: 'admin2', // Pastikan user ini ada
                password: 'admin2',
                _token: csrfToken
            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
        expect(loginResponse.ok()).toBeTruthy();

        // 3. Create Data via API
        // Gunakan nama unik agar tidak bentrok jika dijalankan berulang
        const uniqueName = `API Tester Playwright ${Date.now()}`;
        const response = await request.post(`${BASE_URL}/profesi`, {
            data: {
                nama_profesi: uniqueName,
                kategori: 'Infokom',
                _token: csrfToken // Include CSRF token for this POST as well if needed
            },
            headers: {
                'Accept': 'application/json', // Minta response JSON
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': csrfToken
            }
        });

        // 4. Assert Response
        expect(response.status()).toBe(200);
        const responseBody = await response.json();
        
        expect(responseBody).toMatchObject({
            status: 'success',
            message: 'Profesi berhasil ditambahkan.'
        });
    });
});
