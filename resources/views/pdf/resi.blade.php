<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resi Pembelian - SIMBRO</title>
    <style>
        /* Menghilangkan margin bawaan sistem DomPDF */
        @page {
            size: 226pt auto;
            margin: 0px !important;
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        html, body {
            margin: 0px !important;
            padding: 0px !important;
            background-color: #ffffff;
            width: 226pt;
        }

        /* Kontainer Utama Resi - Penggeseran Posisi */
        .receipt {
            width: 196pt;            /* Menyesuaikan lebar konten resi */
            margin-top: 25pt;        /* Jarak aman batas atas potong kertas */
            margin-left: 19pt;       /* Mendorong manual seluruh isi resi agar bergeser lebih ke kanan */
            margin-right: 13pt;
            font-family: 'DejaVu Sans', 'Helvetica', 'Arial', sans-serif;
            font-size: 9pt;
            line-height: 1.35;
            color: #000000;
        }

        .header {
            text-align: center;
            margin-bottom: 4px;
        }

        .logo {
            width: 45pt;
            height: auto;
            margin: 0 auto 6px;
            display: block;
        }

        .shop-name {
            font-size: 11pt;
            font-weight: bold;
            margin: 2px 0;
            letter-spacing: 0.3px;
            text-align: center;
        }

        .shop-info {
            font-size: 8pt;
            color: #333333;
            margin: 1px 0;
            text-align: center;
        }

        .title {
            font-size: 10pt;
            font-weight: bold;
            margin: 6px 0 2px;
            text-transform: uppercase;
            text-align: center;
            letter-spacing: 0.5px;
        }

        .resi-number {
            font-size: 8.5pt;
            margin: 2px 0 6px;
            text-align: center;
            font-weight: bold;
        }

        .divider {
            border-top: 1px dashed #000000;
            margin: 5px 0;
            height: 0;
            width: 100%;
        }

        .divider-double {
            border-top: 1px solid #000000;
            margin: 5px 0;
            height: 0;
            width: 100%;
        }

        /* Tabel Struktur Informasi */
        .info-table {
            width: 100%;
            font-size: 8.5pt;
            margin: 2px 0;
            border-collapse: collapse;
            table-layout: fixed;
        }

        .info-table td {
            padding: 2px 0;
            vertical-align: top;
        }

        /* Tabel Daftar Pembelian Produk */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 4px 0;
            font-size: 8.5pt;
            table-layout: fixed;
        }

        .items-table th {
            font-weight: bold;
            padding: 3px 0;
            border-bottom: 1px dashed #000000;
        }

        .items-table td {
            padding: 4px 0;
            vertical-align: top;
        }

        .col-product {
            text-align: left;
            width: 52%;
            word-wrap: break-word;
        }

        .col-qty {
            text-align: center;
            width: 13%;
        }

        .col-price {
            text-align: right;
            width: 35%;
            word-wrap: break-word;
        }

        .total-row td {
            font-weight: bold;
            padding-top: 5px;
            font-size: 9pt;
        }

        .thanks {
            margin: 12px 0;
            font-style: italic;
            font-size: 8.5pt;
            text-align: center;
            line-height: 1.3;
        }

        .footer {
            font-size: 7.5pt;
            margin-top: 6px;
            border-top: 1px dashed #000000;
            padding-top: 4px;
            text-align: center;
            color: #444444;
            line-height: 1.3;
        }
    </style>
</head>
<body>
<div class="receipt">
    <div class="header">
        @if($logo)
            <img src="{{ $logo }}" class="logo" alt="SIMBRO">
        @endif
        <div class="shop-name">{{ $nama_cv }}</div>
        <div class="shop-info">{{ $alamat }}</div>
        <div class="shop-info">Telp: {{ $telepon }}</div>
        <div class="divider-double"></div>
    </div>

    <div class="resi-number">No. Resi: {{ $transaksi->no_resi }}</div>

    <div class="divider"></div>

    <table class="info-table">
        <tr>
            <td style="width: 30%;">Tanggal:</td>
            <td style="text-align: right; width: 70%;">{{ \Carbon\Carbon::parse($transaksi->tanggal_pemesanan)->format('d M Y H:i') }} WIB</td>
        </tr>
        <tr>
            <td style="width: 30%;">Customer:</td>
            <td style="text-align: right; width: 70%;">{{ $transaksi->user->nama_lengkap ?? '-' }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <table class="items-table">
        <thead>
            <tr>
                <th class="col-product">Produk</th>
                <th class="col-qty">Qty</th>
                <th class="col-price">Harga</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($transaksi->details as $detail)
                @php $grandTotal += $detail->total_harga; @endphp
                <tr>
                    <td class="col-product">{{ $detail->produk->nama_produk }}</td>
                    <td class="col-qty">{{ $detail->jumlah }}</td>
                    <td class="col-price">Rp {{ number_format($detail->total_harga, 0, ',', '.') }}</td>
                </tr>
            @endforeach

            <tr>
                <td colspan="3"><div class="divider"></div></td>
            </tr>

            <tr class="total-row">
                <td class="col-product">TOTAL</td>
                <td class="col-qty"></td>
                <td class="col-price">Rp {{ number_format($grandTotal, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="divider-double"></div>

    <table class="info-table">
        <tr>
            <td style="width: 50%;">Metode Pembayaran:</td>
            <td style="text-align: right; width: 50%;">{{ $transaksi->metode_pembayaran ?? '-' }}</td>
        </tr>
        <tr>
            <td style="width: 50%;">Status:</td>
            <td style="text-align: right; width: 50%; font-weight: bold;">{{ ucfirst($transaksi->status->nama_status ?? 'diproses') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="thanks">
        Terima kasih telah berbelanja di SIMBRO.<br>
        Semoga produk kami bermanfaat.
    </div>

    <div class="footer">
        *Resi ini adalah bukti sah pembelian.<br>
        Harap disimpan untuk keperluan pengiriman.
    </div>
</div>
</body>
</html>
