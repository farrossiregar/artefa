<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Dept / Unit</th>
            <th>Sisa Cuti Tahunan</th>
            <th>Sisa Cuti Besar</th>
            <th>Sisa Others</th>
            <th>Tgl Cuti diambil</th>
        </tr>
    </thead>
    <tbody>
    @php $no = 1 @endphp
    @foreach($cuti AS $datacuti)
        <tr>
            <td>{{ $no++ }}</td>
            <td>{{ $datacuti->nik }}</td>
            <td>{{ $datacuti->nama_karyawan }}</td>
            <td>{{ $datacuti->unit }}</td>
            <td>{{ $datacuti->sisa_cuti_tahunan }}</td>
            <td>{{ $datacuti->sisa_cuti_besar }}</td>
            <td>{{ $datacuti->tgl_cuti_awal }}</td>
            <td>{{ $datacuti->tgl_cuti_akhir }}</td>
            <td>{{ $datacuti->penjelasan_cuti }}</td>
        </tr>
    @endforeach
    </tbody>
</table>