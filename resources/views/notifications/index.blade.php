<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifikasi - Admin Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .header {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            margin-bottom: 30px;
        }
        .header h1 {
            color: #667eea;
            font-size: 32px;
            margin-bottom: 10px;
        }
        .stats {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            flex: 1;
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }
        .stat-card .number {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
        }
        .notification-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-left: 5px solid #667eea;
            transition: transform 0.2s;
        }
        .notification-card:hover {
            transform: translateX(5px);
        }
        .notification-card.unread {
            background: #f0f4ff;
            border-left-color: #10b981;
        }
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 15px;
        }
        .notification-title {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
        .notification-badge {
            background: #10b981;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        .notification-message {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        .notification-details {
            display: flex;
            gap: 15px;
            font-size: 14px;
            color: #999;
            margin-bottom: 15px;
        }
        .notification-actions {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s;
        }
        .btn:hover {
            transform: translateY(-2px);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-success {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
        }
        .btn-secondary {
            background: #6b7280;
            color: white;
        }
        .alert {
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .alert-success {
            background: #d1fae5;
            color: #065f46;
            border-left: 4px solid #10b981;
        }
        .back-link {
            color: white;
            text-decoration: none;
            font-size: 16px;
            display: inline-block;
            margin-bottom: 20px;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .empty-state {
            background: white;
            padding: 60px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .empty-state h2 {
            color: #667eea;
            margin-bottom: 10px;
        }
        .empty-state p {
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('admin.applications') }}" class="back-link">← Kembali ke Applications</a>
        
        <div class="header">
            <h1>🔔 Notifikasi</h1>
            <p style="color: #666;">Daftar notifikasi lamaran baru</p>
        </div>

        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <div class="stats">
            <div class="stat-card">
                <h3>TOTAL NOTIFIKASI</h3>
                <div class="number">{{ $notifications->count() }}</div>
            </div>
            <div class="stat-card">
                <h3>BELUM DIBACA</h3>
                <div class="number" style="color: #10b981;">{{ $unreadCount }}</div>
            </div>
            <div class="stat-card" style="display: flex; align-items: center; justify-content: center;">
                <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success" style="padding: 15px 30px;">
                        ✓ Tandai Semua Sudah Dibaca
                    </button>
                </form>
            </div>
        </div>

        @if($notifications->count() > 0)
            @foreach($notifications as $notification)
            <div class="notification-card {{ !$notification->is_read ? 'unread' : '' }}">
                <div class="notification-header">
                    <div class="notification-title">
                        {{ $notification->title }}
                    </div>
                    @if(!$notification->is_read)
                    <span class="notification-badge">BARU</span>
                    @endif
                </div>
                
                <div class="notification-message">
                    {{ $notification->message }}
                </div>
                
                <div class="notification-details">
                    <span>📅 {{ $notification->created_at->format('d F Y, H:i') }}</span>
                    <span>👤 {{ $notification->application->user->name }}</span>
                    <span>📧 {{ $notification->application->user->email }}</span>
                </div>
                
                <div class="notification-actions">
                    <a href="{{ url('storage/' . $notification->application->cv) }}" class="btn btn-primary" target="_blank">
                        📄 Download CV
                    </a>
                    <a href="{{ route('admin.applications') }}" class="btn btn-secondary">
                        👁️ Lihat Detail
                    </a>
                    @if(!$notification->is_read)
                    <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            ✓ Tandai Dibaca
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endforeach
        @else
            <div class="empty-state">
                <h2>📭 Belum Ada Notifikasi</h2>
                <p>Notifikasi akan muncul ketika ada lamaran baru masuk</p>
            </div>
        @endif
    </div>
</body>
</html>
