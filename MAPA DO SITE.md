# Mapa do Site - Canal Salto Alto

Abaixo estão listadas todas as rotas do sistema, organizadas por área de acesso.

| Nome da Página / Funcionalidade | Rota | O que tem nessa página / O que faz |
| :--- | :--- | :--- |
| **Área Pública (Site)** | | |
| Página Inicial | `/` | Página principal do site com destaques, banners e informações gerais. |
| Notícias | `/noticias` | Listagem de notícias e artigos do blog. |
| Detalhes da Notícia | `/noticia/{news_slug}` | Leitura completa de uma notícia específica. |
| Quem Somos | `/quem-somos` | História e informações institucionais sobre o Canal Salto Alto. |
| Termos de Uso | `/termos-de-uso` | Texto legal com os termos de uso da plataforma. |
| Política de Privacidade | `/politica-de-privacidade` | Texto legal sobre a política de privacidade e dados. |
| Fale Conosco | `/fale-conosco` | Formulário de contato para envio de mensagens. |
| Login (Tela) | `/login` (GET) | Formulário de acesso para membros e administradores. |
| Login (Ação) | `/login` (POST) | Processamento da autenticação do usuário. |
| Cadastro (Tela) | `/register` (GET) | Formulário para novos usuários se cadastrarem. |
| Cadastro (Ação) | `/register` (POST) | Processamento do cadastro de novos usuários. |
| Recuperar Senha (Tela) | `/forgot` (GET) | Formulário para solicitar redefinição de senha. |
| Recuperar Senha (Ação) | `/forgot` (POST) | Envio do e-mail com link de recuperação. |
| Redefinir Senha (Tela) | `/renew-password/{token}` (GET) | Formulário para criar uma nova senha. |
| Redefinir Senha (Ação) | `/renew-password/{token}` (POST) | Processamento da troca de senha. |
| Assinaturas Suspensas | `/suspended-subscriptions` | Página informativa para usuários com assinaturas suspensas. |
| **Área de Membros (App)** | | |
| Dashboard / Feed | `/app` | Painel principal do membro com feed de atividades e atalhos. |
| Notificações | `/app/notifications` | Lista de notificações recebidas pelo usuário. |
| Ler Todas Notificações (Ação) | `/app/notifications/read/all` | Marca todas as notificações como lidas. |
| Avisos | `/app/notices` | Quadro de avisos e comunicados importantes. |
| Eventos | `/app/events` | Calendário e listagem de eventos disponíveis. |
| Detalhes do Evento | `/app/events/{event_id}` | Informações completas sobre um evento específico. |
| Confirmar Presença (Ação) | `/app/events/confirm/{event_id}` | Registra a inscrição do usuário no evento. |
| Clubes | `/app/clubs` | Listagem dos clubes de interesse. |
| Detalhes do Clube | `/app/clubs/{club_id}` | Página interna de um clube específico. |
| Clube de Benefícios | `/app/benefits` | Catálogo de descontos e benefícios de parceiros. |
| Detalhes do Benefício | `/app/benefits/{benefit_id}` | Informações de como utilizar um benefício. |
| Resgatar Benefício (Ação) | `/app/benefits/rescue/{benefit_id}` | Processa o resgate de um benefício/cupom. |
| Tutoriais | `/app/tutorials` | Área de aprendizado com vídeos e tutoriais. |
| Detalhes do Tutorial | `/app/tutorials/{tutorial_id}` | Visualização de um tutorial específico. |
| Networking | `/app/network` | Diretório de membros para conexão e networking. |
| Perfil de Membro | `/app/network/{user_id}` | Visualização do perfil público de outro membro. |
| Meu Perfil (Tela) | `/app/profile` (GET) | Edição dos dados pessoais do usuário logado. |
| Atualizar Perfil (Ação) | `/app/profile` (POST) | Salva as alterações no perfil do usuário. |
| Minhas Empresas | `/app/profile/companies` | Gestão das empresas cadastradas pelo usuário. |
| Nova Empresa (Tela) | `/app/profile/companies/new` (GET) | Formulário para cadastrar uma nova empresa. |
| Nova Empresa (Ação) | `/app/profile/companies/new` (POST) | Processamento do cadastro da empresa. |
| Editar Empresa (Tela) | `/app/profile/companies/edit/{id}` (GET) | Formulário para editar dados da empresa. |
| Editar Empresa (Ação) | `/app/profile/companies/edit/{id}` (POST) | Salva alterações na empresa. |
| Excluir Empresa (Ação) | `/app/profile/companies/delete/{id}` | Remove uma empresa do usuário. |
| Minhas Assinaturas | `/app/profile/signatures` | Histórico e status da assinatura do membro. |
| Minhas Publis | `/app/publis` | Gestão de publicações feitas pelo usuário. |
| Nova Publi (Tela) | `/app/publis/new` (GET) | Formulário para criar nova publicação. |
| Nova Publi (Ação) | `/app/publis/new` (POST) | Processamento da nova publicação. |
| Editar Publi (Tela) | `/app/publis/edit/{id}` (GET) | Formulário para editar publicação. |
| Editar Publi (Ação) | `/app/publis/edit/{id}` (POST) | Salva alterações na publicação. |
| Excluir Publi (Ação) | `/app/publis/delete/{id}` | Remove uma publicação. |
| QRCode Pessoal | `/app/qr/{user_id}` | Exibição do QRCode para check-in ou identificação. |
| Check-in Evento | `/app/checkin/{event_id}` | Realiza check-in no evento via leitura de QR. |
| **Área Administrativa** | | |
| Dashboard Admin | `/admin` | Visão geral e métricas para administradores. |
| Mídias | `/admin/medias` | Galeria de arquivos e mídias do sistema. |
| Nova Mídia (Ação) | `/admin/medias/new` | Upload de novas mídias. |
| Excluir Mídia (Ação) | `/admin/medias/delete/{id}` | Remoção de arquivos de mídia. |
| Cupons | `/admin/coupons` | Gestão de cupons de desconto. |
| Novo Cupom (Tela) | `/admin/coupons/new` (GET) | Formulário de criação de cupom. |
| Novo Cupom (Ação) | `/admin/coupons/new` (POST) | Salva o novo cupom. |
| Editar Cupom (Tela) | `/admin/coupons/edit/{id}` (GET) | Edição de cupom existente. |
| Editar Cupom (Ação) | `/admin/coupons/edit/{id}` (POST) | Salva alterações no cupom. |
| Excluir Cupom (Ação) | `/admin/coupons/delete/{id}` | Remove um cupom. |
| Banners | `/admin/banners` | Gestão dos banners do site e app. |
| Novo Banner (Tela) | `/admin/banners/new` (GET) | Formulário de criação de banner. |
| Novo Banner (Ação) | `/admin/banners/new` (POST) | Salva o novo banner. |
| Editar Banner (Tela) | `/admin/banners/edit/{id}` (GET) | Edição de banner. |
| Editar Banner (Ação) | `/admin/banners/edit/{id}` (POST) | Salva alterações no banner. |
| Excluir Banner (Ação) | `/admin/banners/delete/{id}` | Remove um banner. |
| Posts (Notícias) | `/admin/posts` | Gestão de notícias e artigos. |
| Novo Post (Tela) | `/admin/posts/new` (GET) | Editor de novo post. |
| Novo Post (Ação) | `/admin/posts/new` (POST) | Salva o novo post. |
| Editar Post (Tela) | `/admin/posts/edit/{id}` (GET) | Editor de post existente. |
| Editar Post (Ação) | `/admin/posts/edit/{id}` (POST) | Salva alterações no post. |
| Excluir Post (Ação) | `/admin/posts/delete/{id}` | Remove um post. |
| Gestão de Eventos | `/admin/events` | Lista de todos os eventos. |
| Novo Evento (Tela) | `/admin/events/new` (GET) | Formulário de criação de evento. |
| Novo Evento (Ação) | `/admin/events/new` (POST) | Salva o novo evento. |
| Editar Evento (Tela) | `/admin/events/edit/{id}` (GET) | Edição de evento. |
| Editar Evento (Ação) | `/admin/events/edit/{id}` (POST) | Salva alterações no evento. |
| Excluir Evento (Ação) | `/admin/events/delete/{id}` | Remove um evento. |
| Convidados do Evento | `/admin/events/guests/{id}` | Lista de inscritos no evento. |
| Exportar Convidados | `/admin/events/guests/export/{id}` | Download da lista de convidados (Excel/CSV). |
| Presença no Evento | `/admin/events/presence/{id}` | Controle de presença em tempo real. |
| QRCode do Evento | `/admin/events/presence/{id}/qrcode` | Exibe QR do evento para check-in. |
| Gestão de Clubes | `/admin/clubs` | Lista de clubes cadastrados. |
| Novo Clube (Tela) | `/admin/clubs/new` (GET) | Formulário de criação de clube. |
| Novo Clube (Ação) | `/admin/clubs/new` (POST) | Salva o novo clube. |
| Editar Clube (Tela) | `/admin/clubs/edit/{id}` (GET) | Edição de clube. |
| Editar Clube (Ação) | `/admin/clubs/edit/{id}` (POST) | Salva alterações no clube. |
| Excluir Clube (Ação) | `/admin/clubs/delete/{id}` | Remove um clube. |
| Gestão de Benefícios | `/admin/benefits` | Lista de benefícios cadastrados. |
| Novo Benefício (Tela) | `/admin/benefits/new` (GET) | Formulário de criação de benefício. |
| Novo Benefício (Ação) | `/admin/benefits/new` (POST) | Salva o novo benefício. |
| Editar Benefício (Tela) | `/admin/benefits/edit/{id}` (GET) | Edição de benefício. |
| Editar Benefício (Ação) | `/admin/benefits/edit/{id}` (POST) | Salva alterações no benefício. |
| Excluir Benefício (Ação) | `/admin/benefits/delete/{id}` | Remove um benefício. |
| Gestão de Tutoriais | `/admin/tutorials` | Lista de tutoriais cadastrados. |
| Novo Tutorial (Tela) | `/admin/tutorials/new` (GET) | Formulário de criação de tutorial. |
| Novo Tutorial (Ação) | `/admin/tutorials/new` (POST) | Salva o novo tutorial. |
| Editar Tutorial (Tela) | `/admin/tutorials/edit/{id}` (GET) | Edição de tutorial. |
| Editar Tutorial (Ação) | `/admin/tutorials/edit/{id}` (POST) | Salva alterações no tutorial. |
| Excluir Tutorial (Ação) | `/admin/tutorials/delete/{id}` | Remove um tutorial. |
| Gestão de Avisos | `/admin/notices` | Lista de avisos cadastrados. |
| Novo Aviso (Tela) | `/admin/notices/new` (GET) | Formulário de criação de aviso. |
| Novo Aviso (Ação) | `/admin/notices/new` (POST) | Salva o novo aviso e envia push. |
| Editar Aviso (Tela) | `/admin/notices/edit/{id}` (GET) | Edição de aviso. |
| Editar Aviso (Ação) | `/admin/notices/edit/{id}` (POST) | Salva alterações no aviso. |
| Excluir Aviso (Ação) | `/admin/notices/delete/{id}` | Remove um aviso. |
| Gestão de Membros | `/admin/members` | Lista completa de usuários. |
| Exportar Membros | `/admin/members/export` | Download da base de usuários (Excel). |
| Novo Membro (Tela) | `/admin/members/new` (GET) | Formulário de cadastro manual. |
| Novo Membro (Ação) | `/admin/members/new` (POST) | Processa o cadastro manual. |
| Nova Assinatura (Ação) | `/admin/members/membership/new` | Adiciona assinatura manualmente a um usuário. |
| Excluir Assinatura (Ação) | `/admin/members/membership/delete/{id}` | Remove uma assinatura. |
| Nova Consultoria (Ação) | `/admin/members/consulting/new` | Agenda uma consultoria para o usuário. |
| Excluir Consultoria (Ação) | `/admin/members/consulting/delete/{id}` | Remove agendamento de consultoria. |
| Editar Membro (Tela) | `/admin/members/edit/{id}` (GET) | Edição de dados do usuário. |
| Editar Membro (Ação) | `/admin/members/edit/{id}` (POST) | Salva alterações no usuário. |
| Visualizar Membro | `/admin/members/view/{id}` | Perfil completo do usuário (visão admin). |
| Membros Inativos | `/admin/members/inactive` | Lista de membros sem assinatura ativa. |
| Membros Ativos | `/admin/members/active` | Lista de membros com assinatura ativa. |
| Gestão de Empresas | `/admin/companies` | Lista de empresas cadastradas. |
| Nova Empresa (Tela) | `/admin/companies/new` (GET) | Cadastro manual de empresa. |
| Nova Empresa (Ação) | `/admin/companies/new` (POST) | Salva a nova empresa. |
| Editar Empresa (Tela) | `/admin/companies/edit/{id}` (GET) | Edição de empresa. |
| Editar Empresa (Ação) | `/admin/companies/edit/{id}` (POST) | Salva alterações na empresa. |
| Excluir Empresa (Ação) | `/admin/companies/delete/{id}` | Remove uma empresa. |
| Aprovar Empresas | `/admin/companies/approves` | Lista de empresas pendentes de aprovação. |
| Gestão de Publis | `/admin/publis` | Lista de publicações (publis). |
| Nova Publi (Tela) | `/admin/publis/new` (GET) | Cadastro manual de publi. |
| Nova Publi (Ação) | `/admin/publis/new` (POST) | Salva a nova publi. |
| Editar Publi (Tela) | `/admin/publis/edit/{id}` (GET) | Edição de publi. |
| Editar Publi (Ação) | `/admin/publis/edit/{id}` (POST) | Salva alterações na publi. |
| Excluir Publi (Ação) | `/admin/publis/delete/{id}` | Remove uma publi. |
| Aprovar Publis | `/admin/publis/approves` | Lista de publis pendentes de aprovação. |
| Relatórios (Index) | `/admin/reports` | Página principal de relatórios. |
| Aniversariantes | `/admin/reports/birthdays` | Relatório de aniversariantes do mês. |
| Ranking | `/admin/reports/ranking` | Ranking de engajamento/pontos. |
| Pedidos | `/admin/reports/orders` | Relatório financeiro de pedidos. |
| Logout | `/admin/logout` | Encerra a sessão administrativa. |
| Upload de Imagem | `/upload/image` | Endpoint para upload de imagens (Editor de Texto). |
| **Checkout e Pagamentos** | | |
| Checkout InfinitePay | `/checkout` (POST) | Processa pagamento via InfinitePay. |
| Checkout PIX | `/checkout/pix` (POST) | Gera QR Code PIX. |
| Checkout Cartão | `/checkout/cc` (POST) | Processa pagamento via Cartão de Crédito. |
| Pagamento Sucesso | `/checkout/payment-success` | Tela de confirmação após pagamento. |
| Pagamento Erro | `/checkout/payment-error` | Tela de erro no pagamento. |
| **Integrações e Webhooks** | | |
| Webhook Pagarme | `/pagarme/paid` | Recebe notificação de pagamento (Pagar.me). |
| Rastreamento | `/track` | Endpoint de rastreamento de ações. |
| Webhook Geral | `/webhook/payment/confirmation` | Confirmação de pagamento genérica. |
