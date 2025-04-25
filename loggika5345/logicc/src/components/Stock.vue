<template>
  <div class="container mt-5">
    <h1 class="mb-4 text-center">📑 Raktár</h1>
    <table class="table table-bordered table-striped text-center align-middle">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Név</th>
          <th>Kategória</th>
          <th>Beszállító</th>
          <th>Ár</th>
          <th>Készlet</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in stockItems" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ getCategoryName(item.category_id) }}</td>
          <td>{{ getSupplierName(item.supplier_id) }}</td>
          <td>{{ item.price }} Ft</td>
          <td>{{ item.stock || 'N/A' }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
export default {
  name: 'Stock',
  data() {
    return {
      stockItems: [],
      categories: [],
      suppliers: [],
      loading: false,
      error: null
    };
  },
  methods: {
    getStock() {
      this.loading = true;
      this.error = null;
      fetch('http://localhost:8000/api/products')
        .then(response => response.json())
        .then(data => {
          this.stockItems = data.products.map(item => ({
            id: item.id,
            name: item.name,
            category_id: item.category_id,
            supplier_id: item.supplier_id,
            price: item.price,
            stock: item.stock,
          }));
        })
        .catch(e => {
          console.error('Failed to fetch stock:', e);
          this.error = e.message;
        })
        .finally(() => {
          this.loading = false;
        });
    },
    getCategories() {
      fetch('http://localhost:8000/api/categories')
        .then(res => res.json())
        .then(data => {
          this.categories = data.categories;
        });
    },
    getSuppliers() {
      fetch('http://localhost:8000/api/suppliers')
        .then(res => res.json())
        .then(data => {
          this.suppliers = data.suppliers;
        });
    },
    getCategoryName(id) {
      const category = this.categories.find(cat => cat.id === id);
      return category ? category.name : 'Ismeretlen';
    },
    getSupplierName(id) {
      const supplier = this.suppliers.find(sup => sup.id === id);
      return supplier ? supplier.name : 'Ismeretlen';
    }
  },
  mounted() {
    this.getStock();
    this.getCategories();
    this.getSuppliers();
  },
};
</script>
