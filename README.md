# drop-meli-api

## Instruções extras
O projeto foi criado usando o framework Laravel sendo conteirizado com docker, por meio do Sail.

Para iniciar, primeiro faça o clone da aplicação, e siga as demais instruções:

Copie o arquivo .env.example e cole como .env e faça as configurações das variáveis:

```
APP_PORT=8083
```

```
MELI_BASE_URL=https://api.mercadolibre.com
```

```
MELI_AUTH_URL=https://auth.mercadolivre.com.br
```

```
MELI_REDIRECT_URI=/redirect
```

```
MELI_CLIENT_ID=3424744139640412
```

```
MELI_CLIENT_SECRET=wOFxeLWes45n6QK4YcE2yYGiidJGWNdE
```

```
FORWARD_DB_PORT=3303
```

No terminal, dentro da pasta do projeto, rode para iniciar a aplicação:

```
./vendor/bin/sail up -d
```

No terminal, rode:

```
./vendor/bin/sail composer install
```

No terminal, rode:

```
./vendor/bin/sail php artisan key:generate
```

Depois, rode:

```
./vendor/bin/sail php artisan migrate
```

OBS: O projeto não se encontra finalizado, mas a estrutura em si, estava quase no fim.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
