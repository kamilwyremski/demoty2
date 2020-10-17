
{% if pictures %}
  {% for picture in pictures %}
    <div class="card picture_list">
      <div class="card-content">
        <div class="media">
          <div class="media-left">
            <a href="{{ path('picture',picture.id,picture.slug) }}" title="{{ picture.title }}"><img data-src="upload/pictures/{{ picture.filename }}{% if picture.version %}?v={{ picture.version }}{% endif %}" alt="{{ picture.title }}" class="lazy" src="views/{{ settings.template }}/images/loading.gif"></a>
          </div>
          <div class="media-content">
            <h2 class="title is-size-4"><a href="{{ path('picture',picture.id,picture.slug) }}" title="{{ picture.title }}" class="has-text-dark">{{ picture.title }}</a></h2>
            <p>{{ 'Added'|lang }}: {{ picture.date|date('Y-m-d') }}</p>
            {% if controller=='my_pictures' %}
              <br>
              <a class="button is-small" href="{{ path('edit',picture.id,picture.slug) }}">{{ 'Edit'|lang }}</a>
              <a href="#modal_remove_{{ picture.id }}" class="button is-small modal_trigger is-danger">{{ 'Remove'|lang }}</a>
              <div class="modal" id="modal_remove_{{ picture.id }}">
                <div class="modal-background"></div>
                <form method="post">
                  <input type="hidden" name="action" value="remove_picture">
                  <input type="hidden" name="id" value="{{ picture.id }}">
                  <input type="hidden" name="token" value="{{ generateToken('remove_picture') }}">
                  <div class="modal-content box">
                    <h4 class="is-size-4">{{ 'Delete picture'|lang }}: {{ picture.title }}</h4>
                    <p>{{ 'Are you sure you want to delete picture'|lang }}: "{{ picture.title }}"?</p>
                    <div class="has-text-right">
                      <input type="submit" class="button is-danger" value="{{ 'Execute'|lang }}">
                    </div>
                  </div>
                  <button class="modal-close is-large" aria-label="close"></button>
                </form>
              </div>
            {% endif %}
          </div>
        </div>
      </div>
    </div>
  {% endfor %}
{% endif %}
