File: readme.txt
Script Name: vAuthenticate 3.0.1
Author: Vincent Ryan Ong
Email: support@beanbug.net

Description:
vAuthenticate is a revolutionary authentication script which uses
PHP and MySQL for lightning fast processing. vAuthenticate comes 
with an admin interface where webmasters and administrators can
create new user accounts, new user groups, activate/inactivate 
groups or individual accounts, set user level, etc. This may be
used to protect files for member-only areas. vAuthenticate 
uses a custom class to handle the bulk of insertion, updates, and
deletion of data. This class can also be used for other applications
which needs user authentication.

This script is a freeware but if you want to give donations,
please send your checks (coz cash will probably be stolen in the
post office) them to:

Vincent Ryan Ong
Rm. 440 Wellington Bldg.
655 Condesa St. Binondo, Manila
Philippines, 1006


==============================
 vAuthenticate 3.0.1 README FILE
==============================

Contents:
  * Introduction
  * Package content
  * Requirements
  * Upgrading
  * Installation
  * Administration
  * Usage
  * Demo
  * On future releases
  * FAQ's
  * Change Log

~~~~~~~~~~~~~~~~~~~~~~~

* INTRODUCTION
  vAuthenticate is an authentication system which can integrate with any
  existing website that meets the requirements. It works well with 
  vNews and vPoll. vAuthenticate provides a gatekeeper wherein
  any user or admin must satisfy the password verification to either 
  log in (user) to a protected area or administer (admin) the
  vAuthenticate admin control panel.

    FEATURES:
    1. Flexibility
	= vAuthenticate allows administrators and webmasters to integrate it
	  with the current unprotected website. This is specially useful
	  if major changes are going to be painful. With vAuthenticate, you're
	  just one step towards getting the security you needed most.
    
    2. Speed
	= vAuthenticate uses the dynamic-duo of PHP and MySQL which enables
	  blazing fast transactions where only your server speed dictates 
	  the limit.
    
    3. Compactness
	= vAuthenticate is very small thus takes up little space allowing 
	  you more room to enhance your site's other features.

    4. User groups
	= vAuthenticate allows you to group your members into teams. Each team
	  has a team lead. vAuthenticate gives you the option to use such teams
	  just in case you need them although it would work even for simple 
	  sites which do not need such features. A powerful function of user
	  groups is its ability to give admins the chance to inactivate ALL
	  members in the group at once. No more modifying each record. Just 
	  imagine if there are a hundred members to inactivate!

    5. Portability
	= vAuthenticate makes use of a custom class called auth.php. This class
	  handles all the insertions, deletions, etc. of the system. This can 
	  be used with other PHP scripts even without the admin interface.

    6. Ease of use
	= vAuthenticate comes with a powerful administration interface that lets
	  site administrators and webmasters control access to protected 
	  pages.


* PACKAGE CONTENT
  auth.php - authentication class 
  authconfig.php - file and database configuration file 
  createdb.sql - table creation file 
  patch-301.sql - required update to version 3.0.1 (FOR USERS OF ANY VERSION BELOW
		3.0.1)
  failed.php - page to display when login is incorrect
  login.php - sample login interface
  logout.php - logout file used to close the current session
  check.php - file to include on top part of pages to secure.
  vAuthenticate.php - result file that is opened after loging in. This file calls
		either the success or failed page upon login.
  readme.txt - this file
  faq.php - list of frequently asked questions and the corresponding answers
  AuthClass.txt - Detailed class description for auth.php
  chgpwd.php - file to allow members to change their password
  admin/authgroup.php - group administration file 
  admin/authuser.php - user administration file 
  admin/index.php - administration home page 
  members/index.php - page to display when login is successful
  members/page2.php - sample secured page. use direct access to test
  members/bygroup.php - sample page security on a per-group basis
  members/bylevel.php - sample page security on a per-level basis


