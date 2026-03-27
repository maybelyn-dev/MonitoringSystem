<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Regional Statistics Report</title>
    <style>
        body { font-family: Arial, Helvetica, sans-serif; font-size: 10px; color: #0f172a; }
        table { width: 100%; border-collapse: collapse; }
        thead th { background: #1e40af; color: #ffffff; font-size: 10px; padding: 6px; text-align: left; }
        tbody td { padding: 6px; border-bottom: 1px solid #e2e8f0; }
        tbody tr:nth-child(even) { background: #eff6ff; }
        .right { text-align: right; }
        .title { font-weight: 800; color: #1e40af; margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="title">REGIONAL STATISTICS REPORT - REGION III</div>
    <table>
        <thead>
            <tr>
                <th>Province</th>
                <th class="right">Private</th>
                <th class="right">For Hire</th>
                <th class="right">Government</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $province => $row)
                <tr>
                    <td>{{ $province }}</td>
                    <td class="right">{{ $row['private'] }}</td>
                    <td class="right">{{ $row['for_hire'] }}</td>
                    <td class="right">{{ $row['government'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
