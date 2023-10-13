# Documento de Casos de Uso

## Lista dos Casos de Uso

 - [CDU 01](#CDU-01): Criar Conta
 - [CDU 02](#CDU-02): Fazer Login
 - [CDU 03](#CDU-03): Buscar Filme, atores, listas e amigos
 - [CDU 04](#CDU-04): Explorar Detalhes do Filme
 - [CDU 05](#CDU-05): avaliar filme
 - [CDU 06](#CDU-06): Adicionar Filme à Lista
 - [CDU 07](#CDU-07): Explorar filmes populares
 - [CDU 08](#CDU-08): personalizaçao de perfil
 
## Lista dos Atores

 - usuario
 - usuario nao registrado
 - administrador

## Diagrama de Casos de Uso

![Diagrama de Casos de Uso]![WhatsApp Image 2023-10-12 at 23 01 36](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/43429689-d5c6-43c6-a1fc-4ebec0d81987) 


## Descrição dos Casos de Uso

### CDU Criar Conta (01)

**Fluxo Principal**

1.	O usuário acessa a página de registro.
2.	O usuário insere suas informações pessoais.
3.	O sistema verifica a validade das informações.
4.	O sistema cria uma nova conta para o usuário.

**Fluxo Alternativo A**
  
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

    ### Fluxo alternativo 
   
1. O usuário insere um nome de usuário e/ou senha incorretos.
2. O sistema não consegue autenticar as credenciais e exibe uma mensagem de erro.
3. O usuário pode tentar novamente inserindo as credenciais corretas.

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

### CDU Explorar Filmes Populares (tela inicial) (07)

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

### CDU Personalizar Perfil (08)

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











