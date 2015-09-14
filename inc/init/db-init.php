<?php

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
$db->query_row(
  "CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `signup` varchar(255) NOT NULL,
  `last_login` varchar(255) NOT NULL,
  `ip` varchar(255) NOT NULL,
  `level` tinyint(4) NOT NULL DEFAULT 0,
  `activated` int(11) NOT NULL DEFAULT '0',
  `activation_key` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1"
);
$db->query_row("CREATE TABLE IF NOT EXISTS `login_attempts` (
  `ip` varchar(255) NOT NULL,
  `attempts` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `throttle` varchar(255) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1");

if(!$db->tableExists('users')){
 echo 'There was an issue creating the users table';
}elseif(!$db->tableExists('login_attempts')){
  echo 'There was an issue creating the login_attempts table';
}
