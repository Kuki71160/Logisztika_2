<template>
  <div id="app" class="container">
    <nav
      class="navbar navbar-expand-lg navbar-light bg-light mb-4"
      v-if="$route.path !== '/'"
    >
      <div class="container-fluid">
        <a class="navbar-brand" href="#">Logisztika</a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
        >
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <router-link to="/dashboard" class="nav-link">Dashboard</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/users" class="nav-link">Felhasználók</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/products" class="nav-link">Termékek</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/categories" class="nav-link">Kategóriák</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/suppliers" class="nav-link">Beszállítók</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/stock" class="nav-link">Raktár</router-link>
            </li>
            <li class="nav-item">
              <router-link to="/transactions" class="nav-link">Megrendelések</router-link>
            </li>
          </ul>
            <button @click="logout" class="btn btn-outline-danger btn-sm ms-3">Kijelentkezés</button>
        </div>
      </div>
    </nav>

    <router-view />
  </div>
</template>

<script>
export default {
  methods: {
    logout() {
      localStorage.removeItem('loggedInUser');
      this.$router.push('/');
    }
  },
  name: "App",
};
</script>

<style>
body{
  background-color: ghostwhite;
}
nav{
  background-color: ghostwhite;
  margin-left: 190px;
}
</style>