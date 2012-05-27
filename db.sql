/* tables for pasteros (mysql) */
| content | CREATE TABLE `content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `content` varchar(65000) DEFAULT NULL,
  `time` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=latin1 |




/* table creation for postgresql */
CREATE SEQUENCE content_seq START 1;
/* if having permisson errors, use this */
ALTER TABLE content_seq OWNER TO TABLEUSER;

CREATE table content (
id int NOT NULL UNIQUE PRIMARY KEY DEFAULT nextval('content_seq'), 
name  VARCHAR(60) NULL,
content  TEXT NOT NULL,
visible boolean DEFAULT TRUE,
time TIMESTAMP DEFAULT now()
);

