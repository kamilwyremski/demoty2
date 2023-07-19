<!doctype html>
<html lang="{{ settings.lang }}">
<head>
  <meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta name="Keywords" content="{{ settings.keywords }}">
	<meta name="Description" content="{{ settings.description }}">
	<meta name="author" content="Kamil Wyremski - wyremski.pl">
	<title>{{ settings.title }}</title>
	<base href="{{ settings.base_url }}/">

	<!-- CSS style -->
	<link rel="stylesheet" href="views/{{ settings.template }}/css/bulma.min.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
	<link rel="stylesheet" href="views/{{ settings.template }}/css/style.css?{{ settings.assets_version }}"/>
	{% if settings.favicon %}<link rel="shortcut icon" href="{{ settings.favicon }}">{% endif %}
	{% if settings.code_style %}<style>{{ settings.code_style|raw }}</style>{% endif %}

	<!-- integration with Facebook -->
	{% if settings.logo_facebook  %}<meta property="og:image" content="{{ settings.logo_facebook }}">{% endif %}
	<meta property="og:description" content="{{ settings.description }}">
	<meta property="og:title" content="{{ settings.title }}">
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="{{ settings.title }}">
	<meta property="og:locale" content="{{ settings.facebook_lang }}">
	<meta property="og:url" content="{{ settings.this_url }}">
	{% if settings.facebook_api %}<meta property="fb:app_id" content="{{ settings.facebook_api }}">{% endif %}

	<!-- other -->
	{% if settings.rss %}<link rel="alternate" type="application/rss+xml" href="{{ path('feed') }}{% if pagination.page_url.page %}?{{ pagination.page_url.page }}{% endif %}">{% endif %}
	{{ settings.code_head|raw }}

</head>
<body class="has-background-black-ter">
<div id="fb-root"></div>
<div class="has-background-dark navbar_box">
  <nav class="navbar is-dark content" role="navigation" aria-label="Main navigation">
  	<div class="navbar-brand">
  		<a href="{{ settings.base_url }}" class="navbar-item">{% if settings.logo %}<img src="{{ settings.logo }}" alt="Logo">{% else %}{{ settings.header }}{% endif %}</a>
  		<a role="button" class="navbar-burger has-text-white" data-target="navMenu" aria-label="menu" aria-expanded="false">
  			<span aria-hidden="true"></span>
  			<span aria-hidden="true"></span>
  			<span aria-hidden="true"></span>
  		</a>
  	</div>
  	<div class="navbar-menu" id="navMenu">
  		<div class="navbar-end hide-on-med-and-down">
  			<a class="navbar-item {% if module_subpage=='main_page' %}active{% endif %}" href="{{ settings.base_url }}" title="{{ 'Main page'|lang }}">{{ 'Main'|lang }}</a>
  			<a class="navbar-item {% if module_subpage=='waiting_room' %}active{% endif %}" href="{{ path('waiting_room') }}" title="{{ 'Waiting Room'|lang }}">{{ 'Waiting Room'|lang }}</a>
  			<a class="navbar-item {% if module_subpage=='top' %}active{% endif %}" href="{{ path('top') }}" title="{{ 'Top'|lang }}">{{ 'Top'|lang }}</a>
  			{% if categories %}
          <div class="navbar-item has-dropdown is-hoverable">
            <span class="navbar-link">{{ 'Categories'|lang }}</span>
    				<div class="navbar-dropdown is-right">
    					{% for item in categories %}
    						<a class="navbar-item" href="{{ path('category',item.id,item.slug) }}" title="{{ item.name }}">{{ item.name }}</a>
    					{% endfor %}
    				</div>
          </div>
  			{% endif %}
  			<a class="navbar-item {% if controller=='add' %}active{% endif %}" href="{{ path('add') }}" title="{{ 'Add'|lang }}">{{ 'Add'|lang }}</a>
        <div class="navbar-item has-dropdown is-hoverable">
          <span class="navbar-link">{{ 'Search'|lang }}</span>
          <div class="navbar-dropdown is-right">
            <form action="{{ path('search') }}" method="get" class="menu_box_search">
              <div class="field has-addons">
                <div class="control">
                  <input class="input" type="text" name="q" type="search" required value="{{ search }}">
                </div>
                <div class="control">
                  <button type="submit" class="button is-danger"><i class="fa fa-search" aria-hidden="true"></i></button>
                </div>
              </div>
            </form>
          </div>
        </div>
  			{% if user.id %}
          <div class="navbar-item has-dropdown is-hoverable">
            <span class="navbar-link">{{ 'Account'|lang }}</span>
    				<div class="navbar-dropdown is-right">
    					<a class="navbar-item {% if controller=='my_pictures' %}active{% endif %}" href="{{ path('my_pictures') }}" title="{{ 'My pictures'|lang }}">{{ 'My pictures'|lang }}</a>
    					<a class="navbar-item {% if controller=='settings' %}active{% endif %}" href="{{ path('settings') }}" title="{{ 'Settings'|lang }}">{{ 'Settings'|lang }}</a>
    					<a class="navbar-item" href="?log_out&token={{ generateToken('logout') }}" title="{{ 'Log out'|lang }}">{{ 'Log out'|lang }}</a>
    				</div>
          </div>
  			{% else %}
  				<a class="navbar-item {% if controller=='login' %}active{% endif %}" href="{{ path('login') }}" title="{{ 'Login'|lang }}">{{ 'Login'|lang }}</a>
  			{% endif %}
  		</div>
  	</div>
  </nav>
