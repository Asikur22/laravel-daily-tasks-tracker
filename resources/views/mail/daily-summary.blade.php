<!DOCTYPE html>
<html>
<head>
    <title>Daily Summary</title>
</head>
<body style="font-family: sans-serif; background-color: #f3f4f6; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h1 style="color: #1f2937; text-align: center;">Daily Task Summary</h1>
        
        <p style="color: #4b5563; font-size: 16px;">Hello {{ $data['name'] }},</p>
        
        <p style="color: #4b5563; font-size: 16px;">Here is your productivity summary for today, <strong>{{ $data['date'] }}</strong>:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <div style="display: inline-block; padding: 20px; background-color: #eff6ff; border-radius: 50%; width: 100px; height: 100px; line-height: 100px;">
                <span style="font-size: 32px; font-weight: bold; color: #3b82f6;">{{ $data['percentage'] }}%</span>
            </div>
            <p style="color: #6b7280; margin-top: 10px;">Completion Rate</p>
        </div>
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; color: #374151;">Total Tasks Scheduled</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: bold; color: #111827;">{{ $data['total'] }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; color: #374151;">Completed</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: bold; color: #10b981;">{{ $data['completed'] }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; color: #374151;">Exempt</td>
                <td style="padding: 10px; border-bottom: 1px solid #e5e7eb; text-align: right; font-weight: bold; color: #9ca3af;">{{ $data['exempt'] }}</td>
            </tr>
        </table>
        
        @if($data['percentage'] == 100)
            <p style="color: #059669; font-weight: bold; text-align: center;">🎉 Perfect score! Amazing job today!</p>
        @elseif($data['percentage'] >= 80)
            <p style="color: #059669; text-align: center;">Great work! You were very productive.</p>
        @elseif($data['percentage'] >= 50)
            <p style="color: #d97706; text-align: center;">Good effort. Let's aim higher tomorrow!</p>
        @else
            <p style="color: #dc2626; text-align: center;">Tough day? Don't worry, tomorrow is a fresh start.</p>
        @endif
        
        <div style="margin-top: 30px; text-align: center;">
            <a href="{{ route('dashboard') }}" style="background-color: #3b82f6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Go to Dashboard</a>
        </div>
        
        <p style="color: #9ca3af; font-size: 12px; text-align: center; margin-top: 40px;">
            Daily Task Tracker Application
        </p>
    </div>
</body>
</html>
