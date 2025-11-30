<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>API Demo - Job Portal</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="max-w-5xl mx-auto py-10 px-4">
        <h1 class="text-4xl font-bold mb-6 text-blue-700">🔌 Job Portal API Demo</h1>
        <p class="mb-6 text-gray-700">Halaman ini membantu latihan praktikum: melihat dokumentasi, mencoba endpoint dengan token Sanctum, dan contoh perintah <code>curl</code>.</p>

        <div class="grid md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-3">📘 Dokumentasi Swagger</h2>
                <p class="text-gray-600 mb-4">Gunakan Swagger UI untuk eksplor semua endpoint:</p>
                <a href="/api/documentation" target="_blank" class="inline-block bg-gradient-to-r from-blue-600 to-purple-600 text-white px-5 py-3 rounded-lg font-semibold">Buka Swagger UI →</a>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold mb-3">🔐 Token Sanctum</h2>
                <ol class="list-decimal list-inside text-gray-600 space-y-1 mb-4">
                    <li>Register user: <code>POST /api/register</code></li>
                    <li>Login: <code>POST /api/login</code> (copy <code>token</code>)</li>
                    <li>Pakai header: <code>Authorization: Bearer &lt;TOKEN&gt;</code></li>
                </ol>
                <p class="text-sm text-gray-500">Gunakan akun admin untuk CRUD Jobs atau status lamaran.</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">🧪 Contoh Perintah curl</h2>
            <div class="space-y-4 text-sm font-mono bg-gray-900 text-green-200 p-4 rounded">
<pre>curl -X POST http://127.0.0.1:8000/api/register \
 -H "Content-Type: application/json" \
 -d '{"name":"User1","email":"user1@mail.com","password":"password"}'

curl -X POST http://127.0.0.1:8000/api/login \
 -H "Content-Type: application/json" \
 -d '{"email":"user1@mail.com","password":"password"}'

# Ganti <TOKEN>
curl -H "Authorization: Bearer <TOKEN>" http://127.0.0.1:8000/api/jobs

curl http://127.0.0.1:8000/api/public/jobs?keyword=Dev

curl -X POST http://127.0.0.1:8000/api/jobs \
 -H "Authorization: Bearer <ADMIN_TOKEN>" \
 -H "Content-Type: application/json" \
 -d '{"title":"Frontend Dev","description":"Vue/React","location":"Jakarta","company":"ACME","salary":12000000,"type":"full-time"}'

curl -X PATCH http://127.0.0.1:8000/api/applications/1/status \
 -H "Authorization: Bearer <ADMIN_TOKEN>" \
 -H "Content-Type: application/json" \
 -d '{"status":"Accepted"}'</pre>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">🔍 Parameter Pencarian & Filter</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li><code>keyword</code> → cari di <em>title/company/location</em></li>
                <li><code>company</code> → filter company exact</li>
                <li><code>location</code> → filter lokasi exact</li>
                <li><code>type</code> → <code>full-time</code> atau <code>part-time</code></li>
                <li><code>page</code>, <code>per_page</code> → pagination</li>
            </ul>
            <p class="mt-3 text-sm text-gray-500">Contoh: <code>/api/jobs?keyword=Dev&company=ACME&location=Jakarta&page=1&per_page=5</code></p>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h2 class="text-2xl font-bold mb-4">✅ Checklist Praktikum</h2>
            <ul class="list-disc list-inside text-gray-700 space-y-1">
                <li>Register & Login (token diperoleh)</li>
                <li>List jobs (protected) & public jobs</li>
                <li>Search + filter + pagination</li>
                <li>Create job (admin)</li>
                <li>Apply job (upload CV)</li>
                <li>List applications (admin)</li>
                <li>PATCH status lamaran (Accepted/Rejected)</li>
                <li>Buka Swagger & screenshot</li>
            </ul>
        </div>

        <div class="text-center text-gray-500 text-sm">
            &copy; 2025 Job Portal API Demo
        </div>
    </div>
</body>
</html>