</div>

<main class="has-text-grey-lighter">
	{% if settings.ads_top %}
	  <div class="ads">
		{{ settings.ads_top|raw }}
	  </div>
	{% endif %}
	{% block content %}{% endblock %}
	{% if settings.ads_bottom %}
	  <div class="ads">
		{{ settings.ads_bottom|raw }}
	  </div>
	{% endif %}
</main>

<footer class="footer has-background-black-bis has-text-grey">
	<div class="content">
    <div class="columns">
      <div class="column is-two-thirds">
  		  {{ settings.footer_top|raw }}
      </div>
  		<div class="column is-one-third">
        <div class="columns">
    			<ul class="column is-half">
    				<li><a href="{{ settings.base_url }}" title="{{ 'Home'|lang }}">{{ 'Home'|lang }}</a></li>
    				<li><a href="{{ path('waiting_room') }}" title="{{ 'Waiting Room'|lang }}">{{ 'Waiting Room'|lang }}</a></li>
    				<li><a href="{{ path('top') }}" title="{{ 'Top'|lang }}">{{ 'Top'|lang }}</a></li>
    				<li><a href="{{ path('random') }}" title="{{ 'Random'|lang }}">{{ 'Random'|lang }}</a></li>
    				<li><a href="{{ path('add') }}" title="{{ 'Add'|lang }}">{{ 'Add'|lang }}</a></li>
          </ul>
          <ul class="column is-half">
    				<li><a href="{{ path('rules') }}" title="{{ 'Terms of service'|lang }}">{{ 'Terms of service'|lang }}</a></li>
    				<li><a href="{{ path('privacy_policy') }}" title="{{ 'Privacy policy'|lang }}">{{ 'Privacy policy'|lang }}</a></li>
    				<li><a href="{{ path('contact') }}" title="{{ 'Contact us'|lang }}">{{ 'Contact'|lang }}</a></li>
    				<li><a href="{{ path('info') }}" title="{{ 'Info about us'|lang }}">{{ 'Info'|lang }}</a></li>
    				{% if settings.rss %}<li><a href="{{ path('feed') }}{% if pagination.page_url.page %}?{{ pagination.page_url.page }}{% endif %}" title="{{ 'RSS feed'|lang }}" target="_blank">{{ 'RSS feed'|lang }}</a></li>{% endif %}
    			</ul>
        </div>
  		</div>
	  </div>
	</div>
</footer>
<footer class="footer has-background-black has-text-grey-light">
	<div class="content">
		{{ settings.footer_bottom|raw}}
	</div>
</footer>

<div id="cookies-message">{{ 'This site uses cookies, so that our service may work better.'|lang }}<a href="javascript:closeCookiesWindow();" id="accept-cookies-checkbox">{{ 'I accept'|lang }}</a></div>

{% if settings.rodo_alert %}
	<div id="rodo-message" class="modal">
		<div class="modal-background"></div>
		<div class="modal-card">
      <section class="modal-card-body">
			  {{ settings.rodo_alert_text|raw }}<br>
      </section>
      <footer class="modal-card-foot">
        <a href="javascript:closeRodoWindow();" class="button is-success">{{ 'I agree to the processing my personal data'|lang }}</a>
      </footer>
    </div>
	</div>
  <a href="#rodo-message" class="is-hidden modal_trigger" id="rodo-message-trigger"></a>
{% endif %}

{% if settings.voice_only_logged and not user.id %}
  <div class="modal" id="modal_voice_only_logged">
    <div class="modal-background"></div>
    <div class="modal-content box">
      	<p>{{ 'Only logged users can vote on posted materials'|lang }}</p>
    </div>
    <button class="modal-close is-large" aria-label="close"></button>
  </div>
{% endif %}

{% if settings.facebook_side_panel %}
	<div id="facebook_panel" class="is-hidden-mobile">
		<div id="facebook_panel_image"><img src="{{ settings.base_url }}/views/{{ settings.template }}/images/facebook-side.png" alt="Facebook" width="10" height="21"></div>
		<div class="fb-page" data-href="{{ settings.url_facebook }}" data-tabs="timeline" data-width="300" data-height="350" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="{{ settings.url_facebook }}" class="fb-xfbml-parse-ignore"><a href="{{ settings.url_facebook }}">Facebook</a></blockquote></div>
	</div>
{% endif %}

{% block javascript %}
	<script src="views/{{ settings.template }}/js/engine.js?{{ settings.assets_version }}"></script>

	{% if settings.facebook_side_panel or settings.social_facebook or allow_comments_fb_picture or allow_comments_fb_profile %}
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/{{ settings.facebook_lang|default(en_US) }}/all.js#xfbml=1";
			fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
	{% endif %}

	{{ settings.analytics|raw }}
{% endblock %}

{{ settings.code_body|raw }}

</body>
</html>
