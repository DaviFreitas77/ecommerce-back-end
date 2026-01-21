#  E-commerce Back-end API

 Este projeto é um back-end robusto desenvolvido em **Laravel**, projetado para fornecer toda a infraestrutura necessária para uma loja virtual moderna, incluindo gerenciamento de produtos, carrinho de compras, pedidos e integração de pagamentos.

##  Tecnologias Utilizadas

-   **Linguagem:** PHP 8.x
-   **Framework:** Laravel
-   **Banco de Dados:** MySQL
-   **Autenticação:** Laravel Auth
-   **Pagamentos:** SDK do Mercado Pago
-   **Documentação da API:** Dedoc Scramble
-   **Cliente HTTP:** Guzzle (Integração ViaCEP)

##  Funcionalidades Principais

###  Usuários e Autenticação

-   Registro e Login de usuários.
-   Autenticação via token
-   Integração com **Google OAuth**.
-   Gerenciamento de perfil e endereços.

###  Produtos e Catálogo

-   CRUD de Produtos, Categorias, Cores e Tamanhos.
-   Upload e gerenciamento de imagens de produtos.
-   Busca de produtos e recomendações.
-   Controle de variações (Cor/Tamanho).

###  Carrinho de Compras

-   Adicionar/Remover itens.
-   Sincronização de carrinho (útil para manter o estado entre dispositivos).
-   Cálculo automático de totais.

###  Pagamentos e Pedidos

-   **Integração com Mercado Pago:**
    -   Pagamentos via **Pix**.
    -   Pagamentos via **Cartão de Crédito**.
    -   Criação de Preferências de pagamento.
-   **Webhooks:** Atualização automática do status do pedido (Aprovado, Processando, Cancelado) via notificações do Mercado Pago.
-   Histórico de pedidos do usuário.
-   Limpeza automática de pedidos expirados.

###  Cupons de Desconto

-   Criação e gerenciamento de cupons.
-   Validação de validade e limite de uso.
-   Cupons de primeira compra.

###  Endereços

-   Integração com a API **ViaCEP** para preenchimento automático de endereços pelo CEP.

##  Configuração e Instalação

1. **Clone o repositório:**

```bash
git clone https://github.com/seu-usuario/ecommerce-back-end.git
cd ecommerce-back-end
```

2. **Instale as dependências:**

```bash
composer install
```

3. **Configure o ambiente:**

Copie o arquivo `.env.example` para `.env` e configure suas credenciais de banco de dados e chaves de API.

```bash
cp .env.example .env
```

4. **Gere a chave da aplicação:**

```bash
php artisan key:generate
```

5. **Execute as migrações:**

```bash
php artisan migrate
```

6. **Execute o seed:**

```bash
php artisan db:seed
```

7. **Inicie o servidor:**

```bash
php artisan serve
```


8. **Documentação da API em**

```bash
localhost:8000/docs/api
```
##  Variáveis de Ambiente Importantes

Certifique-se de configurar as seguintes chaves no seu arquivo `.env`:

```env

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=
MAIL_FROM_NAME="${APP_NAME}"



DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=usuario
DB_PASSWORD=senha

MERCADO_PAGO_ACCESS_TOKEN=seu_access_token_aqui
GOOGLE_CLIENT_ID=seu_client_id_aqui
GOOGLE_CLIENT_SECRET=seu_client_secret_aqui
```

