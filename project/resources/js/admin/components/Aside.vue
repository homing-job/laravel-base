<template>
    <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/admin" class="brand-link">
      <span class="brand-text font-weight-light">
        <slot name="header_title">未設定</slot>
      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
          <!-- 申込状況 -->
          <li class="nav-item">
            <router-link :to="{ name: 'reception_status_index', params: { isInit: true }}" class="nav-link">
              <i class="nav-icon fas fa-chart-bar"></i>
              <p>申込状況</p>
            </router-link>
          </li>

          <!-- 競技日管理 -->
          <li class="nav-item">
            <router-link :to="{ name: 'kyogi_plan_index', params: { isInit: true }}" class="nav-link">
              <i class="nav-icon fas fa-running"></i>
              <p>競技日管理</p>
            </router-link>
          </li>

          <!-- マスタ -->
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-adjust"></i>
              <i class="right fas fa-angle-left"></i>
              <p>マスタ</p>
            </a>
            <ul class="nav nav-treeview">
              <!-- 競技マスタ -->
              <li class="nav-item">
                <router-link :to="{ name: 'kyogi_index', params: { isInit: true }}" class="nav-link">
                  <i class="nav-icon fas fa-running"></i>
                  <p>競技マスタ</p>
                </router-link>
              </li>
              <!-- 汎用マスタ -->
              <li class="nav-item">
                <router-link :to="{ name: 'general_index', params: { isInit: true }}" class="nav-link">
                  <i class="nav-icon fas fa-th"></i>
                  <p>汎用マスタ</p>
                </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
</template>

<script>
    export default {
    }
</script>