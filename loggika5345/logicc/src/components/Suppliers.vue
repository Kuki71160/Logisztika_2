<template>
  <div class="container mt-5">
    <h1 class="text-center text-danger">🚚 Beszállítók</h1>

    <div v-if="user.role === 'admin' || user.role === 'manager'" class="card shadow-sm mb-5 border-0 rounded-4">
      <div class="card-header bg-danger text-white rounded-top-4 fs-5">{{ isEditing ? 'Beszállító szerkesztése' : 'Új beszállító hozzáadása' }}</div>
      <div class="card-body">
        <form @submit.prevent="isEditing ? updateSupplier() : createSupplier()">
          <div class="mb-3">
            <label class="form-label">Név</label>
            <input v-model="newSupplier.name" type="text" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Email</label>
            <input v-model="newSupplier.contact_email" type="email" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Telefonszám</label>
            <input v-model="newSupplier.contact_phone" type="text" class="form-control" required />
          </div>

          <button type="submit" class="btn btn-danger">{{ isEditing ? 'Mentés' : 'Hozzáadás' }}</button>
          <button v-if="isEditing" type="button" class="btn btn-secondary ms-2" @click="cancelEdit">Mégse</button>
        </form>
      </div>
    </div>

    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-header bg-secondary text-white rounded-top-4 fs-5">Beszállítók listája</div>
      <div class="card-body p-0">
        <table class="table table-bordered table-striped text-center align-middle">
          <thead>
            <tr>
              <th>Név</th>
              <th>Email</th>
              <th>Telefonszám</th>
              <th v-if="user.role === 'admin' || user.role === 'manager'">Műveletek</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(supplier, index) in suppliers" :key="index">
              <td>{{ supplier.name }}</td>
              <td>{{ supplier.contact_email }}</td>
              <td>{{ supplier.contact_phone }}</td>
              <td v-if="user.role === 'admin' || user.role === 'manager'">
                <button class="btn btn-sm btn-warning me-2" @click="editSupplier(index)">Szerkeszt</button>
                <button class="btn btn-sm btn-danger" @click="deleteSupplier(index)">Törlés</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
const user = JSON.parse(localStorage.getItem('loggedInUser')) || { role: '' };


export default {
  data() {
    return {
      suppliers: [],
      newSupplier: {
        name: '',
        contact_email: '',
        contact_phone: ''
      },
      user,
      isEditing: false,
      editIndex: null
    };
  },
  methods: {
    createSupplier() {
      fetch('http://localhost:8000/api/suppliers', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.newSupplier)
      })
      .then(res => res.json())
      .then(data => {
        this.getSupplier()
      })
      .catch(error => {
        alert('Hiba a mentés során!')
        console.error(error)
      })

      this.newSupplier = { name: '', contact_email: '', contact_phone: ''};
    },
    editSupplier(index) {
      this.newSupplier = { ...this.suppliers[index] };
      this.isEditing = true;
      this.editIndex = index;
    },
    updateSupplier() {
      const id = this.suppliers[this.editIndex].id;
  
  fetch('http://localhost:8000/api/suppliers/' + id, {
    method: 'PUT',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(this.newSupplier)
  })
  .then(res => res.json())
  .then(data => {
    this.getSupplier();
    this.isEditing = false;
    this.editIndex = null;
    this.newSupplier = { name: '', contact_email: '', contact_phone: ''};
  })
  .catch(error => {
    alert('Hiba a mentés során!');
    console.error(error);
  });
    },
    deleteSupplier(index) {
    const id = this.suppliers[index].id;

    fetch(`http://localhost:8000/api/suppliers/${id}`, {
      method: 'DELETE',
      headers: {
        'Content-Type': 'application/json'
      }
    })
    .then(() => {
      this.getSupplier();
    })
    .catch(error => {
      alert('Hiba a törlés során!');
      console.error(error);
    });
  },
    getSupplier(){
      fetch('http://localhost:8000/api/suppliers')
      .then(response => response.json())
      .then(data => this.suppliers = data.suppliers)
      .then(console.log(this.data))
    },
    cancelEdit() {
    this.newSupplier = { name: '', contact_email: '', contact_phone: '' };
    this.isEditing = false;
    this.editIndex = null;
  },
  },
  mounted(){
    this.getSupplier()
  }
};
</script>
