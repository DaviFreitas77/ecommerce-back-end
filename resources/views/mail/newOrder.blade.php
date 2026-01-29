<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Novo pedido - Bazar</title>
</head>

<body style="
  margin:0;
  padding:0;
  background-color:#f6f9fc;
  font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;
">

  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" style="padding:20px 10px;">

        <!-- Card -->
        <table width="100%" cellpadding="0" cellspacing="0" style="
          background:#ffffff;
          border-radius:14px;
          box-shadow:0 6px 20px rgba(0,0,0,0.06);
          overflow:hidden;
        ">

          <!-- Header -->
          <tr>
            <td style="
              background:#A2785A;
              padding:24px;
              text-align:center;
            ">
              <h1 style="
                margin:0;
                color:#ffffff;
                font-size:20px;
                letter-spacing:1px;
              ">
                Novo Pedido Recebido
              </h1>
            </td>
          </tr>

          <!-- Conteúdo -->
          <tr>
            <td style="padding:32px; color:#1f2937;">

              <p style="margin:0 0 12px; font-size:16px; font-weight:600;">
                Pedido #{{ $numberOrder }}
              </p>

              <!-- Dados do cliente -->
              <div style="
                background:#f9fafb;
                border:1px solid #e5e7eb;
                border-radius:12px;
                padding:16px;
                margin-bottom:24px;
                font-size:14px;
              ">
                <p style="margin:0 0 6px;"><strong>Cliente:</strong> {{ $name }}</p>
                <p style="margin:0;"><strong>Telefone:</strong> {{ $tel }}</p>
              </div>

              <!-- Produtos -->
              <p style="
                margin:0 0 12px;
                font-size:15px;
                font-weight:600;
                color:#A2785A;
              ">
                Produtos
              </p>

              @foreach($products as $product)
              <table width="100%" cellpadding="0" cellspacing="0" style="
                margin-bottom:16px;
                background:#ffffff;
                border:1px solid #e5e7eb;
                border-radius:10px;
              ">
                <tr>
                  <td width="90" style="padding:12px;">
                    @if(!empty($product['image']))
                    <img src="{{ $product['image'] }}" width="80" style="
                      display:block;
                      border-radius:8px;
                    ">
                    @endif
                  </td>

                  <td style="padding:12px 12px 12px 0; font-size:13px;">
                    <p style="margin:0; font-weight:600; font-size:14px;">
                      {{ $product['name'] }}
                    </p>
                    <p style="margin:4px 0 0; color:#6b7280;">
                      Cor: {{ $product['color'] }}
                    </p>
                    <p style="margin:2px 0 0; color:#6b7280;">
                      Quantidade: {{ $product['quantity'] }}
                    </p>
                    <p style="margin:6px 0 0; font-weight:600;">
                      R$ {{ number_format($product['price'], 2, ',', '.') }}
                    </p>
                  </td>
                </tr>
              </table>
              @endforeach

              <!-- Resumo -->
              <div style="
                margin-top:24px;
                padding:18px;
                background:#f9fafb;
                border-radius:12px;
                border:1px solid #e5e7eb;
                font-size:14px;
              ">
                <p style="margin:0 0 8px;"><strong>Total do pedido</strong></p>
                <p style="
                  margin:0;
                  font-size:18px;
                  font-weight:700;
                  color:#3b2f2f;
                ">
                  R$ 150,00
                </p>

                <p style="margin:8px 0 0; font-size:13px; color:#6b7280;">
                  credito
                </p>
              </div>

            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="
              padding:18px;
              text-align:center;
              font-size:12px;
              color:#9ca3af;
              border-top:1px solid #f1f5f9;
            ">
              © 2025 Bazar Virtual — Novo pedido recebido
            </td>
          </tr>

        </table>

      </td>
    </tr>
  </table>

</body>

</html>