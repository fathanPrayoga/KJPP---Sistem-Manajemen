<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Tahunan KJPP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #82C17D;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #2c3e50;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0 0;
            color: #7f8c8d;
        }
        .info-section {
            margin-bottom: 20px;
        }
        .info-table {
            width: 100%;
        }
        .info-table td {
            padding: 3px 0;
        }
        .info-table td:first-child {
            width: 150px;
            font-weight: bold;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .main-table th, .main-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .main-table th {
            background-color: #82C17D;
            color: white;
            font-weight: bold;
        }
        .main-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
        .signature-box {
            display: inline-block;
            text-align: center;
        }
        .signature-line {
            margin-top: 60px;
            border-top: 1px solid #333;
            width: 200px;
            padding-top: 5px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>LAPORAN TAHUNAN PENILAIAN PROPERTI</h1>
        <p>KANTOR JASA PENILAI PUBLIK (KJPP)</p>
    </div>

    <div class="info-section">
        <table class="info-table">
            <tr>
                <td>Tahun Laporan</td>
                <td>: {{ $year }}</td>
            </tr>
            <tr>
                <td>Total Project Selesai</td>
                <td>: {{ count($projects) }} Project</td>
            </tr>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="main-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 20%;">Nomor Laporan</th>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 25%;">Nama Project</th>
                <th style="width: 20%;">Klien / Instansi</th>
                <th style="width: 15%;">Nilai (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($projects as $index => $project)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>No: {{ str_pad($project->id, 3, '0', STR_PAD_LEFT) }}/KJPP/{{ $year }}</td>
                <td>{{ $project->tanggal_mulai ? \Carbon\Carbon::parse($project->tanggal_mulai)->format('d/m/Y') : '-' }}</td>
                <td>{{ $project->nama_project }}</td>
                <td>{{ $project->client ? $project->client->name : 'Umum' }}</td>
                <td>{{ $project->nilai ? number_format($project->nilai->nilai_likuidasi ?? 0, 0, ',', '.') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <div class="signature-box">
            <p>Pimpinan KJPP,</p>
            <div class="signature-line">
                <strong>( .................................... )</strong>
            </div>
        </div>
    </div>

</body>
</html>
