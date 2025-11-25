<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Ubuntu', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; margin: 0; padding: 40px 20px; background: linear-gradient(135deg, #f5f7fa 0%, #e8eef5 100%); }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08); }
        .brand { padding: 20px 30px; background: white; border-bottom: 1px solid #f0f0f0; display: flex; align-items: center; gap: 12px; }
        .brand-logo { height: 40px; }
        .brand-name { margin: 0; font-size: 20px; font-weight: 700; color: #e9580c; }
        .header { background: linear-gradient(135deg, #e9580c 0%, #c74c09 100%); color: white; padding: 40px 30px; position: relative; }
        .header::after { content: ''; position: absolute; bottom: -20px; left: 0; right: 0; height: 20px; background: white; border-radius: 20px 20px 0 0; }
        .header h2 { margin: 0; font-size: 26px; font-weight: 600; }
        .header p { margin: 8px 0 0; opacity: 0.95; font-size: 14px; }
        .content { padding: 30px; }
        .field { margin-bottom: 24px; padding: 20px; background: #f9fafb; border-radius: 12px; border-left: 4px solid #e9580c; }
        .label { font-weight: 600; color: #e9580c; font-size: 12px; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; }
        .value { color: #272727; font-size: 15px; line-height: 1.6; word-wrap: break-word; }
        .footer { padding: 20px 30px; background: #f9fafb; text-align: center; color: #909090; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="brand">
            <img src="{{ asset('img/logoipsum-265.svg') }}" alt="{{ config('app.name') }}" class="brand-logo">
            <h1 class="brand-name">{{ config('app.name') }}</h1>
        </div>
        <div class="header">
            @yield('header')
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            @yield('footer', 'This message was sent via ' . config('app.name'))
        </div>
    </div>
</body>
</html>