* REQUIREMENTS
  OS: Linux, Windows NT/2000 Server Family, Windows XP, Unix
  WEB SERVER: Apache (latest release)
  SCRIPTING: PHP 4 (latest stable release)
  DB: MySQL (latest stable release)
  DB MANAGEMENT: phpMyAdmin or any similar types of db manager
  BROWSER: Cookie-Enabled; Javascript-Enabled


* UPGRADING  
   - This section is only applicable for people who has an existing vAuthenticate 3.0 
	and below installed in their server.

  1. Open your DB Manager and execute patch-301.sql. You are not required to 
	include patch-301.sql in your online folder since it is only needed
	once, during database schema upgrade. This patch is needed because the
	value contained in this field would be encrypted with MD5 encryption which 
	needs 32 character-spaces for storage.

  2. Re-upload all the files (see section: Package Content) except for
	*.sql files.

  NOTE: Basically, this version massively changed auth.php, authuser.php, and
	authgroup.php. authconfig.php has been added an additional line to 
	support illegal access via direct method to a secured file. It is up to 
	you to decide whether you want to upgrade your existing installation
	or re-install this script. HOWEVER, it is highly recommended that
	you re-install from scratch since this is a major version release.


* INSTALLATION
  1. Open your DB Manager and execute createdb.sql. You are not required to 
	include createdb.sql in your online folder since it is only needed
	once, during database creation.

  2. Edit authconfig.php and set the values to reflect your host's
     	configuration. If you are going to use vAuthenticate out 
	of the box, it is recommended that you only edit the DB
	settings in the authconfig.php. Later on, when you are ready
	to deploy it in your site, edit the failed and success 
	paths in authconfig.php to reflect the path to your failed 
	and success pages.

  3. Edit auth.php and edit the lines with var such that it reflects 
	that of your web host. Note that this is the same with the 
	DB Settings in authconfig.php

  4. If you are going to use vAuthenticate in your existing site, be sure
	to take note of this:
	a. The file where your login page (the one with the username and 
	   password text box) should contain the include statement similar
	   to the ones found in login.php. 
	b. The form action should also be the same with that of login.php
	   (which is vAuthenticate.php) because this calls the results page 
	   which in turn calls and makes use of the auth.php class.
	c. The username text box MUST have name="username" and the password
	   textbox should have name="password". Take note of the case. All
	   names are in small caps. vAuthenticate will NOT work if you set 
	   the name of the username and password fields to any other name.

  5. Unlike the previous versions of vAuthenticate, starting from version 2.8, 
	vAuthenticate.php makes use of Javascript redirection instead of
	PHP include statements to point the user to the proper page.

  6. All files under the admin folder must remain that way. The admin folder
	itself MUST reside inside the folder where vAuthenticate is located. 
	Although you can change this in authconfig.php, it is not recommended
	to change the line unless you know a great deal about server side
	includes and pathname resolution.

  7. OPTIONAL: Edit check.php so that you can customize the look of the error
	message to display when an illegal access using direct method is used
	on files. Be sure to change only the HTML part of the file unless you know
	what you are doing.

  8. Upload all files (see Package Content for details) in ASCII to any 
	directory as long as the success and failed pages are properly
	taken into consideration (see authconfig.php for path revisions). 


