#
# Структура для таблицы `ymarket_ips`: 
#

CREATE TABLE `ymarket_ips` (
  `id` INTEGER(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `ip` VARCHAR(40) COLLATE utf8_general_ci NOT NULL COMMENT 'IP адрес',
  `last_date_use` DATETIME NOT NULL COMMENT 'Дата последнего использования',
  `date_create` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Добавлен',
  PRIMARY KEY USING BTREE (`id`) COMMENT '',
  UNIQUE INDEX `ip` USING BTREE (`ip`) COMMENT ''
)ENGINE=InnoDB
AUTO_INCREMENT=32 AVG_ROW_LENGTH=528 CHARACTER SET 'utf8' COLLATE 'utf8_general_ci'
COMMENT=''
;

#
# Data for the `ymarket_ips` table  (LIMIT -468,500)
#

INSERT INTO `ymarket_ips` (`id`, `ip`, `last_date_use`, `date_create`) VALUES

  (1,'193.169.87.35','2011-09-21 14:37:24','2011-09-13 17:38:07'),
  (2,'193.169.86.18','2011-09-21 14:34:33','2011-09-13 17:38:07'),
  (3,'193.169.86.40','2011-09-21 14:34:34','2011-09-13 17:38:07'),
  (4,'193.169.87.18','2011-09-21 14:37:23','2011-09-13 17:38:07'),
  (5,'193.169.87.40','2011-09-21 14:36:25','2011-09-13 17:38:07'),
  (6,'91.213.8.246','2011-09-21 14:36:23','2011-09-13 17:38:07'),
  (7,'91.213.8.245','2011-09-21 14:35:24','2011-09-13 17:38:07'),
  (8,'91.207.60.160','2011-09-21 14:31:24','2011-09-13 17:38:07'),
  (9,'91.207.60.161','2011-09-21 14:35:23','2011-09-13 17:38:07'),
  (10,'91.207.60.162','2011-09-21 14:34:23','2011-09-13 17:38:07'),
  (11,'91.207.60.163','2011-09-21 14:33:24','2011-09-13 17:38:07'),
  (12,'91.207.60.164','2011-09-21 14:33:23','2011-09-13 17:38:07'),
  (13,'91.207.60.165','2011-09-21 14:32:25','2011-09-13 17:38:07'),
  (14,'91.207.60.166','2011-09-21 14:32:23','2011-09-13 17:38:07'),
  (15,'91.207.60.167','2011-09-21 14:31:23','2011-09-13 17:38:07'),
  (16,'91.207.60.168','2011-09-21 14:38:33','2011-09-13 17:38:07'),
  (17,'91.207.60.169','2011-09-21 14:30:25','2011-09-13 17:38:07'),
  (18,'91.207.60.170','2011-09-21 14:30:22','2011-09-13 17:38:07'),
  (19,'91.207.60.171','2011-09-21 14:29:24','2011-09-13 17:38:07'),
  (20,'91.207.61.160','2011-09-21 14:29:23','2011-09-13 17:38:07'),
  (21,'91.207.61.161','2011-09-21 14:28:27','2011-09-13 17:38:07'),
  (22,'91.207.61.162','2011-09-21 14:28:24','2011-09-13 17:38:07'),
  (23,'91.207.61.163','2011-09-21 14:27:25','2011-09-13 17:38:07'),
  (24,'91.207.61.164','2011-09-21 14:27:23','2011-09-13 17:38:07'),
  (25,'91.207.61.165','2011-09-21 14:40:24','2011-09-13 17:38:07'),
  (26,'91.207.61.166','2011-09-21 14:40:23','2011-09-13 17:38:07'),
  (27,'91.207.61.167','2011-09-21 14:39:24','2011-09-13 17:38:07'),
  (28,'91.207.61.168','2011-09-21 14:39:23','2011-09-13 17:38:07'),
  (29,'91.207.61.169','2011-09-21 14:38:35','2011-09-13 17:38:07'),
  (30,'91.207.61.170','2011-09-21 14:30:26','2011-09-13 17:38:07'),
  (31,'91.207.61.171','2011-09-21 14:38:23','2011-09-13 17:38:07');
COMMIT;
