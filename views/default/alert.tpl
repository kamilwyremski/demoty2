
{% if alert_success %}
  {% for alert in alert_success %}
    <div class="notification is-success">
      <button class="delete notification_delete"></button>
      {{ alert }}
    </div>
  {% endfor %}
{% endif %}
{% if alert_danger %}
  {% for alert in alert_danger %}
	  <div class="notification is-danger">
      <button class="delete notification_delete"></button>
      {{ alert }}
    </div>
  {% endfor %}
{% endif %}
