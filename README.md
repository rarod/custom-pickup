# Custom Pickup - Módulo Magento 2

**Descrição**:  
O módulo **Custom Pickup** oferece aos clientes a opção de retirar seus pedidos diretamente na loja, aprimorando a experiência de entrega no Magento 2.

---

## Requisitos

- PHP: `~8.1.0`
- Magento Framework: `^103.0.0`
- Magento 2.x configurado e funcional

---
## Instalação

####
1. Adicione o módulo ao seu projeto:
`composer require rarod/custom-pickup`


2. Ative o modulo no Magento:
`bin/magento module:enable Rarod_CustomPickup`


   
3. Atualize a configuração no banco de dados:
`bin/magento setup:upgrade`


4. Recompile os arquivos:
`bin/magento setup:di:compile`


5. Limpe o cache:
`bin/magento cache:clean`


## Configuração no painel
- Acesse o Painel Administrativo do Magento.
- Vá para Admin > Configurações > Métodos de Envio.
- Ative a opção Retirado na Loja (Custom Pickup).
- Personalize as opções, como localização da loja e mensagens de instrução ao cliente.