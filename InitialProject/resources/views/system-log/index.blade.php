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
                <div class=" border rounded px-1 " style="width: 20rem;">
                    <div class="input-group">
                        <input type="text" class="form-control border-0" placeholder="Search..." aria-label="Search">
                        <div class="d-flex align-items-center justify-content-center px-2">
                            <i class="mdi mdi-magnify fs-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Filter -->
                <div class="d-flex align-items-center gap-2 bg-secondary py-1 px-3 rounded" style="cursor: pointer;">
                    <i class="mdi mdi-settings"></i>
                    <p class="mb-0">Filter</p>
                </div>
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
            <div class="d-flex justify-content-between mt-3">
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
    const data = [{
            dateTime: '2024-02-07 10:15:00',
            role: 'Admin',
            activity: "Logged In",
            status: true,
            action: ""
        },
        {
            dateTime: '2024-02-07 11:00:00',
            role: 'User',
            activity: "Edited",
            status: true,
            action: ""
        },
        {
            dateTime: '2024-02-07 12:30:00',
            role: 'Admin',
            activity: "Logged Out",
            status: false,
            action: ""
        },
        {
            dateTime: '2024-02-07 10:15:00',
            role: 'Admin',
            activity: "Logged In",
            status: true,
            action: ""
        },
        {
            dateTime: '2024-02-07 11:00:00',
            role: 'User',
            activity: "Edited",
            status: true,
            action: ""
        },
        {
            dateTime: '2024-02-07 12:30:00',
            role: 'Admin',
            activity: "Logged Out",
            status: false,
            action: ""
        },
        {
            dateTime: '2024-02-07 10:15:00',
            role: 'Admin',
            activity: "Logged In",
            status: true,
            action: ""
        },
        {
            dateTime: '2024-02-07 11:00:00',
            role: 'User',
            activity: "Edited",
            status: true,
            action: ""
        },
        {
            dateTime: '2024-02-07 12:30:00',
            role: 'Admin',
            activity: "Logged Out",
            status: false,
            action: ""
        },
        {
            dateTime: '2024-02-07 10:15:00',
            role: 'Admin',
            activity: "Logged In",
            status: true,
            action: ""
        },
        {
            dateTime: '2024-02-07 11:00:00',
            role: 'User',
            activity: "Edited",
            status: true,
            action: ""
        },
        {
            dateTime: '2024-02-07 12:30:00',
            role: 'Admin',
            activity: "Logged Out",
            status: false,
            action: ""
        },
    ];

    const rowsPerPage = 10; // จำนวนแถวต่อหน้า
    let currentPage = 1;

    function renderTable() {
        const tableBody = document.querySelector('#data-table tbody');
        tableBody.innerHTML = ''; // ลบข้อมูลเก่าออก

        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const currentPageData = data.slice(startIndex, endIndex);

        currentPageData.forEach((item) => {
            const row = document.createElement('tr');
            row.innerHTML = `
            <td>${item.dateTime}</td>
            <td>${item.role}</td>
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
        const totalEntries = data.length;
        const startRange = startIndex + 1;
        const endRange = Math.min(endIndex, totalEntries);
        showingText.textContent = `Showing ${startRange} to ${endRange} of ${totalEntries} entries`;

        renderPagination();
    }

    function renderPagination() {
        const pagination = document.querySelector('#pagination');
        pagination.innerHTML = ''; // ลบปุ่มเก่าออก

        const totalPages = Math.ceil(data.length / rowsPerPage);

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

    document.addEventListener('DOMContentLoaded', renderTable); // เรียกฟังก์ชัน renderTable เมื่อโหลดหน้าเสร็จ
</script>

@stop