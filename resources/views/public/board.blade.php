<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60">
    <title>Canlı Nöbet Panosu</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        :root {
            --bg-dark: rgb(15, 23, 42);
            --card-bg: rgba(30, 41, 59, 0.7);
            --primary-gradient: linear-gradient(135deg, rgb(79, 70, 229) 0%, rgb(147, 51, 234) 100%);
            --text-main: rgb(248, 250, 252);
            --text-muted: rgb(148, 163, 184);
            --border-color: rgba(255, 255, 255, 0.1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; user-select: none; }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--bg-dark);
            color: var(--text-main);
            min-height: 100vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(79, 70, 229, 0.15) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(147, 51, 234, 0.15) 0%, transparent 50%);
        }

        .tv-container {
            padding: 20px;
            height: 100vh;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .top-banner {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(25px);
            border: 1px solid var(--border-color);
            border-radius: 30px;
            padding: 24px 45px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .brand-logo {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .icon-shield {
            width: 70px;
            height: 70px;
            background: var(--primary-gradient);
            border-radius: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            color: #fff;
            box-shadow: 0 10px 25px rgba(79, 70, 229, 0.5);
        }

        .brand-info h1 {
            font-size: 30px;
            font-weight: 900;
            letter-spacing: -1px;
            margin: 0;
            text-transform: uppercase;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .brand-info p {
            font-size: 15px;
            color: var(--text-muted);
            margin: 0;
            font-weight: 700;
            letter-spacing: 2px;
        }

        .clock-display {
            text-align: right;
        }

        .time-text {
            font-size: 48px;
            font-weight: 900;
            letter-spacing: -1px;
            line-height: 1;
            margin-bottom: 5px;
            color: #fff;
        }

        .date-text {
            font-size: 18px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .periods-grid {
            flex: 1;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            min-height: 0;
        }

        .board-card {
            background: var(--card-bg);
            backdrop-filter: blur(15px);
            border: 1px solid var(--border-color);
            border-radius: 40px; /* More rounded */
            display: flex;
            flex-direction: column;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        }

        .board-card-header {
            padding: 20px 25px;
            border-bottom: 1.5px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .header-morning { background: rgba(245, 158, 11, 0.12); }
        .header-noon { background: rgba(16, 185, 129, 0.12); }
        .header-afternoon { background: rgba(99, 102, 241, 0.12); }

        .header-label {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .header-label i { font-size: 28px; color: var(--text-main); }
        .header-label h2 { 
            font-size: 18px; 
            margin: 0; 
            font-weight: 900; 
            text-transform: uppercase; 
            letter-spacing: 1.2px; 
        }

        .time-pill {
            font-size: 14px;
            font-weight: 900;
            padding: 8px 20px;
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            border: 1px solid rgba(255,255,255,0.1);
        }

        .scrollable-body {
            flex: 1;
            overflow-y: auto;
        }

        .duty-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .duty-table th {
            position: sticky;
            top: 0;
            background: rgba(15, 23, 42, 0.98);
            padding: 20px 40px;
            text-align: left;
            font-size: 13px;
            font-weight: 900;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 2px;
            border-bottom: 1.5px solid var(--border-color);
            z-index: 10;
        }

        .duty-table td {
            padding: 15px 25px;
            border-bottom: 1px solid var(--border-color);
        }

        .duty-table tr:nth-child(even) { background: rgba(255, 255, 255, 0.02); }

        .teacher-cell .name { 
            display: block;
            font-weight: 900; 
            color: #fff; 
            font-size: 16px;
            margin-bottom: 2px;
            white-space: nowrap;
        }
        .teacher-cell .meta { 
            display: flex; 
            align-items: center; 
            gap: 10px;
            font-size: 12px; 
            color: var(--text-muted); 
            font-weight: 700;
            text-transform: uppercase;
        }

        .location-column { min-width: 120px; }
        .location-text { font-weight: 900; color: rgb(129, 140, 248); font-size: 15px; display: block; margin-bottom: 3px; }
        .floor-tag {
            display: inline-block;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid var(--border-color);
            color: #fff;
            padding: 5px 12px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .pulse-dot {
            width: 10px;
            height: 10px;
            background: #22c55e;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 10px #22c55e;
            animation: pulse-green 2s infinite;
        }

        @keyframes pulse-green {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
        }

        /* Güvenlik Kalkanı */
        #safety-block {
            display: none;
            position: fixed;
            inset: 0;
            background: var(--bg-dark);
            z-index: 100000;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #fff;
        }

        .ticker-bar {
            background: var(--primary-gradient);
            padding: 15px;
            color: #fff;
            font-weight: 900;
            font-size: 16px;
            text-transform: uppercase;
            letter-spacing: 2.5px;
            text-align: center;
            box-shadow: 0 -15px 40px rgba(79, 70, 229, 0.4);
            border-radius: 25px 25px 0 0;
            margin: 0 40px;
        }
    </style>
</head>
<body>


    <div class="tv-container">
        <header class="top-banner">
            <div class="brand-logo">
                <div class="icon-shield">
                    <i class="bi bi-broadcast"></i>
                </div>
                <div class="brand-info">
                    <h1>NÖBET KONTROL MERKEZİ</h1>
                    <p>Canlı Görev ve Planlama Panosu</p>
                </div>
            </div>
            
            <div class="clock-display">
                <div class="time-text" id="liveClock">00:00:00</div>
                <div class="date-text">
                    <span id="liveDate">{{ $today->translatedFormat('d F Y') }}</span>
                    <span class="opacity-25 mx-3">|</span>
                    <span class="text-white fw-bold">{{ $schedule->day_of_week ?? $today->translatedFormat('l') }}</span>
                </div>
                <a href="{{ route('login') }}" class="btn-login" style="display:inline-block;margin-top:8px;padding:8px 20px;background:var(--primary-gradient);color:#fff;text-decoration:none;border-radius:30px;font-weight:800;font-size:13px;letter-spacing:1px;text-transform:uppercase;box-shadow:0 8px 20px rgba(79,70,229,0.4);transition:all 0.3s;">Giriş Yap</a>
            </div>
        </header>

        <main class="periods-grid">
            @php
                $grouped = $schedule ? $schedule->assignments->groupBy('period') : collect();
                $periods = [
                    'morning' => ['label' => 'Sabah', 'time' => '08:00 - 11:30', 'cls' => 'header-morning', 'icon' => 'bi-brightness-high-fill'],
                    'noon' => ['label' => 'Öğle', 'time' => '11:30 - 13:30', 'cls' => 'header-noon', 'icon' => 'bi-sun-fill'],
                    'afternoon' => ['label' => 'İkindi', 'time' => '13:30 - 17:20', 'cls' => 'header-afternoon', 'icon' => 'bi-cloud-moon-fill']
                ];
            @endphp

            @foreach($periods as $id => $item)
                <div class="board-card">
                    <div class="board-card-header {{ $item['cls'] }}">
                        <div class="header-label">
                            <i class="bi {{ $item['icon'] }}"></i>
                            <h2>{{ $item['label'] }}</h2>
                        </div>
                        <div class="time-pill">{{ $item['time'] }}</div>
                    </div>
                    <div class="scrollable-body">
                        @if($grouped->has($id))
                            <table class="duty-table">
                                <tbody>
                                    @foreach($grouped[$id]->sortBy('location.name') as $assign)
                                        <tr>
                                            <td class="teacher-cell">
                                                <span class="name">
                                                    @if($assign->status === 'assigned')
                                                        <span class="pulse-dot me-2"></span>
                                                    @endif
                                                    {{ $assign->teacher->name }}
                                                </span>
                                                <div class="meta">
                                                    <i class="bi bi-bookmark-fill" style="font-size: 8px;"></i>
                                                    {{ $assign->teacher->branch }}
                                                </div>
                                            </td>
                                            <td class="location-column">
                                                <span class="location-text">{{ $assign->location->name }}</span>
                                                <small class="text-white-50 d-block mt-1" style="font-size: 11px;">{{ $assign->location->branch ?? '' }}</small>
                                            </td>
                                            <td class="text-end pe-4">
                                                <div class="text-white-50 fw-black" style="font-size: 11px; letter-spacing: 0.5px;">
                                                    <i class="bi bi-layers me-1 opacity-50"></i>{{ $assign->location->floor ?? 'ZM' }}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <div style="height: 100%; display: flex; flex-direction: column; align-items: center; justify-content: center; opacity: 0.15;">
                                <i class="bi bi-slash-circle-fill" style="font-size: 90px; margin-bottom: 25px;"></i>
                                <h4 style="font-weight: 800; letter-spacing: 2px;">KAYITLI GÖREV YOK</h4>
                                <p class="small opacity-50 mt-2">Bu periyot için henüz planlama yapılmadı.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </main>
    </div>


    <script>
        function updateTime() {
            const now = new Date();
            document.getElementById('liveClock').textContent = now.toLocaleTimeString('tr-TR', { hour12: false });
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>
</html>
