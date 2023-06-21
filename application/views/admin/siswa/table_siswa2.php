<table class="table table-hover table-stripped" id="my-table2">
    <thead>
        <tr>
            <th>No.</th>
            <th>No Tes</th>
            <th>No. Induk</th>
            <th>Nama</th>
            <th>NISN</th>
            <th>NIK</th>
            <th>Anak Ke</th>
            <th>Tempat Lahir</th>
            <th>Tanggal Lahir</th>
            <th>Usia</th>
            <th>Jenis Kelamin</th>
            <th>Alamat</th>
            <th>Desa/Kelurahan</th>
            <th>Kecamatan</th>
            <th>Kab./Kota</th>
            <th>Provinsi</th>
            <th>Kode Pos</th>
            <th>NIK KK</th>
            <th>Nama Ayah</th>
            <th>Pendidikan Ayah</th>
            <th>Pekerjaan Ayah</th>
            <th>Nama Ibu</th>
            <th>Pendidikan Ibu</th>
            <th>Pekerjaan Ibu</th>
            <th>No. Hp</th>
            <th>Kelas</th>
            
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        foreach($siswa as $row){
        ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $row->no_tes ?></td>
            <td><?= $row->no_induk ?></td>
            <td><?= strtoupper($row->nama) ?></td>
            <td><?= $row->nisn ?></td>
            <td><?= $row->nik ?></td>
            <td><?= $row->anak_ke ?></td>
            <td><?= $row->tempat_lahir ?></td>
            <td><?= $row->tanggal_lahir ?></td>
            <td><?= $row->usia ?></td>
            <td><?= $row->jenis_kelamin ?></td>
            <td><?= $row->alamat ?></td>
            <td><?= $row->kelurahan ?></td>
            <td><?= $row->kecamatan ?></td>
            <td><?= $list_kota[$row->kabkota]?></td>
            <td><?= $list_provinsi[$row->provinsi]?></td>
            <td><?= $row->kode_pos ?></td>
            <td><?= $row->nik_kk ?></td>
            <td><?= $row->nama_lengkap_ayah ?></td>
            <td><?= $row->pendidikan_ayah ?></td>
            <td><?= $row->pekerjaan_ayah ?></td>
            <td><?= $row->nama_lengkap_ibu ?></td>
            <td><?= $row->pendidikan_ibu ?></td>
            <td><?= $row->pekerjaan_ibu ?></td>
            <td><?= $row->no_hp ?></td>
            <td><?= strtoupper($row->kelas) ?></td>
        </tr>
        <?php
        $i++;
        }
        ?>
    </tbody>
</table>

<script>
	$('#my-table2').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]
    } );
</script>