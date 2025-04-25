<template>
  <div class="container py-5">
    <h1 class="text-center text-primary mb-4">👥 Felhasználók</h1>

    <!-- Add User Form -->
    <div v-if="user.role ==='admin'" class="card shadow-sm mb-5 border-0 rounded-4">
      <div class="card-header bg-primary text-white rounded-top-4 fs-5">Új felhasználó hozzáadása</div>
      <div class="card-body">
        <form @submit.prevent="isEditing ? updateUser() : createUser()">
          <div class="mb-3">
            <label class="form-label">Név</label>
            <input v-model="newUser.name" type="text" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input v-model="newUser.email" type="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Jelszó</label>
            <input v-model="newUser.password" type="password" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Szerepkör</label>
            <select v-model="newUser.role" class="form-select" required>
              <option disabled value="">Válassz szerepkört</option>
              <option value="staff">Staff</option>
              <option value="manager">Manager</option>
              <option value="admin">Admin</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Hozzáadás</button>
          <button v-if="isEditing" type="button" class="btn btn-secondary ms-2" @click="cancelEdit">Mégse</button>
        </form>
      </div>
    </div>

    <!-- User List -->
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-header bg-secondary text-white rounded-top-4 fs-5">Felhasználók listája</div>
      <div class="card-body p-0">
        <table class="table table-bordered table-striped text-center align-middle">
          <thead class="table-light">
            <tr>
              <th>Név</th>
              <th>Email</th>
              <th>Szerepkör</th>
              <th v-if="user.role ==='admin'">Műveletek</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(userItem, index) in users" :key="index">
              <td>{{ userItem.name }}</td>
              <td>{{ userItem.email }}</td>
              <td>{{ userItem.role }}</td>
              <td v-if="user.role ==='admin'">
                <button class="btn btn-sm btn-warning me-2" @click="editUser(index)">Szerkeszt</button>
                <button class="btn btn-sm btn-danger me-2" @click="deleteUser(index)">Törlés</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted } from 'vue';

const user = JSON.parse(localStorage.getItem('loggedInUser')) || { role: '' };

export default {
  data() {
    return {
      user,
      isEditing: false,
      editIndex: null,
      newUser: {
        name: '',
        email: '',
        password: '',
        role: ''
      },
      users: []
    };
  },
  methods: {
    createUser() {
      
      fetch('http://localhost:8000/api/users', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.newUser)
      })
      .then(res => res.json())
      .then(data => {
        this.getUsers()
      })
      .catch(error => {
        alert('Hiba a mentés során!')
        console.error(error)
      })

      this.newUser = { name: '', email: '', password: '', role: '' };
    },
    
    deleteUser(id) {
      fetch('http://localhost:8000/api/users/'+id,{
        method: 'DELETE'
      })
      .then(res => res.json())
      .then(data => {
        this.getUsers()
      })
      .catch(error => {
        alert('Hiba a tölés során!')
        console.error(error)
      })
    },
    editUser(index) {
      this.newUser = { ...this.users[index] };
      this.isEditing = true;
      this.editIndex = index;
    },
    updateUser() {
  const id = this.users[this.editIndex].id;
  
  fetch('http://localhost:8000/api/users/' + id, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(this.newUser)
  })
  .then(res => res.json())
  .then(data => {
    this.getUsers();
    this.isEditing = false;
    this.editIndex = null;
    this.newUser = { name: '', email: '', password: '', role: '' };
  })
  .catch(error => {
    alert('Hiba a mentés során!');
    console.error(error);
  });
},

    getUsers(){
      fetch('http://localhost:8000/api/users')
      .then(response => response.json())
      .then(data => this.users = data.users)
      .then(console.log(this.data))
    },
    cancelEdit() {
    this.newUser = { name: '', contact_email: '', contact_phone: '' };
    this.isEditing = false;
    this.editIndex = null;
  },
    

  },
  mounted(){
    this.getUsers()
  },
};
</script>
