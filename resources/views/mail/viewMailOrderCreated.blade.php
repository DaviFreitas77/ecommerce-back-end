<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Pedido Confirmado - Bazar Virtual</title>
</head>

<body style="
  margin:0;
  padding:0;
  background-color:#f6f9fc;
  font-family:'Helvetica Neue', Helvetica, Arial, sans-serif;
">

  <div style="
  max-width:600px;
  margin:0 auto;
  padding:32px 24px;
  font-family:'Segoe UI', Helvetica, Arial, sans-serif;
  background:#ffffff;
  color:#1f2937;
  text-align:center;
">

    <!-- Logo -->
    <p style="
    font-size:22px;
    font-weight:600;
    letter-spacing:2px;
    margin-bottom:32px;
  ">
      BAZAR
    </p>

    <!-- Título -->
    <h1 style="
    font-size:26px;
    font-weight:600;
    margin-bottom:12px;
    color:#3b2f2f;
  ">
      Seu pedido foi realizado
    </h1>

    <!-- Subtítulo -->
    <p style="
    font-size:16px;
    font-weight:500;
    margin-bottom:24px;
    color:#6b4e3d;
  ">
      Novidades escolhidas com carinho para você
    </p>

    <!-- Texto -->
    <p style="
    font-size:14px;
    line-height:1.7;
    margin-bottom:28px;
    color:#4b5563;
  ">
      {{$name}} seu pedido <strong>#650050</strong> foi confirmado.<br>
      Em breve, peças únicas do nosso bazar chegam até você,
      cheias de estilo e história.
    </p>

    <!-- Botão -->
    <a href="http://localhost:5173/pedidos" style="
    display:inline-block;
    background:#d39b72;
    color:#ffffff;
    text-decoration:none;
    padding:14px 28px;
    border-radius:999px;
    font-size:14px;
    font-weight:500;
  ">
      Acompanhar pedido
    </a>


    @foreach($products as $product)
    <table width="100%" cellpadding="0" cellspacing="0" style="
  margin:24px 0;
  background:#f9fafb;
  border-radius:12px;
  padding:16px;
">
      <tr>
        <!-- Imagem -->
        <td width="90" valign="top" style="padding-right:16px;">
          @if(!empty($product['image']))
          <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" width="80" height="110" style="
            border-radius:8px;
            object-fit:cover;
            display:block;
          ">
          @endif
        </td>

        <!-- Infos -->
        <td valign="top" style="text-align:left;">
          <p style="
        margin:0 0 6px 0;
        font-size:14px;
        font-weight:600;
        color:#1f2937;
      ">
            {{ $product['name'] }}
          </p>

          <p style="margin:2px 0; font-size:13px; color:#6b7280;">
            Cor: {{ $product['color'] }}
          </p>

          <p style="margin:2px 0; font-size:13px; color:#6b7280;">
            Quantidade: {{ $product['quantity'] }}
          </p>

          <p style="
        margin-top:8px;
        font-size:14px;
        font-weight:600;
        color:#3b2f2f;
      ">
            R$ {{ number_format($product['price'], 2, ',', '.') }}
          </p>
        </td>
      </tr>
    </table>
    @endforeach

    <!-- Resumo do Pedido -->
    <div style="
  margin-top:32px;
  padding:20px;
  background:#f9fafb;
  border-radius:12px;
  text-align:left;
">

      <p style="
    margin:0 0 12px 0;
    font-size:15px;
    font-weight:600;
    color:#1f2937;
  ">
        Resumo do pedido
      </p>

      <!-- Subtotal -->
      <div style="display:flex; justify-content:space-between; margin-bottom:6px;">
        <span style="font-size:13px; color:#6b7280;">Subtotal</span>
        <span style="font-size:13px; color:#374151;">
          R$ 150,00
        </span>
      </div>



      <hr style="border:none; border-top:1px solid #e5e7eb; margin:12px 0;">

      <!-- Total -->
      <div style="display:flex; justify-content:space-between;">
        <span style="
      font-size:15px;
      font-weight:600;
      color:#1f2937;
    ">
          Total
        </span>

        <span style="
      font-size:16px;
      font-weight:700;
      color:#3b2f2f;
    ">
          R$ 150,00
        </span>
      </div>
    </div>

    <!-- Método de Pagamento -->
    <div style="
  margin-top:20px;
  padding:16px;
  background:#ecfdf5;
  border-radius:12px;
  text-align:left;
">

      <p style="
    margin:0 0 6px 0;
    font-size:14px;
    font-weight:600;
    color:#065f46;
  ">
        Método de pagamento
      </p>

      <p style="
    margin:0;
    font-size:13px;
    color:#047857;
  ">
        Credito
      </p>

    </div>
  </div>


</body>

</html>