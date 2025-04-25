<template>
  <div class="container py-5">
    <h1 class="text-center text-warning mb-4">🗂️ Kategóriák</h1>

    <!-- Add Category Form -->
    <div v-if="user.role === 'admin' || user.role === 'manager'" class="card shadow-sm border-0 rounded-4 mb-5">
      <div class="card-header bg-warning text-dark rounded-top-4 fs-5">Új kategória hozzáadása</div>
      <div class="card-body">
        <form @submit.prevent="isEditing ? updateCategory() : createCategory()">
          <div class="mb-3">
            <label class="form-label">Kategória neve</label>
            <input v-model="newCategory.name" type="text" class="form-control" required />
          </div>
          <button type="submit" class="btn btn-warning">{{ isEditing ? 'Mentés' : 'Hozzáadás' }}</button>
          <button v-if="isEditing" type="button" class="btn btn-secondary ms-2" @click="cancelEdit">Mégse</button>

        </form>
      </div>
    </div>

    <!-- Category List -->
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-header bg-secondary text-white rounded-top-4 fs-5">Kategóriák listája</div>
      <div class="card-body p-0">
        <table class="table table-bordered table-striped text-center align-middle">
          <thead class="table-light">
            <tr>
              <th>Kategória</th>
              <th v-if="user.role === 'admin' || user.role === 'manager'">Műveletek</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(cat, index) in categories" :key="index">
              <td>{{ cat.name }}</td>
              <td v-if="user.role === 'admin' || user.role === 'manager'">
                <button class="btn btn-sm btn-warning me-2" @click="editCategory(index)">Szerkeszt</button>
                <button class="btn btn-sm btn-danger" @click="deleteCategory(index)">Törlés</button>
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
      user,
      newCategory: { name: '' },
      categories: [],
      isEditing: false,
      editIndex: null
    };
  },

  methods: {
    createCategory() {
      fetch('http://localhost:8000/api/categories', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.newCategory)
      })
        .then(res => res.json())
        .then(data => {
          this.getCategory()
        })
        .catch(error => {
          alert('Hiba a mentés során!')
          console.error(error)
        })

      this.newCategory = { name: '' };
    },
    deleteCategory(index) {
      const id = this.categories[index].id;

      fetch('http://localhost:8000/api/categories/' + id, {
        method: 'DELETE'
      })
        .then(() => this.getCategory())
        .catch(error => {
          alert('Hiba a törlés során!');
          console.error(error);
        });
    },

    editCategory(index) {
      this.newCategory = { ...this.categories[index] };
      this.isEditing = true;
      this.editIndex = index;
    },
    updateCategory() {
      const id = this.categories[this.editIndex].id;

      fetch('http://localhost:8000/api/categories/' + id, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.newCategory)
      })
        .then(res => res.json())
        .then(data => {
          this.getCategory();
          this.isEditing = false;
          this.editIndex = null;
          this.newCategory = { name: '' };
        })
        .catch(error => {
          alert('Hiba a mentés során!');
          console.error(error);
        });
    },
    getCategory() {
      fetch('http://localhost:8000/api/categories')
        .then(response => response.json())
        .then(data => this.categories = data.categories)
        .then(console.log(this.data))
    },
    cancelEdit() {
    this.newCategory = { name: '', contact_email: '', contact_phone: '' };
    this.isEditing = false;
    this.editIndex = null;
  },
  },
  mounted() {
    this.getCategory()
  }
};
</script>
