-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 01/04/2026 às 22:45
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `noticiasge`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `noticias`
--

CREATE TABLE `noticias` (
  `id` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `noticia` text NOT NULL,
  `data` datetime DEFAULT current_timestamp(),
  `autor` int(11) NOT NULL,
  `imagem` varchar(255) DEFAULT NULL,
  `categoria` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `noticias`
--

INSERT INTO `noticias` (`id`, `titulo`, `noticia`, `data`, `autor`, `imagem`, `categoria`) VALUES
(1, 'Edição Especial – O Mundo Competitivo dos Games', '🕹️ Capa: O Crescimento dos E-Sports no Brasil e no Mundo\r\n\r\nOs e-sports (esportes eletrônicos) deixaram de ser apenas um hobby e se tornaram uma das maiores indústrias do entretenimento global. Com milhões de fãs, campeonatos milionários e jogadores profissionais reconhecidos como atletas, os jogos competitivos conquistaram espaço definitivo na cultura moderna.\r\n\r\nNo Brasil, o cenário cresce rapidamente, com equipes profissionais, campeonatos nacionais e transmissão ao vivo em plataformas digitais.\r\n\r\n🧠 Matéria Principal: O que são E-Sports?\r\n\r\nE-sports são competições organizadas de jogos eletrônicos, onde jogadores ou equipes disputam partidas em alto nível, geralmente com regras oficiais, treinamentos intensos e premiações.\r\n\r\n📌 Principais características:\r\n\r\nCompetição profissional\r\nTreinamento constante\r\nEstratégia e trabalho em equipe\r\nTransmissões ao vivo (streams)\r\n🔥 Top Jogos Competitivos da Atualidade\r\n\r\n🎯 FPS (Tiro em primeira pessoa)\r\n\r\nCounter-Strike 2\r\nValorant\r\n\r\n⚔️ MOBA (Multiplayer Online Battle Arena)\r\n\r\nLeague of Legends\r\nDota 2\r\n\r\n⚽ Esportes\r\n\r\nEA Sports FC\r\nNBA 2K\r\n\r\n🚗 Outros gêneros populares\r\n\r\nFortnite (Battle Royale)\r\nRocket League (Futebol com carros)\r\n🏆 Grandes Campeonatos de E-Sports\r\n\r\nOs torneios de e-sports são eventos gigantescos, com premiações que chegam a milhões de dólares.\r\n\r\n🌍 Destaques:\r\n\r\nMundial de League of Legends\r\nThe International (Dota 2)\r\nMajor Championships (CS2)\r\nValorant Champions\r\n\r\nEsses eventos são assistidos por milhões de pessoas ao redor do mundo, tanto presencialmente quanto online.\r\n\r\n👤 Perfil do Jogador Profissional\r\n\r\nSer um jogador profissional vai muito além de jogar bem.\r\n\r\n📌 Rotina:\r\n\r\nTreinos diários (6 a 10 horas)\r\nAnálise de partidas\r\nTrabalho em equipe\r\nCuidados com saúde mental e física\r\n\r\n💡 Habilidades importantes:\r\n\r\nReflexo rápido\r\nTomada de decisão\r\nComunicação\r\nControle emocional\r\n💰 Mercado e Oportunidades\r\n\r\nO mercado de e-sports gera bilhões de reais por ano. Além dos jogadores, existem diversas profissões:\r\n\r\nStreamers\r\nTécnicos (coaches)\r\nAnalistas\r\nNarradores (casters)\r\nDesenvolvedores de jogos\r\nDesigners e programadores\r\n🎥 Streaming e Influência Digital\r\n\r\nPlataformas como:\r\n\r\nTwitch\r\nYouTube\r\n\r\npermitiram que jogadores compartilhassem suas partidas ao vivo, criando comunidades gigantes e gerando renda com visualizações, anúncios e doações.\r\n\r\n🇧🇷 E-Sports no Brasil\r\n\r\nO Brasil é um dos maiores públicos consumidores de games do mundo.\r\n\r\n🎯 Destaques:\r\n\r\nGrandes organizações competitivas\r\nTorcidas apaixonadas\r\nEventos presenciais lotados\r\nJogadores brasileiros reconhecidos mundialmente\r\n🧩 Curiosidades do Mundo Gamer\r\nO maior prêmio da história dos e-sports ultrapassa bilhões em reais somados\r\nAlguns jogadores começam a carreira antes dos 18 anos\r\nE-sports já são considerados esporte em alguns países\r\n🚀 Futuro dos E-Sports\r\n\r\nO futuro promete ainda mais crescimento com:\r\n\r\nRealidade virtual\r\nInteligência artificial\r\nMaior investimento de empresas\r\nInclusão em eventos esportivos globais\r\n🎯 Conclusão\r\n\r\nOs e-sports não são apenas jogos — são uma nova forma de esporte, entretenimento e carreira. Com tecnologia avançando e o público crescendo, esse universo só tende a evoluir cada vez mais.', '2026-04-01 16:24:44', 3, 'img_69cd70fc42f88.jpg', NULL),
(2, '🎮 REVISTA E-SPORTS BRASIL', '📰 Nova Notícia: Brasil conquista destaque internacional em campeonato de Valorant\r\n\r\nO cenário brasileiro de e-sports voltou a chamar atenção mundial após uma campanha impressionante no campeonato internacional de Valorant, um dos jogos competitivos mais populares da atualidade.\r\n\r\nA equipe brasileira surpreendeu analistas e fãs ao vencer grandes organizações internacionais, mostrando alto nível de estratégia, trabalho em equipe e controle emocional nas partidas decisivas.\r\n\r\n🇧🇷 Campanha histórica\r\n\r\nDurante o torneio, o time brasileiro enfrentou adversários da Europa, América do Norte e Ásia. Mesmo sendo considerado “azarão”, a equipe avançou até as fases finais com vitórias marcantes.\r\n\r\n📌 Destaques da campanha:\r\n\r\nViradas emocionantes\r\nJogadas individuais decisivas\r\nExcelente comunicação entre os jogadores\r\n🧠 Estratégia e evolução\r\n\r\nEspecialistas apontam que o sucesso brasileiro veio de uma combinação de fatores:\r\n\r\nTreinamento intensivo\r\nEstudo dos adversários\r\nAdaptação rápida durante as partidas\r\nUso eficiente das habilidades dos personagens\r\n\r\nO desempenho mostrou a evolução do Brasil no cenário competitivo de FPS tático.\r\n\r\n🌎 Reconhecimento global\r\n\r\nApós o campeonato, jogadores brasileiros ganharam destaque nas redes sociais e passaram a ser reconhecidos internacionalmente.\r\n\r\nOrganizações estrangeiras também demonstraram interesse em atletas do Brasil, o que pode abrir portas para novas oportunidades no exterior.\r\n\r\n🎙️ Impacto para o cenário nacional\r\n\r\nA conquista fortalece ainda mais os e-sports no Brasil, incentivando novos jogadores a seguirem carreira profissional.\r\n\r\nAlém disso, aumenta o investimento de patrocinadores e a visibilidade de campeonatos nacionais.\r\n\r\n🚀 O que vem pela frente?\r\n\r\nCom esse resultado, a expectativa é que o Brasil continue competitivo nos próximos torneios internacionais, consolidando sua posição como uma das potências emergentes nos e-sports.\r\n\r\n🎯 Conclusão\r\n\r\nA campanha brasileira mostra que talento, dedicação e estratégia podem colocar o país entre os melhores do mundo nos esportes eletrônicos. O futuro do cenário nacional promete ser ainda mais brilhante.', '2026-04-01 16:28:59', 4, 'img_69cd71fb777f5.jpg', NULL),
(3, '📰 Atualização Rápida: Novo recorde de audiência nos e-sports', 'O cenário competitivo bateu um novo recorde de espectadores simultâneos durante a final de um grande campeonato de League of Legends. Milhões de fãs acompanharam a decisão ao vivo, consolidando ainda mais os e-sports como um dos maiores entretenimentos do mundo.\r\n\r\nEspecialistas destacam que o crescimento se deve às transmissões online e ao aumento do público jovem, que consome cada vez mais conteúdo digital. 🚀', '2026-04-01 16:30:18', 4, 'img_69cd724a8b4b8.jpg', NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `criado_em` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `nome`, `email`, `senha`, `criado_em`) VALUES
(1, 'Admin FragZone', 'admin@fragzone.gg', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2026-04-01 14:53:24'),
(3, 'gabriel santos de sandes', 'gabrielsandes1903@gmail.com', '$2y$10$wXAT9gXcJJH68bOdFkuV6.85PYqLxhzBIsnAVFo9q8.wCqonDJa8u', '2026-04-01 16:21:37'),
(4, 'a a a', 'a@a.com', '$2y$10$Xe8.ke5J1WBKKCkmWhBjreAFsNNl6wNjzksFEi.ePw87JsOtgQgfK', '2026-04-01 16:27:24'),
(5, 'b b b', 'b@b.com', '$2y$10$Eyai6v6Vd3dO.3qZzggDLu7PNzqLe9CrK65AwFXDbnhqvWImMgqme', '2026-04-01 17:40:32');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `noticias`
--
ALTER TABLE `noticias`
  ADD PRIMARY KEY (`id`),
  ADD KEY `autor` (`autor`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `noticias`
--
ALTER TABLE `noticias`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `noticias`
--
ALTER TABLE `noticias`
  ADD CONSTRAINT `noticias_ibfk_1` FOREIGN KEY (`autor`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