* ADMINISTRATION
  After installation, 2 new table named "authuser" and "authgroup"
  should have been created including the built-in users and groups.
  Follow the instructions below to administer vAuthenticate.

    LOGGING IN AS ADMINISTRATOR:
    1. Go the the login page of the website.

    2. Login as "sa" and enter the password. (Upon installation, the 
	password of all users is "access")

    ADDING USERS
    1. After loggin in, click on Users in the top menu of the admin
	home page.
    2. Enter the details. Take note of messages which would be given
	by the system regarding your entry.
    3. If you have already entered a user or modified one but still
	want to enter another, click on the "Add New" button.

    MODIFYING USERS
    1. Click on the desired username on the user list found at the 
	right side of the user administration area
    2. Modify the information. If you leave the password field blank,
	this will mean that you don't want to change the member's 
	password. If you enter something in the password field,
	this will be the member's new password.
    3. Press Modify button to save changes

    DELETING USERS
    1. Click on the desired username on the user list found at the 
	right side of the user administration area
    2. Press Delete button to remove user
	 
    ADDING A NEW TEAM
    1. Either:
	a. Click on the link named Add beside the team drop-down list
	   in the user administration area
	
	OR

	b. Click on the Groups link on the top menu.
    2. Enter the info needed. 

    MODIFYING A TEAM
    1. Click on the desired team name on the team list found at the 
	right side of the team administration area
    2. Modify the information 
    3. Press Modify button to save changes
    4. Making a team inactive automatically makes ALL users in the 
	team to be inactivated

    DELETE A TEAM
    1. Click on the desired team name on the team list found at the 
	right side of the team administration area
    2. Press Delete button remove the group.
    3. Deleting a team automatically makes all members of the team 
	a member of Ungrouped.


* USAGE
  ALL records in the authuser table contains the following info:
	1. id (use $check['id'] to get the unique id) - this is used for sorting
	   purposes only and can be used as an alternative primary key
	2. username (use $check['uname'] to get the username) - this is the 
	   username of the member
	3. password (use $check['passwd'] to get the passwd) - this is the 
	   password of the member
	4. team (use $check['team'] to get the team name) - this is the 
	   teamname of the member
	5. level (use $check['level'] to get the level) - this is the 
	   level of the member
	6. status (use $check['status'] to get the status) - this is the 
	   status of the member which can either be active or inactive
	7. lastlogin (use $check['lastlogin'] to get the last login date and time) - 
	  this is a timestamp on the last lagin date and time of a member.
	8. logincount (use $check['logincount'] to get count) - this is a 
	  counter which increments everytime a member/admin logs in.

  For example, login to the members area as a member and you'll see that there
	there are 2 examples provided. One is to restrict by level and the
	other is to restrict by group.

  You may use auth.php to automatically add users to the DB from your
	existing signup form. BUT, to do this, you would need to have an
	understanding of what auth.php returns for each transaction 
	you make. For more info regarding this, check out AuthClass.txt

  To secure pages, you would need to add the following lines on top of the pages
	you want to secure:
	
	<?
		include_once ("path/to/auth.php");
		include_once ("path/to/authconfig.php");
		include_once ("path/to/check.php");	
	?>

	where path/to/ refers to the path of the files relative to the current
	directory of the file being secured. For an example, please see 
	page2.php. If you haven' logged in yet or have logged in using a
	wrong username and password, you will get an Illegal Access 
	error on page2.php. However, if you have logged in successfully
	and without closing the browser, you tried accessing page2.php, 
	you'll notice that you can see the message (2 to 3 lines) in the file.

  Take note that adding those "include lines" on top of your secured pages only 
	facilitate in checking of the username and password combination stored
	in the cookie. This is to protect it from direct file access. If you want to add 
	the necessary authentication code that takes note of the rules
	(for example, only level 4 members can access this page; or only
	members from the Friends group/team are allowed to see this page) that 
	you've made to be available in this file too, you would have to add something
	like the following on top of your secured pages:

	<?
		include_once ("path/to/auth.php");
		include_once ("path/to/authconfig.php");
		include_once ("path/to/check.php");	

		// Check for permission to view this page
		if ($check['level'] != 4)
		{
			print "<font face=\"Arial\" size=\"5\" color=\"#FF0000\">";
			print "<b>Illegal Access</b>";
			print "</font><br>";
  			print "<font face=\"Verdana\" size=\"2\" color=\"#000000\">";
			print "<b>You do not have permission to view this page.</b></font>";
			exit;	// Stop script execution
		}
	?>

  One thing to note: Usernames of level 1 cannot browse secured pages. To be
    	be able to do this, it is recommended to create a new group called Browsers
	with new usernames that the admin users can use for browsing secured pages.
	vAuthenticate was made such that admin usernames are made specifically for
	security administration.
	

