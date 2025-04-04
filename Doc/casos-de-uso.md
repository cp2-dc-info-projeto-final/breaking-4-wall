# Documento de Casos de Uso

## Lista dos Casos de Uso

 - [CDU 01](DOC/CDU-01): Criar conta
 - [CDU 02](#CDU-02): Fazer Login
 - [CDU 03](#CDU-03): Buscar Filme, atores e listas
 - [CDU 04](#CDU-04): Visualizar Detalhes 
 - [CDU 05](#CDU-05): Gerenciar atores
 - [CDU 06](#CDU-06): Gerenciar usuarios
 - [CDU 07](#CDU-07): Gerenciar filmes
 - [CDU 08](#CDU-08): Explorar filmes populares
 - [CDU 09](#CDU-09): Personalizaçao de perfil
 - [CDU 10](#CDU-10): Recuperar senha
 - [CDU 11](#CDU-11): Logout

   
## Lista dos Atores

 - usuário
 - usuário nao registrado
 - administrador


!(![image](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/30b4e23c-22fe-4ac2-817e-a3968a8e8f0e)



 # Descrição dos Casos de Uso

 # CDU Criar Conta (01) 

 # Fluxo Principal

![WhatsApp Image 2023-10-15 at 00 26 31](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/fa951dfa-ba8d-4917-bd78-1bb17e376b20)

1.	O usuário acessa a página de registro.
2.	O usuário insere suas informações pessoais.
3.	O sistema verifica a validade das informações.
4.	O sistema cria uma nova conta para o usuário.

 # Fluxo Alternativo A

![WhatsApp Image 2023-10-15 at 00 26 32](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/554b5d15-0931-4309-aed6-c3503cf141ef)


1. O sistema detecta um erro inesperado durante o processo de registro.
2. O sistema exibe uma mensagem de erro (A Entrada Falhou. suas credenciais nao correspondem. É provavelmente atribuavel a erro humano) 
e pede ao usuário para tentar novamente.
3. O usuário tenta o registro novamente.

![WhatsApp Image 2023-10-15 at 00 26 32 (1)](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/d1672a1d-bd4d-43fb-8669-46388b894cc8)

 # Fazer Login CDU (02)

 # Fluxo Principal

 • Ator: Usuário

 • Pré-condições: O usuário tem uma conta registrada.

1. O usuário acessa a página de login.
2. O usuário insere email ou o seu nome de usuário e senha.
3. O sistema verifica as credenciais.
4. O sistema autentica o usuário e exibe o site.

 • Pós-condições: O usuário está logado na plataforma

![WhatsApp Image 2023-10-15 at 00 26 30 (1)](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/d4c8d2cf-c865-476f-af79-29bf47fa0c4b)

 # Fluxo alternativo A
   
1. O usuário insere um nome de usuário e/ou senha incorretos.
2. O sistema não consegue autenticar as credenciais e exibe uma mensagem de erro.
3. O usuário pode tentar novamente inserindo as credenciais corretas.

![WhatsApp Image 2023-10-15 at 00 26 30](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/cc1b8fa7-40e1-487f-af16-80bb08853c59)


 # CDU Buscar Filmes e atores (03)

 # Fluxo principal

![WhatsApp Image 2023-10-15 at 00 26 32 (2)](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/b84e5871-739f-4c71-99bc-22dfaa7ebb1b)
  
 • Ator: Usuário

 • Pré-condições: O usuário está logado.

1. O usuário acessa a barra de pesquisa.
2. O usuário insere o título do filme ou atores.
3. O sistema exibe resultados correspondentes.

• Pós-condições: O usuário vê os resultados da pesquisa.

 # Fluxo alternativo A

![WhatsApp Image 2023-10-15 at 00 26 33](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/941a495c-452b-49e0-8ad1-f024c186ce80)

    
1. O usuário realiza uma pesquisa, mas não há resultados correspondentes.
2. O sistema exibe uma mensagem informando que nenhum resultado foi encontrado.
3. usuário pode refinar sua pesquisa ou tentar buscar por termos diferentes.

 # CDU Visualizar Detalhes do Filme (04)

 # Fluxo principal

![WhatsApp Image 2023-10-15 at 00 26 33 (1)](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/952d904d-eaa7-4864-bcee-2bd64cd5b896)


   
 • Ator: Usuário

 • Pré-condições: O usuário está logado e acessou um filme.

1. O usuário acessa a página de detalhes do filme.
2. O sistema exibe informações como sinopse, elenco, diretor e resenhas
   
 • Pós-condições: O usuário obtém informações detalhadas sobre o filme.


 # Fluxo alternativo A
 ![0](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/142441842/b541f6c0-5c2b-4ca6-b89f-e40110cf0251)


1. O usuário acessa a página de detalhes do filme mas não há nenhum detalhe.
2. O sistema exibe uma mensagem informando que não há nenhum conteúdo.  


 # CDU  Gerenciamento de Atores (05)

 # Fluxo principal 

![WhatsApp Image 2023-10-18 at 23 15 21 (2)](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/184d874b-d574-48f8-9816-9d1298e3ec41)

 • Ator : Administrador 

 • Pré-condições : O ator que deseja gerenciar atores está autenticado no sistema.

1. Cadastro de atores: Permitir a criação de perfis para atores, incluindo informações como nome, data de nascimento, biografia, filmografia e foto.
2. Atualização de informações: Permitir que os atores atualizem suas informações pessoais, adicione novos créditos de filmes, atualizem sua foto de perfil, etc.
3. Pesquisa de atores: Facilitar a busca por atores com base em critérios como nome, idade, gênero, filmes em que atuaram, etc.
4. Classificação de atores: Permitir que os usuários classifiquem atores e deixem comentários sobre seu desempenho.
5. Relacionamentos: Associar atores com os filmes em que atuaram, permitindo que os usuários vejam quais atores estiveram em quais filmes.

 • Pós-condições : As informações do ator foram atualizadas com sucesso no sistema.

 # Fluxo Alternativo A - Evitar Cadastro Duplicado de Ator no Mesmo Filme:
 
![Fluxo Alternativo CDU 07- Duplicação de Ator](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/142441842/f18edf4b-b7e2-443f-ab47-e89528ca656f)


1. Identificação de Tentativa de Duplicação: Durante o cadastro de atores para um filme, o sistema detecta que o ator que está sendo adicionado já está associado ao mesmo filme.

2. Exibição de Mensagem de Erro: O sistema exibe imediatamente uma mensagem de erro, informando ao administrador sobre a tentativa de duplicação e a necessidade de revisão.

3. Opção para Revisar Atores Cadastrados: Uma opção é apresentada ao administrador, permitindo revisar a lista de atores já cadastrados para o filme antes de prosseguir.

4. Revisão da Lista de Atores: O administrador revisa a lista existente para garantir que o ator desejado não esteja duplicado, identificando e corrigindo possíveis problemas.

5. Correção do Cadastro: Se necessário, o administrador corrige o cadastro excluindo o ator duplicado ou escolhendo outro ator para evitar a duplicação.
Reenvio do Formulário e Conclusão:

Após a revisão e correção, o administrador reenvia o formulário de cadastro de atores. O sistema verifica novamente e, se não houver mais duplicações, conclui o cadastro com sucesso, exibindo uma mensagem de confirmação.
 # CDU  Gerenciamento de Filmes (06)

 # Fluxo principal 

![WhatsApp Image 2023-10-18 at 23 15 21 (1)](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/2f46f288-568c-44e1-8660-1b191d7e3e10)


 • Ator : Administrador 

 • Pré-condições : O usuário que deseja gerenciar filmes está autenticado no sistema.

1. Cadastro de filmes: Permitir a adição de novos filmes ao sistema, incluindo informações como título, diretor, gênero, elenco, sinopse, data de lançamento e avaliações.
2. Atualização de informações: Possibilitar a edição de detalhes de filmes, como adicionar ou remover atores, atualizar a sinopse ou a data de lançamento.
3. Pesquisa de filmes: Oferecer aos usuários a capacidade de pesquisar filmes por gênero, diretor, atores, título, ano de lançamento, etc.
4. Avaliações e classificações: Permitir que os usuários classifiquem e deixem comentários sobre os filmes, ajudando outros usuários a tomar decisões informadas.
5. Recomendações: Com base no histórico de visualização dos usuários, sugerir filmes que possam ser do interesse deles.

 • Pós-condições : As informações do filme foram atualizadas com sucesso no sistema.

 # Fluxo Alternativo A- Falha na Atualização de Informações do Filme:

![Fluxo Alternativo CDU 08- Atualizar Filmes](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/142441842/0cd1a51c-28eb-452b-815f-8c12e8e55ff4)


 1. Identificação de Falha na Validação: Durante o processo de atualização de informações do filme, o sistema identifica que uma ou mais informações inseridas não atendem aos critérios de validação.

2. Exibição de Mensagem de Erro: O sistema exibe uma mensagem de erro indicando os campos que precisam ser corrigidos, fornecendo instruções claras sobre como corrigir os problemas.

3. Correção das Informações: O administrador ajusta as informações conforme as orientações fornecidas pela mensagem de erro.

4. Tentativa de Reenvio: Após a correção, o administrador tenta reenviar o formulário para atualização das informações do filme.

5. Segunda Validação: O sistema realiza uma segunda validação nas informações corrigidas para garantir que todos os critérios sejam atendidos.

6. Confirmação da Atualização ou Nova Correção: Se a segunda validação for bem-sucedida, o sistema exibe uma mensagem de confirmação informando que as informações do filme foram atualizadas com sucesso. Caso contrário, o fluxo retorna à correção adicional.

7. Exibição das Informações Atualizadas: Se bem-sucedido, o sistema exibe as informações atualizadas na interface correspondente, refletindo as modificações feitas pelo administrador.

8. Opção de Voltar ao Menu Principal: O administrador é redirecionado de volta ao menu principal do sistema de gerenciamento de filmes, onde pode escolher entre outras opções disponíveis.

 # CDU  Gerenciamento de Usuários (07)

 # Fluxo principal 

![WhatsApp Image 2023-10-18 at 23 15 21](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/8ec151cc-2aea-41ee-a8ee-c6cb96cc434b)

 • Ator : Administrador 

 • Pré-condições : O usuário que deseja gerenciar sua conta está autenticado no sistema.

1. Cadastro de usuários: Permitir que os usuários se cadastrem na plataforma, fornecendo informações como nome, e-mail, senha e preferências de gênero de filme.
2. Autenticação e segurança: Garantir a segurança dos dados do usuário com métodos de autenticação, como login e senha, autenticação de dois fatores, etc.                        
3. Perfil do usuário: Permitir que os usuários personalizem seus perfis, adicionando fotos, biografias, preferências de gênero de filme, histórico de visualização, etc.
4. Histórico de visualização: Registrar os filmes assistidos por cada usuário para oferecer recomendações personalizadas.
5. Sistema de amigos: Permitir que os usuários conectem-se a outros usuários, sigam seus perfis e compartilhem recomendações de filmes.

 • Pós-condições : As informações do perfil do usuário foram atualizadas com sucesso no sistema.

 # Fluxo Alternativo A- Falha na Atualização de Informações do Perfil do Usuário:

 ![Fluxo Alternativo CDU 09- Editar Perfil](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/142441842/3404a46a-efeb-4e14-b4a2-79070b6e9ece)

1. Identificação de Falha na Validação: Durante a atualização do perfil do usuário, o sistema identifica que uma ou mais informações inseridas não atendem aos critérios de validação.

2. Exibição de Mensagem de Erro: O sistema exibe uma mensagem de erro indicando os campos que precisam ser corrigidos, fornecendo instruções claras sobre como resolver os problemas.

3. Correção das Informações: O usuário ajusta as informações conforme as orientações fornecidas pela mensagem de erro.

4. Tentativa de Reenvio e Segunda Validação: Após a correção, o usuário tenta reenviar o formulário para a atualização do perfil. O sistema realiza uma segunda validação para garantir que todos os critérios sejam atendidos.

5. Confirmação da Atualização ou Nova Correção: Se a segunda validação for bem-sucedida, o sistema exibe uma mensagem de confirmação informando que as informações do perfil do usuário foram atualizadas com sucesso. Caso contrário, o fluxo retorna ao passo 2 para correção adicional.

6. Exibição do Perfil Atualizado: Se bem-sucedido, o sistema exibe o perfil do usuário com as informações atualizadas na interface correspondente.

7. Opção de Voltar ao Menu Principal: O usuário é redirecionado de volta ao menu principal do sistema, onde pode explorar outras funcionalidades disponíveis.
 
 # CDU Explorar Filmes Populares (tela inicial) (08)

 # Fluxo principal

![WhatsApp Image 2023-10-15 at 00 26 34](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/cfff6b30-bd07-427d-989b-863b89a0fbdb)

 • Ator: Usuário
 
 • Pré-condições: O usuário está logado.
 
1. O usuário acessa a seção de filmes populares ou tendências.
2. O sistema exibe uma lista de filmes populares com base em classificações, avaliações 
ou tendências.
3. O usuário pode navegar por diferentes gêneros e filtrar os resultados
   
 • Pós-condições: O usuário descobre filmes populares entre a comunidade.

 # Fluxo alternativo A-

![WhatsApp Image 2023-10-15 at 00 26 34 (1)](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/2282ac8c-d0ff-4546-bcab-6fd2d0e963f9)

   
1. O sistema encontra problemas ao recuperar filmes populares.
2. O sistema exibe uma mensagem de erro e sugere ao usuário tentar novamente mais tarde.

 # CDU Personalizar Perfil (09)

 # Fluxo principal

![WhatsApp Image 2023-10-15 at 00 26 34 (2)](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/b25e5d56-6eea-4887-b50f-e65f5efde623)

 • Ator: Usuário
 
 • Pré-condições: O usuário está logado.
 
1. O usuário acessa as configurações do perfil.
2. O usuário pode adicionar uma foto, uma biografia, seus 4 filmes favoritos, seus últimos 
4. filmes assistidos e configurar suas preferências de privacidade.
3. O usuário pode configurar suas notificações e vincular alguma rede das suas redes 
sociais 

 • Pós-condições: O perfil do usuário é personalizado de acordo com suas preferências.

 # Fluxo alternativo A-

![WhatsApp Image 2023-10-15 at 00 26 34 (3)](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/90862fae-126c-4300-b175-bf3cc4500a0e)

1. O usuário tenta fazer o upload de uma foto de perfil, mas o sistema encontra um erro no processo.
2. O sistema exibe uma mensagem de erro e instrui o usuário a tentar novamente.

 # CDU: Recuperar Senha (10)

 # Fluxo Principal:

![Recuperação de Senha](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/142441842/b11659c6-d563-4e4b-8182-dfd28aae0d46)

 • Ator: Usuário

 • Pré-condições: O usuário deve estar registrado no sistema.

1. O usuário acessa a página de recuperação de senha.
2. O sistema solicita ao usuário que insira seu endereço de e-mail registrado.
3. O usuário insere o endereço de e-mail e confirma.
4. O sistema verifica se o endereço de e-mail existe no banco de dados.
5. Se o endereço de e-mail existir, o sistema gera um link de redefinição de senha exclusivo e o envia para o e-mail fornecido.
6. O usuário verifica sua caixa de entrada de e-mail.
7. O usuário clica no link de redefinição de senha.
8. O sistema direciona o usuário para uma página onde ele pode criar uma nova senha.
9. O usuário define uma nova senha e confirma.
10. O sistema atualiza a senha do usuário no banco de dados.
11. O sistema exibe uma mensagem de confirmação de que a senha foi alterada com sucesso.

 • Pós-condições: O usuário recebe um link para redefinir sua senha.

 # Fluxo Alternativo A- E-mail Não Registrado:

![Recuperação de Senha (1)](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/142441842/7cef5bb6-1fb5-4af6-9111-d71ea3267509)

1. O usuário inicia o processo de recuperação.
2. O usuário fornece o endereço de e-mail associado à sua conta e solicita a redefinição de senha.
3. O sistema verifica o banco de dados para encontrar uma conta com o endereço de e-mail fornecido.
4. Se o e-mail não estiver registrado no sistema, o sistema não encontrará correspondências.
5. O sistema exibirá uma mensagem de erro informando que o e-mail fornecido não está associado a uma conta existente no sistema.
6. O usuário será instruído a revisar o endereço de e-mail inserido ou a criar uma nova conta, se ainda não tiver uma.
7. O usuário pode optar por retornar à página inicial ou seguir um link para o processo de registro, se desejado.

 # CDU: Logout (11)

 # Fluxo Principal:

![WhatsApp Image 2023-10-23 at 14 14 48](https://github.com/cp2-dc-info-projeto-final/breaking-4-wall/assets/143643654/c09f0ecc-29d6-4dbd-8ba9-7a99effa6673)

 • Ator: Usuário logado.

 • Pré-condições: O usuário deve estar logado no sistema.

1. O usuário, estando logado no sistema, decide fazer logout.
2. O sistema confirma que o usuário deseja efetuar o logout.
3. O sistema encerra a sessão do usuário, invalidando sua autenticação.
4. O sistema redireciona o usuário para a página de login ou para a página inicial do sistema, dependendo da configuração do sistema.

 • Pós-condições: O usuário foi desconectado com sucesso e não tem mais acesso às funcionalidades restritas do sistema até que faça login novamente.
