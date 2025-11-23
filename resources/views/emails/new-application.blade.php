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
            color: #2563eb;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 10px;
        }
        .info-box {
            background: #f0f9ff;
            padding: 15px;
            border-left: 4px solid #2563eb;
            margin: 20px 0;
        }
        .info-box strong {
            color: #1e40af;
        }
        .download-button {
            display: inline-block;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 6px;
            font-weight: bold;
            margin: 20px 0;
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
        <h1>🔔 Lamaran Baru Masuk!</h1>
        
        <p>Halo Admin,</p>
        
        <p>Ada lamaran baru yang perlu Anda review:</p>
        
        <div class="info-box">
            <p><strong>Nama Pelamar:</strong> {{ $application->user->name }}</p>
            <p><strong>Email:</strong> {{ $application->user->email }}</p>
            <p><strong>Posisi:</strong> {{ $application->job->title }}</p>
            <p><strong>Perusahaan:</strong> {{ $application->job->company }}</p>
            <p><strong>Tanggal Melamar:</strong> {{ $application->created_at->format('d F Y, H:i') }}</p>
        </div>
        
        <p><strong>Download CV Pelamar:</strong></p>
        <a href="{{ url('storage/' . $application->cv) }}" class="download-button">
            📄 Download CV
        </a>
        
        <p>Atau klik link berikut:</p>
        <p><a href="{{ url('storage/' . $application->cv) }}">{{ url('storage/' . $application->cv) }}</a></p>
        
        <p>Silakan login ke dashboard admin untuk mereview dan memberikan keputusan.</p>
        
        <div class="footer">
            <p>Email ini dikirim otomatis dari sistem Job Portal</p>
            <p>&copy; {{ date('Y') }} Job Portal. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
