<template>
  <div class="container py-5">
    <h1 class="text-center text-success mb-4">📦 Termékek</h1>

    <div v-if="user.role === 'admin' || user.role === 'manager'" class="card shadow-sm border-0 rounded-4 mb-5">
      <div class="card-header bg-success text-white rounded-top-4 fs-5">
        {{ isEditing ? 'Termék szerkesztése' : 'Új termék hozzáadása' }}
      </div>
      <div class="card-body">
        <form @submit.prevent="isEditing ? updateProduct() : createProduct()" enctype="multipart/form-data">
          <div class="mb-3">
            <label class="form-label">Név</label>
            <input v-model="newProduct.name" type="text" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Kategória</label>
            <select v-model="newProduct.category_id" class="form-select" required>
              <option disabled value="">Válassz kategóriát</option>
              <option v-for="cat in categories" :value="cat.id" :key="cat.id">{{ cat.name }}</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Beszállító</label>
            <select v-model="newProduct.supplier_id" class="form-select" required>
              <option disabled value="">Válassz beszállítót</option>
              <option v-for="sup in suppliers" :value="sup.id" :key="sup.id">{{ sup.name }}</option>
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label">Ár (Ft)</label>
            <input v-model="newProduct.price" type="number" class="form-control" required />
          </div>

          <button type="submit" class="btn btn-success">{{ isEditing ? 'Mentés' : 'Hozzáadás' }}</button>
          <button v-if="isEditing" type="button" class="btn btn-secondary ms-2" @click="cancelEdit">Mégse</button>
        </form>
      </div>
    </div>

    <!-- Termék lista -->
    <div class="card shadow-sm border-0 rounded-4">
      <div class="card-header bg-secondary text-white rounded-top-4 fs-5">Termékek listája</div>
      <div class="card-body p-0">
        <table class="table table-bordered table-striped text-center align-middle">
          <thead class="table-light">
            <tr>
              <th>Név</th>
              <th>Kategória</th>
              <th>Beszállító</th>
              <th>Ár (Ft)</th>
              <th v-if="user.role === 'admin' || user.role === 'manager'">Műveletek</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(product, index) in products" :key="index">
              <td>{{ product.name }}</td>
              <td>{{ getCategoryName(product.category_id) }}</td>
              <td>{{ getSupplierName(product.supplier_id) }}</td>
              <td>{{ product.price }}</td>
              <td v-if="user.role === 'admin' || user.role === 'manager'">
                <button class="btn btn-sm btn-warning me-2" @click="editProduct(index)">Szerkeszt</button>
                <button class="btn btn-sm btn-danger" @click="deleteProduct(index)">Törlés</button>
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
      isEditing: false,
      editIndex: null,
      newProduct: {
        name: '',
        category_id: '',
        supplier_id: '',
        price: ''
      },
      products: [],
      categories: [],
      suppliers: []
    };
  },
  methods: {
    getCategories() {
      fetch('http://localhost:8000/api/categories')
        .then(response => response.json())
        .then(data => this.categories = data.categories);
    },
    getSuppliers() {
      fetch('http://localhost:8000/api/suppliers')
        .then(response => response.json())
        .then(data => this.suppliers = data.suppliers);
    },
    getProducts() {
      fetch('http://localhost:8000/api/products')
        .then(response => response.json())
        .then(data => this.products = data.products);
    },
    createProduct() {
      fetch('http://localhost:8000/api/products', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json'
        },
        body: JSON.stringify(this.newProduct)
      })
      .then(res => res.json())
      .then(() => this.getProducts())
      .catch(error => {
        alert('Hiba a mentés során!');
        console.error(error);
      });

      this.newProduct = { name: '', category_id: '', supplier_id: '', price: '' };
    },
    editProduct(index) {
      this.newProduct = { ...this.products[index] };
      this.isEditing = true;
      this.editIndex = index;
    },
    updateProduct() {
      this.products[this.editIndex] = { ...this.newProduct };
      this.newProduct = { name: '', category_id: '', supplier_id: '', price: '' };
      this.isEditing = false;
      this.editIndex = null;
    },
    deleteProduct(index) {
      this.products.splice(index, 1);
    },
    getCategoryName(category_id) {
      const cat = this.categories.find(c => c.id === category_id);
      return cat ? cat.name : 'Ismeretlen';
    },
    getSupplierName(supplier_id) {
      const sup = this.suppliers.find(s => s.id === supplier_id);
      return sup ? sup.name : 'Ismeretlen';
    },
    cancelEdit() {
      this.newProduct = { name: '', category_id: '', supplier_id: '', price: '' };
      this.isEditing = false;
      this.editIndex = null;
    }
  },
  mounted() {
    this.getCategories();
    this.getSuppliers();
    this.getProducts();
  }
};
</script>
