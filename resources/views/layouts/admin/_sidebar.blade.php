 <div id="headerMenuCollapse" class="col-sm-12 col-md-3 col-lg-2 collapse d-md-flex align-items-start" >
  <div class="list-group list-group-transparent mb-2 sidebar">
    <span class="sidebar-heading pl-0 pt-2 pb-2">
      <i class="fas fa-compass mr-2"></i>
      Administrativo
    </span>

    <a class="list-group-item list-group-item-action {{ setActive(['admin']) }}" aria-current="page" href="/admin">
      <span class="icon mr-2">
        <i class="fas fa-home"></i>
      </span>
      Página inicial
    </a>

    <a class="list-group-item list-group-item-action {{ setActive(['admin/servants*']) }}" href="{{ route('admin.servants') }}">
      <span class="icon mr-2">
        <i class="fas fa-users"></i>
      </span>
      Servidores
    </a>
    <a class="list-group-item list-group-item-action {{ setActive(['admin/users*']) }}" href="{{ route('admin.users') }}">
      <span class="icon mr-2">
        <i class="fas fa-users-cog"></i>
      </span>
      Administradores
    </a>
  </div>
</div>
