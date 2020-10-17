
{% if pagination.page_count %}
	<nav class="pagination is-centered" role="navigation" aria-label="pagination">
	  <a href="{% if module_subpage %}{{ path(module_subpage) }}{% else %}{{ path(controller) }}{% endif %}{% if pagination.page_url.page %}?{% endif %}{{ pagination.page_url.page }}" class="pagination-previous {% if pagination.page_number==1 %}return_false{% endif %}" {% if pagination.page_number==1 %}disabled{% endif %} title="{{ 'First page'|lang }}">{{ 'First page'|lang }}</a>
	  <a href="{% if module_subpage %}{{ path(module_subpage) }}{% else %}{{ path(controller) }}{% endif %}?{{ pagination.page_url.page }}{% if pagination.page_url.page %}&{% endif %}page={{ pagination.page_count }}" class="pagination-next {% if pagination.page_number==pagination.page_count %}return_false{% endif %}" {% if pagination.page_number==pagination.page_count %}disabled{% endif %} title="{{ 'Last page'|lang }}">{{ 'Last page'|lang }}</a>
	  <ul class="pagination-list">
		{% for this_page in pagination.page_start..pagination.page_count %}
			{% if loop.index<6 %}
				<li><a href="{% if module_subpage %}{{ path(module_subpage) }}{% else %}{{ path(controller) }}{% endif %}?{{ pagination.page_url.page }}{% if pagination.page_url.page %}&{% endif %}page={{ this_page }}" class="pagination-link {% if pagination.page_number==this_page %}is-current return_false{% endif %}" title="{{ 'Page'|lang }}: {{ this_page }}">{{ this_page }}</a></li>
			{% endif %}
		{% endfor %}
	  </ul>
	</nav>
{% endif %}
