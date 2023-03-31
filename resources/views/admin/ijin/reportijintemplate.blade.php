<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Dept / Unit</th>
            <th>Tgl Ijin Awal</th>
            <th>Tgl Ijin Akhir</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($ijin AS $dataijin)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $dataijin->nik }}</td>
            <td>{{ $dataijin->nama_karyawan }}</td>
            <td>{{ $dataijin->department }} / {{ $dataijin->unit }}</td>
            <td>{{ $dataijin->tgl_ijin_awal }}</td>
            <td>{{ $dataijin->tgl_ijin_akhir }}</td>
        </tr>
    @endforeach
    </tbody>
</table>