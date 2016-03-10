SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Banco de Dados: `ptrends`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `assignees`
--

DROP TABLE IF EXISTS `assignees`;
CREATE TABLE `assignees` (
  `id` int(11) NOT NULL auto_increment,
  `orgname` varchar(128) NOT NULL,
  `alias` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `parties`
--

DROP TABLE IF EXISTS `parties`;
CREATE TABLE `parties` (
  `id` int(11) NOT NULL auto_increment,
  `first_name` varchar(128) NOT NULL,
  `last_name` varchar(128) NOT NULL,
  `country` varchar(2) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `patents`
--

DROP TABLE IF EXISTS `patents`;
CREATE TABLE `patents` (
  `id` varchar(64) NOT NULL,
  `title` text NOT NULL,
  `abstract` text NOT NULL,
  `claims` text NOT NULL,
  `description` text NOT NULL,
  `date` int(11) NOT NULL,
  `appl_type` varchar(128) NOT NULL,
  `appl_number` varchar(64) NOT NULL,
  `appl_date` int(11) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `patent_tags`
--

DROP TABLE IF EXISTS `patent_tags`;
CREATE TABLE `patent_tags` (
  `id_patent` varchar(128) NOT NULL,
  `id_tag` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `weight` int(11) NOT NULL,
  `tag_from` varchar(16) NOT NULL
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `patent_assignees`
--

DROP TABLE IF EXISTS `patent_assignees`;
CREATE TABLE `patent_assignees` (
  `id_patent` varchar(128) NOT NULL,
  `id_assignee` int(11) NOT NULL,
  KEY `id_patent` (`id_patent`,`id_assignee`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `patent_parties`
--

DROP TABLE IF EXISTS `patent_parties`;
CREATE TABLE `patent_parties` (
  `id_patent` varchar(128) NOT NULL,
  `id_partie` int(11) NOT NULL,
  KEY `id_patent` (`id_patent`,`id_partie`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `references`
--

DROP TABLE IF EXISTS `references`;
CREATE TABLE `references` (
  `id` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `date` int(11) NOT NULL,
  `country` varchar(2) NOT NULL
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `patent_references`
--

DROP TABLE IF EXISTS `patent_references`;
CREATE TABLE `patent_references` (
  `id_patent` varchar(128) NOT NULL,
  `id_reference` varchar(128) NOT NULL,
  KEY `id_patent` (`id_patent`,`id_reference`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `references_other`
--

DROP TABLE IF EXISTS `references_other`;
CREATE TABLE `references_other` (
  `id` int(11) NOT NULL auto_increment,
  `othercit` text NOT NULL,
  `category` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `patent_references_other`
--

DROP TABLE IF EXISTS `patent_references_other`;
CREATE TABLE `patent_references_other` (
  `id_patent` varchar(128) NOT NULL,
  `id_reference_other` varchar(128) NOT NULL,
  KEY `id_patent` (`id_patent`,`id_reference_other`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tags`
--

DROP TABLE IF EXISTS `tags`;
CREATE TABLE `tags` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `tags_alias`
--

DROP TABLE IF EXISTS `tags_alias`;
CREATE TABLE `tags_alias` (
  `id` int(11) NOT NULL auto_increment,
  `id_tag` int(11) NOT NULL,
  `alias` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

-- --------------------------------------------------------

--
-- Estrutura da tabela `stopwords`
--

DROP TABLE IF EXISTS `stopwords`;
CREATE TABLE `stopwords` (
  `id` int(11) NOT NULL auto_increment,
  `stopword` varchar(128) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
