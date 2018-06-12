<div class="profile-menu">
    <div class="profile-menu__container">
        @foreach($_profilemenu as $_pm)
          <a href="{{ url($_pm->alias) }}" class="{{ strpos($_pm->alias, $_la) !== false ? 'active' : '' }}">
          	{{ $_pm->name }}{!! $_pm->icon && strlen(trim($_pm->icon)) ? '<span class="icon '.$_pm->icon.'"></span>' : '' !!}
          </a>
        @endforeach
    </div>
</div>
