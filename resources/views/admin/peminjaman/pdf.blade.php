<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Riwayat Peminjaman Aset {{ $bulan }} {{ $tahun }}</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background: #f3f4f6;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Riwayat Peminjaman Aset</h2>
    <p style="text-align:center;">
        Periode: {{ $bulan }} {{ $tahun }}
    </p>


    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal Selesai</th>
                <th>Peminjam</th>
                <th>Aset</th>
                <th>Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $row->updated_at->format('d-m-Y') }}</td>
                    <td>{{ $row->pegawai->nama_pegawai }}</td>
                    <td>{{ $row->aset->nama_aset }}</td>
                    <td>{{ ucfirst($row->kondisi_pengembalian) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>