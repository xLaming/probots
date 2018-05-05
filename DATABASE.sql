CREATE TABLE IF NOT EXISTS `accounts` (
  `index` int(11) NOT NULL AUTO_INCREMENT,
  `chat` varchar(100) NOT NULL,
  `automember` int(11) NOT NULL,
  `commandchar` varchar(10) NOT NULL,
  `accesslist` text NOT NULL,
  `nick` varchar(255) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `homepage` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `statusglow` varchar(10) NOT NULL,
  `statuscolor` varchar(10) NOT NULL,
  `nameglow` varchar(10) NOT NULL,
  `namecolor` varchar(10) NOT NULL,
  `hatcode` varchar(5) NOT NULL,
  `hatcolor` varchar(10) NOT NULL,
  `pcback` varchar(255) NOT NULL,
  `stealth` int(11) NOT NULL,
  `welcome` varchar(255) NOT NULL,
  `chatinfo` text NOT NULL,
  PRIMARY KEY (`index`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `accounts` (`index`, `chat`, `automember`, `commandchar`, `accesslist`, `nick`, `avatar`, `homepage`, `status`, `statusglow`, `statuscolor`, `nameglow`, `namecolor`, `hatcode`, `hatcolor`, `pcback`, `stealth`, `welcome`, `chatinfo`) VALUES
(1, 'xLaming', 1, '!', '[42,100,956544769]', 'Bot', '123', 'Created by xLaming.', 'Nothing', '000001', 'ffffff', '000001', 'ffffff', 't', 'r', 'http://site.com/image.png', 1, 'Welcome to my chat {user}, your current rank is {rank}!', '');