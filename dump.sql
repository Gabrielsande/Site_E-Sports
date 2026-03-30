-- ============================================
-- FragZone — Portal de Games e E-Sports
-- dump.sql
-- ============================================

CREATE DATABASE IF NOT EXISTS fragzone CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE fragzone;

CREATE TABLE IF NOT EXISTS usuarios (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    nome       VARCHAR(100)  NOT NULL,
    email      VARCHAR(150)  NOT NULL UNIQUE,
    senha      VARCHAR(255)  NOT NULL,
    criado_em  DATETIME      DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS noticias (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    titulo  VARCHAR(255) NOT NULL,
    noticia TEXT         NOT NULL,
    data    DATETIME     DEFAULT CURRENT_TIMESTAMP,
    autor   INT          NOT NULL,
    imagem  VARCHAR(255) DEFAULT NULL,
    FOREIGN KEY (autor) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Usuário demo (senha: 123456)
INSERT INTO usuarios (nome, email, senha) VALUES
('Admin FragZone', 'admin@fragzone.gg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Notícias de exemplo
INSERT INTO noticias (titulo, noticia, data, autor) VALUES
(
    'CBLOL 2026: LOUD domina fase de grupos com campanha invicta',
    'A LOUD encerrou a fase de grupos do CBLOL 2026 com um aproveitamento perfeito, vencendo todas as nove partidas disputadas. O destaque foi o mid laner Robo, eleito MVP da fase com uma média de 8,3 KDA. A equipe mostrou versatilidade com mais de 20 composições diferentes e chega às semifinais como grande favorita ao título. O técnico Chucky ressaltou o comprometimento do time nos treinos e a maturidade dos jogadores mais jovens. O confronto das semifinais está marcado para o próximo sábado no estúdio da Riot Games em São Paulo.',
    NOW(), 1
),
(
    'Counter-Strike 2: Valve anuncia Major de Paris com premiação recorde de US$ 2 milhões',
    'A Valve surpreendeu a comunidade de CS2 ao anunciar o Major de Paris 2026 com a maior premiação da história do torneio: US$ 2 milhões distribuídos entre as 24 equipes participantes. O evento acontece entre os dias 10 e 26 de julho no Accor Arena, com capacidade para 20 mil espectadores. O Brasil terá representação com FURIA Esports e Imperial, que conquistaram suas vagas através da Regional Major Rankings. O formato inclui uma fase de grupos suíço, quartas de final e fases eliminatórias ao vivo.',
    NOW(), 1
),
(
    'GTA VI: Rockstar confirma data de lançamento e revela detalhes do modo online',
    'A Rockstar Games confirmou oficialmente que Grand Theft Auto VI chega ao PlayStation 5 e Xbox Series X|S no dia 15 de setembro de 2026, com versão para PC prevista seis meses depois. O estúdio revelou detalhes inéditos do modo GTA Online 2.0, que promete ser lançado simultaneamente ao jogo principal com suporte para até 32 jogadores por sessão, economia própria e eventos sazonais. A campanha single-player tem duração estimada de mais de 60 horas e se passa nos estados fictícios de Leonida e Vice City.',
    NOW(), 1
),
(
    'Free Fire World Series 2026: Brasil é campeão com virada épica na final',
    'A seleção brasileira de Free Fire conquistou o título mundial da Free Fire World Series 2026 após uma virada histórica na grande final realizada em Bangkok, na Tailândia. O Brasil chegou ao último mapa em terceiro lugar, mas uma partida perfeita do sniper "Nobru" garantiu o Booyah decisivo com 12 eliminações. Foi o terceiro título mundial do Brasil na modalidade, consolidando o país como a maior potência do Free Fire competitivo no mundo. A conquista foi celebrada por milhões de fãs nas redes sociais.',
    NOW(), 1
);