* DEMO
  Here's a little something to let you test out and learn how to restrict access to pages
	on a per-group or per-level basis.

	1. Login as "sa" or "admin"
	2. Notice that there are usernames called G1-0001, G1-0002, etc.
	3. Click on these and take note of the team they are a part of and their level.
	4. For you to remember them easily, a convention was used for the usernames.
		G1-0001 stands for the first user under Group 1.
		G1-0002 stands for the second user under Group 1.
		G2-0001 stands for the first user under Group 2.
		... and so on ...
	5. Logoff as "sa" or "admin"
	6. Login as any of the users (except sa, admin, and test). Take note that their
		password is by default, "access" (unless you change them of course)
	7. You will be taken to the members' index page. Here, you'll see 2 links for
		demo purposes.
	8. Depending on the user you logged in with and the credentials that come with
		that user, you might or might not see the intended content for 
		the bygroup.php and bylevel.php.


* ON FUTURE RELEASES
  Below is a list of much-awaited features which was either emailed to me as a bug
	or as a script suggestion. Neither of these are guaranteed to be on the next 
	release though. I do make sure to address all concerns... specially bugs.

	1. Use of addslashes() and stripslashes() for fields being sent to MySQL
	2. Disallow multiple logins to the system 
	3. Encrypted username and password for cookies
	4. Paginate user and group list in administration interface
	5. Make administration interface more pleasing to the eyes (hehe)
	6. Make some demonstration area
	7. Add a new function to the auth class which will give us the list of currently
		online users and the total logged-in user count 
	8. Add an optional expiration date field for user accounts
	9. Remove the process of editing numerous lines in authconfig.php by creating
		an installer of some sort


* FAQ's
  Please refer to faq.txt


* CHANGE LOG
	version 1.1 - Changed .cls and .inc extensions to .php for a more
			secured script.
	
	version 2.0 - Session support.
		  - Security against direct access to secured files.
		  - Additional details available for users (Last Login and Login Count).
		  - Revised DB querying method to support latest PHP versions.
	
	version 2.8 - Removed empty line in auth.php which causes an error on some web
			servers
		  - Added logout functionality
		  - Used javascript redirection in vAuthenticate.php to preserve original
			pathing of links on secured page
		  - Fixed a major bug in the admin area. Details are:
			On previous versions of vAuthenticate, assuming a user has 
			successfully logged into the members area, if he knows the URL
			to the admin pages (specially authuser.php and authgroup.php)
			he can have access to those pages.
		  - Added security to admin area
		  - Easier navigation in the admin area
		  - Added functionality to allow members to change their own password
		  - created a members directory in the package to make it more organized
		  - modified authuser.php to avoid passing all user details via GET method
			when editing the account

	version 3.0 - Added support for register_globals that are turned off by default
		  - Password is now encrypted upon addition of member
		  - Added 2 sample pages which would demonstrate how to restrict by
			group or by level
		  - Used more efficient code by eliminating previously recommended
			conditional statements for secured files. Introduced the use of
			include_once which would make code execution a little bit faster
		  - Modified code to limit the use of double quotes for array values and other 
			stuff. This is another small step in providing a secure script.
		  - Modified auth.php class' "modify" function to accommodate flexibility in
			modifying existing password for members
		  - Added support for websites based on an IP address instead of a domain
			name
		  - Added a couple of usernames and password with various groups and levels
			used for demonstration.

	version 3.0.1 - Fixed notices for undefined indexes
		  - Fixed sample page (bygroup.php) condition statement
		  - Modified auth.php class' "add user" to restrict on blank password for users being
			created
		  - Changed password field's structure to accommodate 32 characters for MD5
			encryption
		  - Changed encryption from MySQL's password() function to MD5
		  - Restricted inactivation of "sa" and "admin" users


*****************************************
THAT's IT!
email support@beanbug.net for support.
*****************************************
