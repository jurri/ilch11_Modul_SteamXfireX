DROP TABLE IF EXISTS `prefix_pronetconfig`;
CREATE TABLE `prefix_pronetconfig` (
  `pc_pk` int(11) NOT NULL AUTO_INCREMENT,
  `pc_str` varchar(4000) COLLATE latin1_german1_ci NOT NULL,
  `pc_active` varchar(1000) COLLATE latin1_german1_ci NOT NULL DEFAULT '0',
  PRIMARY KEY (`pc_pk`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

INSERT INTO `prefix_pronetconfig` (`pc_pk`, `pc_str`, `pc_active`) VALUES
(1, 'add_steam',  '1'),
(2, 'add_xfire',  '1'),
(3, 'add_recht',  '0'),
(4, 'img_steam',  '0'),
(5, 'img_xfire',  '0');

DROP TABLE IF EXISTS `prefix_pronetsignatur`;
CREATE TABLE `prefix_pronetsignatur` (
  `ps_pk` int(11) NOT NULL AUTO_INCREMENT,
  `ps_code` varchar(50) COLLATE latin1_german1_ci NOT NULL,
  `ps_imglink` varchar(2000) COLLATE latin1_german1_ci NOT NULL,
  `ps_art` varchar(10) COLLATE latin1_german1_ci NOT NULL,
  `ps_zusatz` varchar(50) COLLATE latin1_german1_ci NOT NULL DEFAULT '0',
  `ps_active` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`ps_pk`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci;

INSERT INTO `prefix_pronetsignatur` (`ps_pk`, `ps_code`, `ps_imglink`, `ps_art`, `ps_zusatz`, `ps_active`) VALUES
(1, 'Status', 'http://steamsignature.com/status/german/76561198103624909.png',  'steam',  '0',  0),
(2, 'Profile',  'http://steamsignature.com/profile/german/76561198103624909.png', 'steam',  '0',  1),
(3, 'Card', 'http://steamsignature.com/card/0/76561198103624909.png', 'steam',  '1',  0),
(4, 'Card', 'http://steamsignature.com/card/1/76561198103624909.png', 'steam',  '2',  0),
(5, 'Default',  'http://badges.steamprofile.com/profile/default/steam/76561198103624909.png', 'steam',  '0',  0),
(6, 'Klassisch',  '/type/0/dSFeTTsack.png__440__111', 'xfire',  'sh', 1),
(7, 'Kompakt',  '/type/1/dSFeTTsack.png__277__63',  'xfire',  'sh', 0),
(8, 'kurz&breit', '/type/2/dSFeTTsack.png__450__34',  'xfire',  'sh', 0),
(9, 'Winzig', '/type/3/dSFeTTsack.png__149__29',  'xfire',  'sh', 0);


insert into `prefix_modules`(url, name, gshow, ashow, fright) values ('pronetlist', 'Propriet&auml;r', '1', '1', '1');
	