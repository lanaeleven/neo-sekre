<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lembar Disposisi</title>
    <style>
        table {
            width: 100%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid black;
            border-collapse: collapse;
        }
        td {
            padding: 5px;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <th colspan="2" style="padding: 25px; font-size: 20px; text-align: center;">LEMBAR DISPOSISI</th>
        </thead>
        <tbody>
        <tr>
            <th colspan="2" style="padding: 10px; text-align: center;">
                 Status: {{ $suratMasuk->status }}
            </th>
        </tr>
        <tbody>
            <tr>
                <td>
                    <table>
                        <tbody>
                            <tr>
                                <td>Indeks</td>
                                <td>{{ $suratMasuk->index }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Surat</td>
                                <td>{{ $suratMasuk->tanggalSurat }}</td>
                            </tr>
                            <tr>
                                <td>Dari</td>
                                <td>
                                    {{ $suratMasuk->pengirim }}
                                </td>                                        
                            </tr>
                            <tr>
                                <td>Direksi</td>
                                <td>{{ $suratMasuk->idDireksi }}</td>
                            </tr>                                    
                        </tbody>
                        </table>
                </td>
                <td>
                    <table>
                        <tbody>                                
                            <tr>
                                <td>Nomor Surat</td>
                                <td>{{ $suratMasuk->nomorSurat }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Agenda</td>
                                <td>{{ $suratMasuk->tanggalAgenda }}</td>
                            </tr>
                            <tr>
                                <td>Sifat Surat</td>
                                <td>{{ $suratMasuk->sifatSurat }}</td>
                            </tr>
                            <tr>
                                <td>Perihal</td>
                                <td>{{ $suratMasuk->perihal }}</td>
                            </tr>
                            
                        </tbody>
                        </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding: 15px; text-align: center; font-weight: bold">
                    TERUSAN SURAT
                </td>
            </tr>
            
                
            @foreach ($distribusiSurat as $ds)
            
            <tr>
                <td colspan="2">
                    <table style="margin-bottom: 30px; background-color: #fff;">
                        <tbody>
                            <tr>
                                <td>
                                    Oleh
                                </td>
                                <td>
                                    {{ $ds->pengirimDisposisi->namaJabatan }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Kepada
                                </td>
                                <td>
                                    {{ $ds->tujuanDisposisi->namaJabatan }}
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    Tanggal Diteruskan
                                </td>
                                <td>
                                    {{ $ds->tanggalDiteruskan }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center">
                                    INSTRUKSI
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: center; font-size: 14;">
                                    {{-- {{ $ds['instruksi'] }} --}}
                                    {!! nl2br(e($ds->instruksi)) !!}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            
            @endforeach
        </tbody>
    </tbody>
    </table>
</body>
</html>