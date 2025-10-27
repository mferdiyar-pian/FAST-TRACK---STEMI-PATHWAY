<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kirim Broadcast WhatsApp - Fonnte</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light py-5">
<div class="container">
    <h2 class="mb-4 text-center">📢 Kirim Broadcast WhatsApp (Fonnte)</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('broadcast.send') }}" method="POST" class="mb-5">
        @csrf
        <div class="mb-3">
            <label for="message" class="form-label fw-bold">Pesan Broadcast</label>
            <textarea name="message" id="message" class="form-control" rows="4" placeholder="Tulis pesan di sini..." required></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100 py-2">Kirim ke Semua Nakes</button>
    </form>

    <h5>📋 Daftar Tenaga Kesehatan yang Akan Dikirimi Pesan:</h5>
    <table class="table table-striped mt-3 align-middle">
        <thead class="table-success">
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Nomor Kontak</th>
                <th>Tanggal Diterima</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nakes as $index => $n)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $n->nama }}</td>
                    <td>{{ $n->status }}</td>
                    <td>{{ $n->contact }}</td>
                    <td>{{ $n->admitted_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
