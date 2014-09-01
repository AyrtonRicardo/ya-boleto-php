# Yet Another Boleto


[![Build Status](https://travis-ci.org/umbrellaTech/ya-boleto-php.png?branch=master)](https://travis-ci.org/umbrellaTech/ya-boleto-php)
[![Latest Stable Version](https://poser.pugx.org/umbrella/boleto/v/stable.png)](https://packagist.org/packages/umbrella/boleto)
[![Latest Unstable Version](https://poser.pugx.org/umbrella/boleto/v/unstable.png)](https://packagist.org/packages/umbrella/boleto)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/1f67b9bd-f120-43d5-9f02-f73aa6132d86/small.png)](https://insight.sensiolabs.com/projects/1f67b9bd-f120-43d5-9f02-f73aa6132d86)

O YaBoleto e um novo componete de boleto bancario em PHP, mas qual a diferença dos outros? Simples... Ele foi projetado de forma simples e Orientada a Objetos.
Seguimos os padrões PSR-0, PSR-1 e PSR-2, utilizamos padrões de projetos onde seria necessário e Voilà. O Ya Boleto vai mudar a forma de como você trabalha com boletos bancários.

Quer utilizar o YaBoleto? Leia nossa [documentaçao][2] e veja como é simples.

## Instalação
### Composer
Se você já conhece o **Composer** (o que é extremamente recomendado), simplesmente adicione a dependência abaixo à diretiva *"require"* no seu **composer.json**:
```
"umbrella/boleto": "1.4.0"
```

Sim, só isso! Lembre-se de que cada banco possui alguma particularidade, mas em geral são estes parâmetros os obrigatórios. 

O projeto [umbrellaTech/demo][1] possui um exemplo funcional de cada banco, você pode verificar lá quais são os parâmetros necessários para cada banco.

## Bancos suportados
Atualmente o YABoleto funciona com os bancos abaixo:

| **Banco**           |  **Carteira/Convenio** | **Implementado** | **Testado** |
|---------------------|--------------------------|--------------------|---------------|
| **Banco do Brasil** | 17, 18, 21               | Sim                | Sim           |
| **Banrisul**        | x                        | Nao                | Nao           |
| **Bradesco**        | 06, 03                   | Sim                | Sim           |
| **Caixa Economica** | SR                       | Sim                | Sim           |
| **HSBC**            | CNR, CSB                 | Nao                | Nao           |
| **Itau**            | 157                      | Nao                | Nao           |
| **Itau**            | 175, 174, 178, 104, 109  | Nao                | Nao           |
| **Real**            | 57                       | Sim                | Sim           |
| **Santander**       | 102                      | Sim                | Sim           |
| **Santander**       | 101, 201                 | Sim                | Sim           |
|                     |                          |                    |               |

Contribua
----------

Toda contribuição é bem vinda. Se você deseja adaptar o YABoleto a algum outro banco, fique à vontade para explorar o código, 
veja como é bastante simples integrar qualquer banco à biblioteca. Para instalar clone o projeto dentro da pasta **Umbrella/Ya/Boleto**.
```
git clone https://github.com/umbrellaTech/ya-boleto-php.git ya-boleto-php/Umbrella/Ya/Boleto
```
Ou usando o composer.
```
php composer.phar create-project umbrella/boleto ya-boleto-php/Umbrella/Ya/Boleto dev-master
```
Isso se deve por conta do autoloader que segue a [PSR-0][3].

Demo
----------
A aplicação de demonstração está no repositório [Ya Boleto Demo](https://github.com/umbrellaTech/ya-boleto-demo)

Licença
----------

* MIT License

[1]: https://github.com/umbrellaTech/ya-boleto-demo
[2]: https://github.com/umbrellaTech/ya-boleto-php/docs
[3]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md
