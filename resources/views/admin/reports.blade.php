@extends('layouts.admin-dashboard')

@section('admin-content')
<div class="container mt-4">
    <h2>Laporan Peserta Magang</h2>
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="group_by">Group By</label>
            <select id="group_by" class="form-control">
                <option value="direktorat">Direktorat</option>
                <option value="subdirektorat">Sub Direktorat</option>
                <option value="divisi">Divisi</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="classification">Klasifikasi</label>
            <select id="classification" class="form-control">
                <option value="all">All</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="period">Periode</label>
            <select id="period" class="form-control">
                <option value="mingguan">Mingguan</option>
                <option value="bulanan">Bulanan</option>
                <option value="tahunan">Tahunan</option>
            </select>
        </div>
        <div class="col-md-3">
            <label for="waktu_detail">Waktu</label>
            <select id="waktu_detail" class="form-control"></select>
        </div>
    </div>
    <div class="row mb-2">
        <div class="col-12 d-flex gap-2">
            <button id="btn-export-pdf" class="btn btn-danger">Export PDF</button>
            <button id="btn-export-excel" class="btn btn-success">Export Excel</button>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered" id="report-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>Universitas/Sekolah</th>
                        <th>Jurusan</th>
                        <th>NIM</th>
                        <th style="min-width: 130px;">Tanggal Mulai</th>
                        <th style="min-width: 150px;">Tanggal Berakhir</th>
                        <th>Divisi</th>
                        <th>Sub Direktorat</th>
                        <th>Direktorat</th>
                        <th>Predikat</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data akan diisi via JS -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function loadClassifications() {
    const groupBy = document.getElementById('group_by').value;
    const select = document.getElementById('classification');
    select.innerHTML = '<option value="all">All</option>';
    fetch(`/admin/reports/classifications?group_by=${groupBy}`)
        .then(res => res.json())
        .then(res => {
            res.data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.id;
                opt.textContent = item.name;
                select.appendChild(opt);
            });
        });
}

function loadWaktuDetail() {
    const period = document.getElementById('period').value;
    const waktuSelect = document.getElementById('waktu_detail');
    waktuSelect.innerHTML = '';
    fetch(`/admin/reports/periods?period=${period}`)
        .then(res => res.json())
        .then(res => {
            res.data.forEach(item => {
                const opt = document.createElement('option');
                opt.value = item.value;
                opt.textContent = item.label;
                waktuSelect.appendChild(opt);
            });
        });
}

document.getElementById('group_by').addEventListener('change', function() {
    loadClassifications();
    fetchReport();
});
document.getElementById('classification').addEventListener('change', fetchReport);
document.getElementById('period').addEventListener('change', function() {
    loadWaktuDetail();
    fetchReport();
});
document.getElementById('waktu_detail').addEventListener('change', fetchReport);

function fetchReport() {
    const groupBy = document.getElementById('group_by').value;
    const period = document.getElementById('period').value;
    const classification = document.getElementById('classification').value;
    const waktu = document.getElementById('waktu_detail').value;
    let url = `/admin/reports/data?group_by=${groupBy}&period=${period}`;
    if (classification && classification !== 'all') {
        url += `&classification=${classification}`;
    }
    // Tambahkan filter waktu detail
    if (waktu) {
        if (period === 'tahunan') {
            url += `&year=${waktu}`;
        } else if (period === 'bulanan') {
            const [month, year] = waktu.split('-');
            url += `&year=${year}&month=${month}`;
        } else if (period === 'mingguan') {
            url += `&week=${waktu}`;
        }
    }
    fetch(url)
        .then(res => res.json())
        .then(res => {
            const tbody = document.querySelector('#report-table tbody');
            tbody.innerHTML = '';
            const data = res.data;
            if (Array.isArray(data) && data.length > 0) {
                data.forEach(row => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td>${row.no}</td>
                        <td>${row.nama}</td>
                        <td>${row.universitas}</td>
                        <td>${row.jurusan}</td>
                        <td>${row.nim}</td>
                        <td>${row.tanggal_mulai}</td>
                        <td>${row.tanggal_berakhir}</td>
                        <td>${row.divisi}</td>
                        <td>${row.subdirektorat}</td>
                        <td>${row.direktorat}</td>
                        <td>${row.predikat}</td>
                    `;
                    tbody.appendChild(tr);
                });
            } else {
                tbody.innerHTML = '<tr><td colspan="11" class="text-center">Tidak ada Peserta Magang</td></tr>';
            }
        });
}

// Panggil saat load awal
loadClassifications();
loadWaktuDetail();
fetchReport();

// Export PDF
    document.getElementById('btn-export-pdf').addEventListener('click', function() {
        const groupBy = document.getElementById('group_by').value;
        const period = document.getElementById('period').value;
        const classification = document.getElementById('classification').value;
        let url = `/admin/reports/export/pdf?group_by=${groupBy}&period=${period}`;
        if (classification && classification !== 'all') {
            url += `&classification=${classification}`;
        }
        window.location.href = url;
    });
// Export Excel
    document.getElementById('btn-export-excel').addEventListener('click', function() {
        const groupBy = document.getElementById('group_by').value;
        const period = document.getElementById('period').value;
        const classification = document.getElementById('classification').value;
        let url = `/admin/reports/export/excel?group_by=${groupBy}&period=${period}`;
        if (classification && classification !== 'all') {
            url += `&classification=${classification}`;
        }
        window.location.href = url;
    });
</script>
@endpush 