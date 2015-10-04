# Inovarti_CustomRolepermissions
Módulo que extende a lista de controle de acesso do Magento por loja e website


## Print Screen
![image](http://f.cl.ly/items/3i011h0V0i3W131w3A0J/Image%202015-10-04%20at%205.37.52%20PM.png)

## Como funciona?
Esse módulo permite habilitar funções de acesso a lojas específicas. Ele é bastante requisitado a e-commerces participantes de marketplace como o da Saraiva, Ricardo Eletro, Insinuante,.... Pois os marketplaces solicitam acesso ao admin das lojas para acompanhamento das vendas e comissões. 

## Exemplo de uso:
Digamos que a loja seja participante dos marketplaces da Saraiva e Ricardo Eletro. Com o módulo o administrador da loja consegue liberar acesso individual ao painel da administração clientes e vendas por multiloja. Assim o usuário da Saraiva somente conseguirá visuzalizar os seus clientes e seus pedidos.

## Instalação do módulo

### Instalar usando o [modgit](https://github.com/jreinke/modgit):

    $ cd /path/to/magento
    $ modgit init
    $ modgit add pagarme git@github.com:deivisonarthur/Inovarti_CustomRolepermissions.git

### Instalar usando o [modman](https://github.com/colinmollenhour/modman):

    $ cd /path/to/magento
    $ modman init
    $ modman clone git@github.com:deivisonarthur/Inovarti_CustomRolepermissions.git

### ou baixar e instalar manualmente:

* Baixe a ultima versão [aqui](https://github.com/deivisonarthur/Inovarti_CustomRolepermissions/archive/master.zip)
* Descompacte o arquivo baixado e copie as pastas ``` app```, ```js``` e ```skin``` para dentro do diretório principal do Magento
* Limpe a cache em ```Sistema > Gerenciamento de Cache```

# Configuração

## 1 Configure o modulo em ```Sistema > Permissões > Funções```
## 2 Crie e configure as permissões de acesso para o usuário;

## 3 Recomenda-se aplicar somente as permissões:

#### Visualização das ordens:
![image](http://f.cl.ly/items/2k0U1d0G0Y2R3M0X0K0v/Image%202015-10-04%20at%206.06.06%20PM.png)

#### Gerenciamento dos clientes e newsletter
![image](http://f.cl.ly/items/0f2V0W0x00120O2F0s2g/Image%202015-10-04%20at%206.06.32%20PM.png)

## 4 Antes de salvar vá na aba Advanced Permissions: Scope e selecione a loja(s) permitidas;
![image](http://f.cl.ly/items/3i011h0V0i3W131w3A0J/Image%202015-10-04%20at%205.37.52%20PM.png)

## 5 Pronto! Basta deslogar e testar os acessos e comprovar que somente esta sendo possível visualização dos itens das lojas selecionadas.

# Atenção!
<img src="http://www.inovarti.com.br/osc/atencao2.png" alt="Atenção! Faça sempre backup antes de realizar qualquer modificação! E sempre teste em um ambiente de desenvolvimento!" title="Atenção! Faça sempre backup antes de realizar qualquer modificação! E sempre teste em um ambiente de desenvolvimento!" />


<img src="http://www.inovarti.com.br/gostou.png" alt="Faça uma doação" title="Faça uma doação" />
**********************************************************************************************
Se você gostou, se foi útil para você, se fez você economizar aquela grana pois estava prestes a pagar caro por aquele módulo pago, pois não achava um solução gratuita que te atendesse e queira prestigiar o trabalho feito efetuando uma doação de qualquer valor, não vou negar e vou ficar grato, você pode fazer isso utilizando o Pagseguro no site ofical do projeto: [Site Oficial do projeto](http://onestepcheckout.com.br)
