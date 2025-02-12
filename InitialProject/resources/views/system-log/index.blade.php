@extends('dashboards.users.layouts.user-dash-layout')
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.12.0/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/fixedheader/3.2.3/css/fixedHeader.bootstrap4.min.css">

@section('title','Dashboard')

@section('content')

<div class="container">
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    <div class="card" style="padding: 16px;">
        <div class="card-body">
            <h4 class="card-title">Systam Log</h4>

            <div class="mt-4 d-flex align-items-end gap-3 p-0 flex-wrap">
                <!-- Search -->
                <div class="border rounded px-1" style="width: 20rem;">
                    <div class="input-group">
                        <input type="text" class="form-control border-0" id="search-input" placeholder="Search by email..." aria-label="Search">
                        <div class="d-flex align-items-center justify-content-center px-2">
                            <i class="mdi mdi-magnify fs-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Filter -->
                <div class="dropdown">
                    <div class="d-flex align-items-center gap-2 bg-secondary py-1 px-3 rounded"
                        style="cursor: pointer;"
                        data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="mdi mdi-settings"></i>
                        <p class="mb-0">Filter</p>
                    </div>

                    <ul class="dropdown-menu p-3">
                        <li>
                            <label class="form-label">Select Start Date</label>
                            <input type="date" class="form-control" id="filter-start-date">
                        </li>
                        <li class="mt-2">
                            <label class="form-label">Select End Date</label>
                            <input type="date" class="form-control" id="filter-end-date">
                        </li>
                        <li class="mt-3 text-end">
                            <button class="btn btn-primary btn-sm" onclick="applyDateFilter()">Apply</button>
                        </li>
                    </ul>
                </div>
                <div class="w-100">
                    <p id="filter-info"></p>
                    <button id="clear-filter" class="btn btn-secondary" style="display: none;">Clear</button> <!-- ปุ่มล้าง -->
                </div>

                <table id="data-table" class="table table-striped mt-2">
                    <thead class="thead-dark">
                        <tr>
                            <th>Datatime</th>
                            <th>User</th>
                            <th>Activity</th>
                            <th>Status</th>
                            <th>Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- ข้อมูลจะถูกแทรกในนี้ -->
                    </tbody>
                </table>
                <div class="d-flex w-100 justify-content-between mt-3">
                    <div>
                        <p id="showing-text"></p>
                    </div>
                    <!-- Pagination Links -->
                    <div class="  ">
                        <ul id="pagination" class="pagination">
                            <!-- ปุ่ม Pagination จะถูกสร้างที่นี่ -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        const rowsPerPage = 10; // จำนวนแถวต่อหน้า
        let currentPage = 1;
        let searchQuery = ''; // ตัวแปรสำหรับเก็บคำค้นหา

        let filteredData = []; // ตัวแปรเพื่อเก็บข้อมูลที่กรองแล้ว
        // ฟังก์ชันกรองข้อมูลตามช่วงวันที่
        function applyDateFilter() {
            const startDate = document.getElementById("filter-start-date").value;
            const endDate = document.getElementById("filter-end-date").value;
            const filterInfo = document.getElementById("filter-info");
            const clearFilterBtn = document.getElementById("clear-filter");

            // Display filter message
            if (!startDate && !endDate) {
                filterInfo.textContent = "=";
                clearFilterBtn.style.display = "none"; // Hide the clear filter button
            } else if (startDate && !endDate) {
                filterInfo.textContent = `Filtering from: ${startDate}`;
                clearFilterBtn.style.display = "block"; // Show the clear filter button
            } else if (!startDate && endDate) {
                filterInfo.textContent = `Filtering until: ${endDate}`;
                clearFilterBtn.style.display = "block"; // Show the clear filter button
            } else {
                filterInfo.textContent = `Filtering from: ${startDate} to ${endDate}`;
                clearFilterBtn.style.display = "block"; // Show the clear filter button
            }


            // กรองข้อมูลจากวันที่
            filteredData = data.filter(item => {
                const itemDate = new Date(item.dateTime); // แปลง dateTime ของ item เป็นวันที่
                const startDateObj = startDate ? new Date(startDate) : null;
                const endDateObj = endDate ? new Date(endDate) : null;

                let isValid = true;

                if (startDateObj) {
                    isValid = isValid && itemDate >= startDateObj;
                }
                if (endDateObj) {
                    isValid = isValid && itemDate <= endDateObj;
                }

                return isValid;
            });

            // เรียกใช้ฟังก์ชัน renderTable เพื่อแสดงข้อมูลที่กรองแล้ว
            renderTable();
        }

        // ฟังก์ชันสำหรับล้างการกรอง
        function clearFilter() {
            // รีเซ็ตค่าของ input fields
            document.getElementById("filter-start-date").value = '';
            document.getElementById("filter-end-date").value = '';
            document.getElementById("filter-info").textContent = ''; // ลบข้อความกรอง

            // ซ่อนปุ่มล้าง
            document.getElementById("clear-filter").style.display = "none";

            // รีเซ็ตข้อมูลให้แสดงทั้งหมด
            filteredData = data;
            renderTable();
        }


        // search function
        function search() {
            const searchInput = document.getElementById("search-input").value.toLowerCase();
            searchQuery = searchInput;
            renderTable();
        }

        // table
        function renderTable() {
            const startDate = document.getElementById("filter-start-date").value;
            const endDate = document.getElementById("filter-end-date").value;

            if (!startDate && !endDate) {
                filteredData = data
            }

            const tableBody = document.querySelector('#data-table tbody');
            tableBody.innerHTML = ''; // ลบข้อมูลเก่าออก

            const startIndex = (currentPage - 1) * rowsPerPage;
            const endIndex = startIndex + rowsPerPage;

            // กรองข้อมูลจาก searchQuery โดยใช้ filteredData ที่กรองวันที่แล้ว
            const filteredDataWithSearch = filteredData.filter(item => item.email.toLowerCase().includes(searchQuery));
            const currentPageData = filteredDataWithSearch.slice(startIndex, endIndex);

            currentPageData.forEach((item) => {
                const row = document.createElement('tr');
                row.innerHTML = `
            <td>${item.dateTime}</td>
            <td>${item.email}</td>
            <td>${item.activity}</td>
            <td class="d-flex align-items-center gap-2">
                ${item.status ? (
                    `<i class="mdi mdi-checkbox-marked text-success fs-2"></i> <p class="mb-0">Success</p>`
                ):(
                    `<i class="mdi mdi-close text-danger fs-2"></i> <p class="mb-0">Failed</p>`
                )}
            </td>
            <td>
                <i class="mdi mdi-dots-horizontal fs-2"></i> 
            </td>
        `;
                tableBody.appendChild(row);
            });

            // Update the 'Showing' text
            const showingText = document.querySelector('#showing-text');
            const totalEntries = filteredDataWithSearch.length;
            const startRange = startIndex + 1;
            const endRange = Math.min(endIndex, totalEntries);
            showingText.textContent = `Showing ${startRange} to ${endRange} of ${totalEntries} entries`;

            renderPagination(filteredDataWithSearch);
        }


        // pagination
        function renderPagination(filteredData) {
            const pagination = document.querySelector('#pagination');
            pagination.innerHTML = ''; // ลบปุ่มเก่าออก

            const totalPages = Math.ceil(filteredData.length / rowsPerPage);

            // สร้างปุ่ม "Previous"
            const prevItem = document.createElement('li');
            prevItem.classList.add('page-item');
            prevItem.innerHTML = `<a class="page-link" href="#">Previous</a>`;
            prevItem.classList.toggle('disabled', currentPage === 1);
            prevItem.addEventListener('click', (e) => {
                e.preventDefault();
                if (currentPage > 1) {
                    currentPage--;
                    renderTable();
                }
            });
            pagination.appendChild(prevItem);

            // สร้างปุ่มสำหรับแต่ละหน้า
            for (let i = 1; i <= totalPages; i++) {
                const pageItem = document.createElement('li');
                pageItem.classList.add('page-item');
                pageItem.innerHTML = `<a class="page-link" href="#">${i}</a>`;

                if (i === currentPage) {
                    pageItem.classList.add('active');
                }

                pageItem.addEventListener('click', (e) => {
                    e.preventDefault();
                    currentPage = i;
                    renderTable();
                });

                pagination.appendChild(pageItem);
            }

            // สร้างปุ่ม "Next"
            const nextItem = document.createElement('li');
            nextItem.classList.add('page-item');
            nextItem.innerHTML = `<a class="page-link" href="#">Next</a>`;
            nextItem.classList.toggle('disabled', currentPage === totalPages);
            nextItem.addEventListener('click', (e) => {
                e.preventDefault();
                if (currentPage < totalPages) {
                    currentPage++;
                    renderTable();
                }
            });
            pagination.appendChild(nextItem);
        }

        // เรียกใช้เมื่อหน้าโหลดเสร็จ
        document.addEventListener('DOMContentLoaded', () => {
            // ฟังก์ชันค้นหาจะทำงานเมื่อมีการพิมพ์ข้อความในช่องค้นหา
            document.getElementById("search-input").addEventListener("input", search);
            document.getElementById("filter-start-date").addEventListener('input', applyDateFilter);
            document.getElementById("filter-end-date").addEventListener('input', applyDateFilter);

            // เพิ่ม event listener ให้กับปุ่มล้าง
            document.getElementById("clear-filter").addEventListener("click", clearFilter);

            renderTable();
        });
    </script>


    <!-- mockup data -->
    <script>
        const data = [{
                dateTime: '2025-02-11',
                role: 'Admin',
                email: 'test@gmail.com',
                activity: "Logged In",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-06',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-08',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2024-02-07 10:15:00',
                role: 'Admin',
                email: 'test@gmail.com',
                activity: "Logged In",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2024-02-07 10:15:00',
                role: 'Admin',
                email: 'test@gmail.com',
                activity: "Logged In",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2024-02-07 10:15:00',
                role: 'Admin',
                email: 'test@gmail.com',
                activity: "Logged In",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2024-02-07 10:15:00',
                role: 'Admin',
                email: 'test@gmail.com',
                activity: "Logged In",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2024-02-07 10:15:00',
                role: 'Admin',
                email: 'test@gmail.com',
                activity: "Logged In",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },
            {
                dateTime: '2025-02-12',
                role: 'User',
                email: 'abc@gmail.com',
                activity: "Edited",
                status: true,
                action: ""
            },

        ];
    </script>
    @stop