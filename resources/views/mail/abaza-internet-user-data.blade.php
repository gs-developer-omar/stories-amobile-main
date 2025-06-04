<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=3Ddevice-width, initial-scale=3D1">
    <title>Новая заявка на подключение интернета - Абаза Телеком</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 15px;
            text-align: center;
        }
        .abaza-title{
            font-size: 32px;
        }
        .content {
            padding: 20px;
        }
        .subheader {
            font-size: 18px;
            color: #333;
            margin: 20px 0 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #e8f0fe;
            font-weight: bold;
        }
        .button {
            display: inline-block;
            background-color: #1a73e8;
            color: white !important;
            padding: 12px 24px;
            border-radius: 5px;
            text-decoration: none;
            text-align: center;
            margin: 20px 0;
        }
        .footer {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1 class="abaza-title">Абаза Телеком</h1>
        <h2 class="request-title">Заявка на подключение интернета</h2>
    </div>
    <div class="content">
        <h2 class="subheader">Детали заявки</h2>
        <table>
            <tr>
                <th>Поле</th>
                <th>Информация</th>
            </tr>
            <tr>
                <td>ФИО</td>
                <td>{{ $fio }}</td>
            </tr>
            <tr>
                <td>Телефон</td>
                <td>{{ $phone }}</td>
            </tr>
            <tr>
                <td>Адрес</td>
                <td>{{ $address }}</td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>