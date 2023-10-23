# Documento de Casos de Uso

## Lista dos Casos de Uso

 - [CDU 01](#CDU-01): Criar conta
 - [CDU 02](#CDU-02): Fazer Login
 - [CDU 03](#CDU-03): Buscar Filme, atores e listas
 - [CDU 04](#CDU-04): visualizar Detalhes 
 - [CDU 05](#CDU-05): avaliar filme
 - [CDU 06](#CDU-06): Adicionar Filme à Lista
 - [CDU 07](#CDU-07): gerenciar atores
 - [CDU 08](#CDU-08): gerenciar usuarios
 - [CDU 09](#CDU-09): gerenciar filmes
 - [CDU 09](#CDU-10): Explorar filmes populares
 - [CDU 10](#CDU-11): personalizaçao de perfil
   
## Lista dos Atores

 - usuario
 - usuario nao registrado
 - administrador

## Diagrama de Casos de Uso

![Diagrama de Casos de Uso]!![47e5d4d9-2622-403e-8ee8-fbe571ad714a](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/71e1ec2c-3645-4fcc-832d-458f3c1c4cba)

## Descrição dos Casos de Uso

### CDU Criar Conta (01)

**Fluxo Principal**

![Diagrama de Casos de Uso]!!![WhatsApp Image 2023-10-15 at 00 26 31](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/fa951dfa-ba8d-4917-bd78-1bb17e376b20)



1.	O usuário acessa a página de registro.
2.	O usuário insere suas informações pessoais.
3.	O sistema verifica a validade das informações.
4.	O sistema cria uma nova conta para o usuário.

**Fluxo Alternativo A**

![Diagrama de Casos de Uso]!! ![WhatsApp Image 2023-10-15 at 00 26 32](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/554b5d15-0931-4309-aed6-c3503cf141ef)


1. O sistema detecta um erro inesperado durante o processo de registro.
2. O sistema exibe uma mensagem de erro (A Entrada Falhou. suas credenciais nao correspondem. É provavelmente atribuavel a erro humano) 
e pede ao usuário para tentar novamente.
3. O usuário tenta o registro novamente.


### Fazer Login CDU (02)

**Fluxo Principal**

• Ator: Usuário
• Pré-condições: O usuário tem uma conta registrada.
1. O usuário acessa a página de login.
2. O usuário insere email ou o seu nome de usuário e senha.
3. O sistema verifica as credenciais.
4. O sistema autentica o usuário e exibe o site.
• Pós-condições: O usuário está logado na plataforma

![Diagrama de Casos de Uso]!!!
![WhatsApp Image 2023-10-15 at 00 26 30 (1)](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/d4c8d2cf-c865-476f-af79-29bf47fa0c4b)

    ### Fluxo alternativo 
   
1. O usuário insere um nome de usuário e/ou senha incorretos.
2. O sistema não consegue autenticar as credenciais e exibe uma mensagem de erro.
3. O usuário pode tentar novamente inserindo as credenciais corretas.

![Diagrama de Casos de Uso]!!![WhatsApp Image 2023-10-15 at 00 26 30](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/cc1b8fa7-40e1-487f-af16-80bb08853c59)


## CDU Buscar Filmes e atores (03)

 ### Fluxo principal 
   
• Ator: Usuário
• Pré-condições: O usuário está logado.
1. O usuário acessa a barra de pesquisa.
2. O usuário insere o título do filme ou atores.
3. O sistema exibe resultados correspondentes.
• Pós-condições: O usuário vê os resultados da pesquisa.

    ### Fluxo alternativo 
    
1. O usuário realiza uma pesquisa, mas não há resultados correspondentes.
2. O sistema exibe uma mensagem informando que nenhum resultado foi encontrado.
3. usuário pode refinar sua pesquisa ou tentar buscar por termos diferentes.

### CDU Explorar Detalhes do Filme (04)

###Fluxo principal 
    
• Ator: Usuário
• Pré-condições: O usuário está logado e acessou um filme.
1. O usuário acessa a página de detalhes do filme.
2. O sistema exibe informações como sinopse, elenco, diretor e resenhas
• Pós-condições: O usuário obtém informações detalhadas sobre o filme.


### CDU Avaliar filme (05)

###Fluxo principal 

•	Ator: Usuário
•	Pré-condições: O usuário está logado e acessou um filme.
1.	O usuário encontra o filme desejado.
2.	O usuário seleciona a opção de avaliar.
3.	O usuário atribui uma nota e/ou escreve uma resenha
4.	O sistema registra a avaliação e a resenha.

### CDU Adicionar Filme à Lista (06)

###Fluxo principal
   
• Ator: Usuário
• Pré-condições: O usuário está logado.
1. O usuário encontra o filme desejado.
2. O usuário seleciona a opção de adicionar à lista.
3. O sistema adiciona o filme à lista do usuário (assistidos e para assistir).
4. O sistema registra a sua lista.
• Pós-condições: O filme é adicionado à lista do usuário.

## CDU  Gerenciamento de Atores (07)

###Fluxo principal 

• Ator : Administrador 
• Pré-condições : O ator que deseja gerenciar atores está autenticado no sistema.
1. Cadastro de atores: Permitir a criação de perfis para atores, incluindo informações como nome, data de nascimento, biografia, filmografia e foto.

2. Atualização de informações: Permitir que os atores atualizem suas informações pessoais, adicione novos créditos de filmes, atualizem sua foto de perfil, etc.

3. Pesquisa de atores: Facilitar a busca por atores com base em critérios como nome, idade, gênero, filmes em que atuaram, etc.

4. Classificação de atores: Permitir que os usuários classifiquem atores e deixem comentários sobre seu desempenho.

5. Relacionamentos: Associar atores com os filmes em que atuaram, permitindo que os usuários vejam quais atores estiveram em quais filmes.
• Pós-condições : As informações do ator foram atualizadas com sucesso no sistema.

## CDU  Gerenciamento de Filmes (08)

###Fluxo principal 

• Ator : Administrador 
• Pré-condições : O usuário que deseja gerenciar filmes está autenticado no sistema.

1. Cadastro de filmes: Permitir a adição de novos filmes ao sistema, incluindo informações como título, diretor, gênero, elenco, sinopse, data de lançamento e avaliações.

2. Atualização de informações: Possibilitar a edição de detalhes de filmes, como adicionar ou remover atores, atualizar a sinopse ou a data de lançamento.

3. Pesquisa de filmes: Oferecer aos usuários a capacidade de pesquisar filmes por gênero, diretor, atores, título, ano de lançamento, etc.

4. Avaliações e classificações: Permitir que os usuários classifiquem e deixem comentários sobre os filmes, ajudando outros usuários a tomar decisões informadas.

5. Recomendações: Com base no histórico de visualização dos usuários, sugerir filmes que possam ser do interesse deles.
• Pós-condições : As informações do filme foram atualizadas com sucesso no sistema.

## CDU  Gerenciamento de Usuários (09)

###Fluxo principal 

• Ator : Administrador 
• Pré-condições : O usuário que deseja gerenciar sua conta está autenticado no sistema.

1. Cadastro de usuários: Permitir que os usuários se cadastrem na plataforma, fornecendo informações como nome, e-mail, senha e preferências de gênero de filme.

2. Autenticação e segurança: Garantir a segurança dos dados do usuário com métodos de autenticação, como login e senha, autenticação de dois fatores, etc.                        

3. Perfil do usuário: Permitir que os usuários personalizem seus perfis, adicionando fotos, biografias, preferências de gênero de filme, histórico de visualização, etc.

4. Histórico de visualização: Registrar os filmes assistidos por cada usuário para oferecer recomendações personalizadas.

5. Sistema de amigos: Permitir que os usuários conectem-se a outros usuários, sigam seus perfis e compartilhem recomendações de filmes.
• Pós-condições : As informações do perfil do usuário foram atualizadas com sucesso no sistema.
 
### CDU Explorar Filmes Populares (tela inicial) (10)

###Fluxo principal

• Ator: Usuário
• Pré-condições: O usuário está logado.
1. O usuário acessa a seção de filmes populares ou tendências.
2. O sistema exibe uma lista de filmes populares com base em classificações, avaliações 
ou tendências.
3. O usuário pode navegar por diferentes gêneros e filtrar os resultados
• Pós-condições: O usuário descobre filmes populares entre a comunidade.

###Fluxo alternativo
   
1. O sistema encontra problemas ao recuperar filmes populares.
2. O sistema exibe uma mensagem de erro e sugere ao usuário tentar novamente mais tarde.

### CDU Personalizar Perfil (11)

###Fluxo principal

• Ator: Usuário
• Pré-condições: O usuário está logado.
1. O usuário acessa as configurações do perfil.
2. O usuário pode adicionar uma foto, uma biografia, seus 4 filmes favoritos, seus últimos 
4. filmes assistidos e configurar suas preferências de privacidade.
3. O usuário pode configurar suas notificações e vincular alguma rede das suas redes 
sociais 
• Pós-condições: O perfil do usuário é personalizado de acordo com suas preferências.

    ###Fluxo alternativo
   
1. O usuário tenta fazer o upload de uma foto de perfil, mas o sistema encontra um erro no processo.
2. O sistema exibe uma mensagem de erro e instrui o usuário a tentar novamente.











