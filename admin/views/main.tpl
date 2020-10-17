<!doctype html>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="Keywords" content="admin panel">
	<meta name="Description" content="Admin panel is a computer application that supports the creation and modification of digital content using a common user interface and thus usually supporting multiple users working in a collaborative environment. Created by Kamil Wyremski - wyremski.pl">
	<meta name="author" content="Kamil Wyremski">
	<title>{{ title }}</title>

	<link rel="stylesheet" href="views/css/bootstrap.min.css">
	<link rel="stylesheet" href="views/css/bootstrap-datepicker.min.css">
	<link rel="stylesheet" href="views/css/style.css">
	<link rel="shortcut icon" href="images/favicon.png"/>

	<script src="js/jquery-3.2.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/bootstrap-datepicker.min.js"></script>
	<script src="js/bootstrap-datepicker.pl.min.js"></script>
	<script src="js/ckeditor/ckeditor.js"></script>
	<script src="js/engine_admin.js"></script>
</head>
<body>

{% block wrapper %}
<div id="wrapper">
  <nav class="main-nav navbar navbar-default navbar-static-top" role="navigation">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-nav">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="http://wyremski.pl" title="Kamil Wyremski - Web Design" target="_blank" id="logo"><img src="images/admin.png" alt="Admin Logo"></a>
    </div>
    <ul class="nav navbar-top-links navbar-right hidden-xs">
			<li><a href="?controller=admin" title="{{ 'Admin Panel Settings'|lang }}"><span class="glyphicon glyphicon-user"></span> Admin</a></li>
			<li><a href="?logOut" title="{{ 'Log out'|lang }}"><span class="glyphicon glyphicon-log-out"></span> {{ 'Log out'|lang }}</a></li>
	  </ul>
    <div class="navbar-default sidebar" role="navigation" id="left-navigation">
      <div class="sidebar-nav navbar-collapse collapse">
		<ul class="nav" id="side-menu">
			<li {% if controller=='index' %}class="active"{% endif %}><a href="{{ settings.base_url }}/{{ folder_admin }}" title="{{ 'Home'|lang }}"><span class="glyphicon glyphicon-home"></span> {{ 'Home'|lang }}</a></li>
			<li {% if controller=='statistics' %}class="active"{% endif %}><a href="?controller=statistics" title="{{ 'Statistics'|lang }}"><span class="glyphicon glyphicon-check"></span> {{ 'Statistics'|lang }}</a></li>
			<li {% if controller=='pictures' %}class="active"{% endif %}><a href="?controller=pictures" title="{{ 'Pictures'|lang }}"><span class="glyphicon glyphicon-list-alt"></span> {{ 'Pictures'|lang }}</a></li>
			<li {% if controller=='users' %}class="active"{% endif %}><a href="?controller=users" title="{{ 'Users'|lang }}"><span class="glyphicon glyphicon-user"></span> {{ 'Users'|lang }}</a></li>
			<li {% if controller=='mailing' %}class="active"{% endif %}><a href="?controller=mailing" title="{{ 'Mailing'|lang }}"><span class="glyphicon glyphicon-envelope"></span> {{ 'Mailing'|lang }}</a></li>
			<li {% if controller=='categories' %}class="active"{% endif %}><a href="?controller=categories" title="{{ 'Categories'|lang }}"><span class="glyphicon glyphicon-th-list"></span> {{ 'Categories'|lang }}</a></li>
			<li {% if controller=='tags' %}class="active"{% endif %}><a href="?controller=tags" title="{{ 'Tags'|lang }}"><span class="glyphicon glyphicon-th"></span> {{ 'Tags'|lang }}</a></li>
			<li {% if controller=='mem_pattern' %}class="active"{% endif %}><a href="?controller=mem_pattern" title="{{ 'Memes patterns'|lang }}"><span class="glyphicon glyphicon-picture"></span> {{ 'Memes patterns'|lang }}</a></li>
			<li>
				<a href="#" data-toggle="collapse" data-target="#submenu_contents" data-parent="#menu" class="collapsed">
					<span class="glyphicon glyphicon-edit"></span> {{ 'Contents'|lang }} <span class="caret"></span>
				</a>
				<div class="collapse" id="submenu_contents" style="height: 0px;">
					<ul class="nav nav-list">
						<li {% if controller=='mails' %}class="active"{% endif %}><a href="?controller=mails" title="{{ 'Mails'|lang }}">{{ 'Mails'|lang }}</a></li>
						<li {% if controller=='info' %}class="active"{% endif %}><a href="?controller=info" title="{{ 'Info'|lang }}">{{ 'Info'|lang }}</a></li>
					</ul>
				</div>
			</li>
			<li>
				<a href="#" data-toggle="collapse" data-target="#submenu_logs" data-parent="#menu" class="collapsed">
					<span class="glyphicon glyphicon-hdd"></span> {{ 'Logs'|lang }} <span class="caret"></span>
				</a>
				<div class="collapse" id="submenu_logs" style="height: 0px;">
					<ul class="nav nav-list">
						<li {% if controller=='logs_pictures' %}class="active"{% endif %}><a href="?controller=logs_pictures" title="{{ 'Files'|lang }}">{{ 'Pictures'|lang }}</a></li>
						<li {% if controller=='logs_users' %}class="active"{% endif %}><a href="?controller=logs_users" title="{{ 'Users'|lang }}">{{ 'Users'|lang }}</a></li>
						<li {% if controller=='logs_mails' %}class="active"{% endif %}><a href="?controller=logs_mails" title="{{ 'Mails'|lang }}">{{ 'Mails'|lang }}</a></li>
						<li {% if controller=='reset_password' %}class="active"{% endif %}><a href="?controller=reset_password" title="{{ 'Reset password'|lang }}">{{ 'Reset password'|lang }}</a></li>
					</ul>
				</div>
			</li>
			<li>
				<a href="#" data-toggle="collapse" data-target="#submenu_settings" data-parent="#menu" class="collapsed">
					<span class="glyphicon glyphicon-asterisk"></span> {{ 'Settings'|lang }} <span class="caret"></span>
				</a>
				<div class="collapse" id="submenu_settings" style="height: 0px;">
					<ul class="nav nav-list">
						<li {% if controller=='settings_automation' %}class="active"{% endif %}><a href="?controller=settings_automation" title="{{ 'Automation'|lang }}">{{ 'Automation'|lang }}</a></li>
						<li {% if controller=='settings_black_list' %}class="active"{% endif %}><a href="?controller=settings_black_list" title="{{ 'Black list'|lang }}">{{ 'Black list'|lang }}</a></li>
						<li {% if controller=='settings_appearance' %}class="active"{% endif %}><a href="?controller=settings_appearance" title="{{ 'Appearance'|lang }}">{{ 'Appearance'|lang }}</a></li>
						<li {% if controller=='settings_social_media' %}class="active"{% endif %}><a href="?controller=settings_social_media" title="{{ 'Social Media'|lang }}">{{ 'Social Media'|lang }}</a></li>
						<li {% if controller=='settings_ads' %}class="active"{% endif %}><a href="?controller=settings_ads" title="{{ 'Ads'|lang }}">{{ 'Ads'|lang }}</a></li>
						<li {% if controller=='settings' %}class="active"{% endif %}><a href="?controller=settings" title="{{ 'General settings'|lang }}">{{ 'General settings'|lang }}</a></li>
					</ul>
				</div>
			</li>
			<li class="visible-xs-block"><a href="?controller=admin" title="{{ 'Admin Panel Settings'|lang }}"><span class="glyphicon glyphicon-user"></span> {{ 'Admin Panel Settings'|lang }}</a></li>
			<li class="visible-xs-block"><a href="?logOut" title="{{ 'Log out'|lang }}"><span class="glyphicon glyphicon-log-out"></span> {{ 'Log out'|lang }}</a></li>
		</ul>
      </div>
    </div>
  </nav>
  <div id="page-wrapper">

		{% if _ADMIN_TEST_MODE_ %}<p class="text-danger"><br><br><b>{{ 'Demo version of the Admin Panel. Editing functions are disabled'|lang }}</b></p>{% endif %}

		{% block content %}

		{% endblock %}

  </div>
</div>

{% endblock %}

<div id="cookies-message-container"><div id="cookies-message">{{ 'This site uses cookies, so that our service may work better.'|lang }}<a href="javascript:WHCloseCookiesWindow();" id="accept-cookies-checkbox">{{ 'I accept'|lang }}</a></div></div>

<div class="modal fade" id="roxySelectFile" tabindex="-1" role="dialog" aria-labelledby="Select file">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			 <div class="modal-body">
				<iframe frameborder="0" allowtransparency="true"></iframe>
			</div>
		</div>
	</div>
</div>

</body>
</html>
