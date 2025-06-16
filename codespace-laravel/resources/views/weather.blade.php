<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>東京の1週間天気予報</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 2em; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background: #f0f0f0; }
    </style>
</head>
<body>
    <h1>東京の1週間天気予報</h1>
    @if(isset($weather['daily']))
        <canvas id="weatherChart" width="600" height="300" style="margin-bottom:2em;"></canvas>
        <table>
            <tr>
                <th>日付</th>
                <th>天気コード</th>
                <th>最高気温 (℃)</th>
                <th>最低気温 (℃)</th>
            </tr>
            @foreach($weather['daily']['time'] as $i => $date)
                <tr>
                    <td>{{ $date }}</td>
                    <td>
                        @php
                            $weatherCodes = [
                                0 => '快晴',
                                1 => '主に晴れ',
                                2 => '晴れ時々曇り',
                                3 => '曇り',
                                45 => '霧',
                                48 => '霧氷',
                                51 => '霧雨',
                                53 => '霧雨',
                                55 => '霧雨',
                                56 => '霧雨（凍結）',
                                57 => '霧雨（凍結）',
                                61 => '小雨',
                                63 => '雨',
                                65 => '大雨',
                                66 => '小雨（凍結）',
                                67 => '大雨（凍結）',
                                71 => '小雪',
                                73 => '雪',
                                75 => '大雪',
                                77 => '雪粒',
                                80 => 'にわか雨',
                                81 => 'にわか雨',
                                82 => '激しいにわか雨',
                                85 => 'にわか雪',
                                86 => '激しいにわか雪',
                                95 => '雷雨',
                                96 => '雷雨（雹）',
                                99 => '雷雨（大きな雹）',
                            ];
                            $code = $weather['daily']['weathercode'][$i];
                        @endphp
                        {{ $weatherCodes[$code] ?? $code }}
                    </td>
                    <td>{{ $weather['daily']['temperature_2m_max'][$i] }}</td>
                    <td>{{ $weather['daily']['temperature_2m_min'][$i] }}</td>
                </tr>
            @endforeach
        </table>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const labels = @json($weather['daily']['time']);
            const tempMax = @json($weather['daily']['temperature_2m_max']);
            const tempMin = @json($weather['daily']['temperature_2m_min']);
            const ctx = document.getElementById('weatherChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: '最高気温 (℃)',
                            data: tempMax,
                            borderColor: 'rgba(255,99,132,1)',
                            backgroundColor: 'rgba(255,99,132,0.2)',
                            fill: false,
                            tension: 0.2
                        },
                        {
                            label: '最低気温 (℃)',
                            data: tempMin,
                            borderColor: 'rgba(54,162,235,1)',
                            backgroundColor: 'rgba(54,162,235,0.2)',
                            fill: false,
                            tension: 0.2
                        }
                    ]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: { position: 'top' },
                        title: { display: true, text: '東京の1週間気温推移' }
                    },
                    scales: {
                        y: { beginAtZero: false }
                    }
                }
            });
        </script>
    @else
        <p>天気情報を取得できませんでした。</p>
    @endif
</body>
</html>
