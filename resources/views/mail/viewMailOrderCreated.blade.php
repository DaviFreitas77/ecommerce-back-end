<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Confirmado - Bazar Virtual</title>
    <style>
        body {
            background-color: #f6f9fc;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }

        .wrapper {
            width: 100%;
            table-layout: fixed;
            background-color: #f6f9fc;
            padding-bottom: 40px;
            padding-top: 40px;

        }

        .main-table {
            background-color: #ffffff;
            margin: 0 auto;
            width: 100%;
            max-width: 600px;
            border-spacing: 0;
            color: #4a4a4a;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .header {
            background-color: #A2785A;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 18px;
            letter-spacing: 1px;
        }

        .content {
            padding: 30px;
        }

        .greeting {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
        }

        .status {
            background-color: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            text-align: center;
            margin: 20px 0;
        }

        .order-card {
            background-color: #f9fafb;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-top: 20px;
        }

        .order-title {
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #9ca3af;
            margin-bottom: 15px;
            display: block;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .label {
            font-weight: 600;
            color: #4b5563;
        }

        .value {
            color: #111827;
        }

        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <table class="main-table">
            <tr>
                <td class="header">
                    <h1>Bazar virtual</h1>
                </td>
            </tr>

            <tr>
                <td class="content">
                    <p class="greeting">Olá, {{ $name }}!</p>
                    <p>Recebemos o pagamento do seu pedido com sucesso.
                        Agora estamos preparando tudo para o envio.</p>

                    <div class="status">
                        ✔ Pagamento aprovado
                    </div>

                    @foreach($products as $product)
                    <table width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                        <tr>
                            <td width="90">
                                @if(!empty($product['image']))
                                <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" width="80" height="110">
                                @endif
                            </td>
                            <td valign="top" >
                                <p style="margin:0; font-weight:bold; font-size:14px; color:#333;">{{ $product['name'] }}</p>
                                <p style="margin:2px 0 0 0; font-size:13px; color:#555;">Cor: {{ $product['color'] }}</p>
                                <p style="margin:2px 0 0 0; font-size:13px; color:#555;">Quantidade: {{ $product['quantity'] }}</p>
                                <p style="margin:2px 0 0 0; font-size:13px; color:#555;">Preço: R$ {{ number_format($product['price'], 2, ',', '.') }}</p>
                            </td>
                        </tr>
                    </table>
                    @endforeach





                </td>
            </tr>

            <tr>
                <td class="footer">
                    &copy; 2025 Bazar Virtual. Todos os direitos reservados.
                </td>
            </tr>
        </table>
    </div>
</body>

</html>