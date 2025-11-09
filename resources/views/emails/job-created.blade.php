<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lowongan Kerja Baru</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color: #f4f4f4; padding: 20px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 40px 30px; border-radius: 10px 10px 0 0; text-align: center;">
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: bold;">
                                🎉 Lowongan Kerja Baru!
                            </h1>
                            <p style="color: #e0e0e0; margin: 10px 0 0 0; font-size: 16px;">
                                Ada peluang karir baru menanti Anda
                            </p>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td style="padding: 40px 30px;">
                            
                            <!-- Job Title -->
                            <h2 style="color: #333333; margin: 0 0 20px 0; font-size: 24px; font-weight: bold;">
                                {{ $job->title }}
                            </h2>

                            <!-- Company Info -->
                            <div style="margin-bottom: 30px;">
                                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <tr>
                                        <td style="padding: 15px; background-color: #f8f9fa; border-radius: 8px;">
                                            <table width="100%">
                                                <tr>
                                                    <td width="30" style="vertical-align: top;">
                                                        <span style="font-size: 24px;">🏢</span>
                                                    </td>
                                                    <td>
                                                        <strong style="color: #333; font-size: 16px;">Perusahaan:</strong><br>
                                                        <span style="color: #666; font-size: 16px;">{{ $job->company }}</span>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Job Details -->
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-bottom: 30px;">
                                <!-- Location -->
                                <tr>
                                    <td style="padding: 10px 0;">
                                        <table>
                                            <tr>
                                                <td width="30" style="vertical-align: top;">
                                                    <span style="font-size: 20px;">📍</span>
                                                </td>
                                                <td>
                                                    <strong style="color: #333; font-size: 14px;">Lokasi:</strong>
                                                    <span style="color: #666; font-size: 14px;">{{ $job->location }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Job Type -->
                                <tr>
                                    <td style="padding: 10px 0;">
                                        <table>
                                            <tr>
                                                <td width="30" style="vertical-align: top;">
                                                    <span style="font-size: 20px;">💼</span>
                                                </td>
                                                <td>
                                                    <strong style="color: #333; font-size: 14px;">Jenis:</strong>
                                                    <span style="display: inline-block; padding: 5px 15px; background-color: {{ $job->type == 'full-time' ? '#dbeafe' : '#e9d5ff' }}; color: {{ $job->type == 'full-time' ? '#1e40af' : '#6b21a8' }}; border-radius: 20px; font-size: 14px; font-weight: bold; margin-left: 10px;">
                                                        {{ ucfirst($job->type) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Salary -->
                                @if($job->salary)
                                <tr>
                                    <td style="padding: 10px 0;">
                                        <table>
                                            <tr>
                                                <td width="30" style="vertical-align: top;">
                                                    <span style="font-size: 20px;">💰</span>
                                                </td>
                                                <td>
                                                    <strong style="color: #333; font-size: 14px;">Gaji:</strong>
                                                    <span style="color: #16a34a; font-weight: bold; font-size: 16px;">Rp {{ number_format($job->salary, 0, ',', '.') }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endif
                            </table>

                            <!-- Description -->
                            <div style="margin-bottom: 30px;">
                                <h3 style="color: #333; font-size: 18px; margin: 0 0 15px 0; font-weight: bold;">
                                    📋 Deskripsi Pekerjaan
                                </h3>
                                <p style="color: #666; line-height: 1.6; font-size: 15px; margin: 0;">
                                    {{ $job->description }}
                                </p>
                            </div>

                            <!-- CTA Button -->
                            <div style="text-align: center; margin: 40px 0 30px 0;">
                                <a href="{{ url('/jobs/' . $job->id) }}" 
                                   style="display: inline-block; 
                                          background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); 
                                          color: #ffffff; 
                                          padding: 15px 40px; 
                                          text-decoration: none; 
                                          border-radius: 50px; 
                                          font-size: 16px; 
                                          font-weight: bold;
                                          box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);">
                                    Lihat Detail Lowongan
                                </a>
                            </div>

                            <!-- Logo (if exists) -->
                            @if($job->logo)
                            <div style="text-align: center; margin-top: 30px; padding-top: 30px; border-top: 2px solid #e5e7eb;">
                                <p style="color: #666; font-size: 14px; margin-bottom: 15px;">Logo Perusahaan:</p>
                                <img src="{{ asset('storage/' . $job->logo) }}" 
                                     alt="{{ $job->company }}" 
                                     style="max-width: 200px; max-height: 100px; border-radius: 8px;">
                            </div>
                            @endif

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8f9fa; padding: 30px; text-align: center; border-radius: 0 0 10px 10px;">
                            <p style="color: #666; font-size: 14px; margin: 0 0 10px 0;">
                                Email ini dikirim secara otomatis dari <strong>Job Portal</strong>
                            </p>
                            <p style="color: #999; font-size: 12px; margin: 0;">
                                &copy; {{ date('Y') }} Job Portal. All rights reserved.
                            </p>
                            <p style="color: #999; font-size: 12px; margin: 10px 0 0 0;">
                                📧 Jangan balas email ini. Untuk informasi lebih lanjut, kunjungi website kami.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
