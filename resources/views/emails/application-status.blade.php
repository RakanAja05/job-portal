<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f4f4f4;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: {{ $status === 'accepted' ? '#10b981' : '#ef4444' }};
            border-bottom: 3px solid {{ $status === 'accepted' ? '#10b981' : '#ef4444' }};
            padding-bottom: 10px;
        }
        .status-box {
            background: {{ $status === 'accepted' ? '#f0fdf4' : '#fef2f2' }};
            padding: 20px;
            border-left: 4px solid {{ $status === 'accepted' ? '#10b981' : '#ef4444' }};
            margin: 20px 0;
            text-align: center;
        }
        .status-box h2 {
            color: {{ $status === 'accepted' ? '#059669' : '#dc2626' }};
            margin: 0;
            font-size: 24px;
        }
        .info-box {
            background: #f9fafb;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .info-box strong {
            color: #374151;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h1>{{ $status === 'accepted' ? '✅' : '❌' }} Status Lamaran Anda</h1>
        
        <p>Halo {{ $application->user->name }},</p>
        
        <div class="status-box">
            <h2>
                @if($status === 'accepted')
                    🎉 SELAMAT! Lamaran Anda DITERIMA
                @else
                    Mohon Maaf, Lamaran Anda DITOLAK
                @endif
            </h2>
        </div>
        
        <div class="info-box">
            <p><strong>Posisi:</strong> {{ $application->job->title }}</p>
            <p><strong>Perusahaan:</strong> {{ $application->job->company }}</p>
            <p><strong>Lokasi:</strong> {{ $application->job->location }}</p>
            <p><strong>Status:</strong> <span style="color: {{ $status === 'accepted' ? '#059669' : '#dc2626' }}; font-weight: bold;">{{ $status === 'accepted' ? 'DITERIMA' : 'DITOLAK' }}</span></p>
        </div>
        
        @if($status === 'accepted')
        <p>Terima kasih atas lamaran Anda. Kami akan menghubungi Anda lebih lanjut untuk proses selanjutnya.</p>
        <p>Mohon tunggu informasi lebih lanjut melalui email atau telepon yang Anda cantumkan.</p>
        @else
        <p>Terima kasih atas minat Anda untuk bergabung dengan kami. Sayangnya, saat ini kami tidak dapat melanjutkan lamaran Anda.</p>
        <p>Kami mendorong Anda untuk terus mencari peluang lain dan tetap semangat!</p>
        @endif
        
        <div class="footer">
            <p>Email ini dikirim otomatis dari sistem Job Portal</p>
            <p>&copy; {{ date('Y') }} Job Portal. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
