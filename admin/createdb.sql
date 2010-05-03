# File: createdb.sql
# Script Name: vAuthenticate 3.0.1
# Author: Vincent Ryan Ong
# Email: support@beanbug.net
#
# Description:
# vAuthenticate is a revolutionary authentication script which uses
# PHP and MySQL for lightning fast processing. vAuthenticate comes 
# with an admin interface where webmasters and administrators can
# create new user accounts, new user groups, activate/inactivate 
# groups or individual accounts, set user level, etc. This may be
# used to protect files for member-only areas. vAuthenticate 
# uses a custom class to handle the bulk of insertion, updates, and
# deletion of data. This class can also be used for other applications
# which needs user authentication.
#
# This script is a freeware but if you want to give donations,
# please send your checks (coz cash will probably be stolen in the
# post office) them to:
#
# Vincent Ryan Ong
# Rm. 440 Wellington Bldg.
# 655 Condesa St. Binondo, Manila
# Philippines, 1006


#
# Table structure for table `authteam`
#

CREATE TABLE authteam (
  id int(4) NOT NULL auto_increment,
  teamname varchar(25) NOT NULL default '',
  teamlead varchar(25) NOT NULL default '',
  status varchar(10) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY teamname (teamname,teamlead)
) TYPE=MyISAM;

#
# Dumping data for table `authteam`
#

INSERT INTO authteam VALUES (1, 'Ungrouped', 'sa', 'active');
INSERT INTO authteam VALUES (2, 'Admin', 'sa', 'active');
INSERT INTO authteam VALUES (3, 'Temporary', 'sa', 'active');
INSERT INTO authteam VALUES (7, 'Group 1', 'sa', 'active');
INSERT INTO authteam VALUES (8, 'Group 2', 'test', 'active');
INSERT INTO authteam VALUES (9, 'Group 3', 'admin', 'active');
# --------------------------------------------------------

#
# Table structure for table `authuser`
#

CREATE TABLE authuser (
  id int(11) NOT NULL auto_increment,
  uname varchar(25) NOT NULL default '',
  passwd varchar(32) NOT NULL default '',
  team varchar(25) NOT NULL default '',
  level int(4) NOT NULL default '0',
  status varchar(10) NOT NULL default '',
  lastlogin datetime default NULL,
  logincount int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `authuser`
#

INSERT INTO authuser VALUES (1, 'sa', '9df3b01c60df20d13843841ff0d4482c', 'Admin', 1, 'active', '2003-04-04 10:59:36', 0);
INSERT INTO authuser VALUES (2, 'admin', '9df3b01c60df20d13843841ff0d4482c', 'Admin', 1, 'active', '2003-03-29 17:17:21', 0);
INSERT INTO authuser VALUES (3, 'test', '9df3b01c60df20d13843841ff0d4482c', 'Temporary', 999, 'active', '2003-04-03 00:00:34', 0);
INSERT INTO authuser VALUES (11, 'G1-0001', '9df3b01c60df20d13843841ff0d4482c', 'Group 1', 5, 'active', '2003-04-04 10:59:02', 0);
INSERT INTO authuser VALUES (12, 'G1-0002', '9df3b01c60df20d13843841ff0d4482c', 'Group 1', 2, 'active', '0000-00-00 00:00:00', 0);
INSERT INTO authuser VALUES (13, 'G2-0001', '9df3b01c60df20d13843841ff0d4482c', 'Group 2', 5, 'active', '2003-04-03 00:46:20', 0);
INSERT INTO authuser VALUES (14, 'G2-0002', '9df3b01c60df20d13843841ff0d4482c', 'Group 2', 6, 'active', '2003-04-03 00:48:04', 0);
INSERT INTO authuser VALUES (15, 'G2-0003', '9df3b01c60df20d13843841ff0d4482c', 'Group 2', 3, 'active', '2003-04-04 10:31:16', 0);
INSERT INTO authuser VALUES (16, 'G3-0001', '9df3b01c60df20d13843841ff0d4482c', 'Group 3', 10, 'active', '0000-00-00 00:00:00', 0);
INSERT INTO authuser VALUES (17, 'G3-0002', '9df3b01c60df20d13843841ff0d4482c', 'Group 3', 4, 'active', '0000-00-00 00:00:00', 0);