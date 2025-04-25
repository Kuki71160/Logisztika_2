<template>
  <div class="container py-5">
    <h1 class="text-center text-primary mb-4">🎯 Dashboard</h1><br>
    <div class="row g-4">
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100 text-center">
          <div class="card-body">
            <h5 class="card-title mb-3">👥 Felhasználók</h5>
            <router-link to="/users" class="btn btn-outline-primary w-75">Kezelés</router-link>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100 text-center">
          <div class="card-body">
            <h5 class="card-title mb-3">📦 Termékek</h5>
            <router-link to="/products" class="btn btn-outline-success w-75">Kezelés</router-link>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100 text-center">
          <div class="card-body">
            <h5 class="card-title mb-3">🗂️ Kategóriák</h5>
            <router-link to="/categories" class="btn btn-outline-warning w-75">Kezelés</router-link>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100 text-center">
          <div class="card-body">
            <h5 class="card-title mb-3">🚚 Beszállítók</h5>
            <router-link to="/suppliers" class="btn btn-outline-danger w-75">Kezelés</router-link>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100 text-center">
          <div class="card-body">
            <h5 class="card-title mb-3">📑 Raktár</h5>
            <router-link to="/stock" class="btn btn-outline-dark w-75">Kezelés</router-link>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm border-0 h-100 text-center">
          <div class="card-body">
            <h5 class="card-title mb-3">🛒 Megrendelések</h5>
            <router-link to="/transactions" class="btn btn-outline-info w-75">Kezelés</router-link>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted } from 'vue';


const user = JSON.parse(localStorage.getItem('loggedInUser')) || { role: '' };

export default {
  name: "Dashboard",
}

//onMounted(window.location.reload(true));


</script>