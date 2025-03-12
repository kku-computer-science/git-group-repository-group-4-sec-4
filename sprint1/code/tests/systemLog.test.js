const puppeteer = require('puppeteer');

describe('Login and Search Functionality', () => {
    let browser;
    let page;

    beforeAll(async () => {
        jest.setTimeout(20000); // เพิ่ม timeout เป็น 20 วินาทีสำหรับทั้งหมด
        browser = await puppeteer.launch();
        page = await browser.newPage();
    }, 20000);

    afterAll(async () => {
        if (browser) {
            await browser.close();
        }
    });

    it('should login and go to system-log page', async () => {
        // ไปที่หน้า Login ก่อน
        await page.goto('http://127.0.0.1:8000/login');  // URL ของหน้า login

        // กรอกข้อมูล username และ password
        await page.type('#username', 'admin@gmail.com');  // กรอก username
        await page.type('#password', '123456789');  // กรอกรหัสผ่าน

        // คลิกปุ่ม login
        await page.click('button[type="submit"]');

        // รอให้หน้า system-log โหลดเสร็จ
        await page.waitForNavigation();

        // ตรวจสอบว่าหลังจาก login แล้วสามารถไปหน้า system-log ได้
        await page.goto('http://127.0.0.1:8000/system-log');

        // ตรวจสอบว่าไปที่หน้า system-log ได้
        const pageContent = await page.content();
        const isSystemLogPage = pageContent.includes('System Log');  // สมมุติว่าในหน้า system-log มีข้อความ "System Log"
        expect(isSystemLogPage).toBe(true);
    });

    it('should search and display the correct data in system-log', async () => {
        // ไปที่หน้า system-log
        await page.goto('http://127.0.0.1:8000/system-log');

        // รอให้ input ค้นหาโหลด
        await page.waitForSelector('#search-input', { timeout: 10000 });

        // คำที่ต้องการค้นหา
        const searchKeyword = 'test@gmail.com';  // เปลี่ยนเป็น email ที่ต้องการค้น

        // กรอกคำค้นหา
        await page.type('#search-input', searchKeyword);

        // รอให้ผลลัพธ์โหลด
        await page.waitForSelector('table tbody tr', { timeout: 10000 });

        // ดึงข้อมูล email จากผลลัพธ์ในตาราง
        const searchResults = await page.evaluate(() => {
            return Array.from(document.querySelectorAll('table tbody tr td:nth-child(2)')) // คอลัมน์ที่ 2 เป็น email
                .map(td => td.textContent.trim());
        });

        // ตรวจสอบว่า email ที่ค้นหาอยู่ในผลลัพธ์
        expect(searchResults).toContain(searchKeyword);
    });

    jest.setTimeout(30000); // เพิ่ม timeout เป็น 15 วินาที
    it('should filter system-log by date range', async () => {
        await page.goto('http://127.0.0.1:8000/system-log');

        await page.waitForSelector('.dropdown', { timeout: 10000 });

        const startDate = '2025-02-11';
        const endDate = '2025-02-12';

        await page.type('#filter-start-date', startDate);
        await page.type('#filter-end-date', endDate);

        // รอให้ข้อมูลในตารางโหลดใหม่
        await page.waitForSelector('table tbody tr', { timeout: 30000 });

        // ตรวจสอบข้อมูลในตาราง
        const firstRowDate = await page.evaluate(() => {
            const firstRow = document.querySelector('table tbody tr');
            if (firstRow) {
                const firstCell = firstRow.querySelector('td:nth-child(1)'); // คอลัมน์วันที่
                return firstCell ? firstCell.textContent.trim() : null;
            }
            return null;
        });

        console.log('First Row Date:', firstRowDate);

        // ตรวจสอบว่าแถวแรกตรงกับวันที่ที่กรอง
        expect(firstRowDate).toBe(startDate);
    });

});
