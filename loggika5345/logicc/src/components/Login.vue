<template>
  <div class="min-vh-100 d-flex justify-content-center align-items-center bg-light">
    <div class="card shadow-lg p-4" style="width: 100%; max-width: 400px; border-radius: 1rem;">
      <div class="card-header bg-primary text-white text-center fs-4"
        style="border-top-left-radius: 1rem; border-top-right-radius: 1rem;">
        Bejelentkezés
      </div>
      <div class="card-body">
        <form @submit.prevent="handleLogin">
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input v-model="user.email" type="email" class="form-control form-control-lg" id="email"
              placeholder="pl: pelda@email.com" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Jelszó</label>
            <input v-model="user.password" type="password" class="form-control form-control-lg" id="password"
              placeholder="********" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Bejelentkezés</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {
        email: '',
        password: ''
      }
    };
  },
  methods: {
    handleLogin() {

      fetch('http://localhost:8000/api/login', {
        method: "POST",
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.user)
      })
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            localStorage.setItem('loggedInUser', JSON.stringify({
              id: data.id,
              role: data.role
            }));
            this.$router.push('/dashboard').then(() => {
              setTimeout(() => {
                window.location.reload();
              }, 100); // kis késleltetés, hogy a localStorage-hez legyen idő
            });

          } else {
            alert(data.message);
          }
        })
        .catch(error => {
          alert('Hiba a mentés során!')
          console.error(error)
        })
    }
  }
};
</script>
