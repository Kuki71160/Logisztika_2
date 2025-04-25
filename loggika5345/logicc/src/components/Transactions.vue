<template>
  <div class="container mt-5">
    <h2 class="text-center mb-4 text-info">🛒 Megrendelések</h2>

    <div class="card shadow-sm mb-5 border-0 rounded-4">
      <div class="card-header bg-info text-white rounded-top-4 fs-5">Megrendelések kezelése</div>
      <div class="card-body">
        <form @submit.prevent="handleTransaction">
          <div class="mb-3">
            <label for="product" class="form-label">Termék kiválasztása</label>
            <select v-model="selectedProductId" class="form-select" required>
              <option disabled value="">-- Válassz terméket --</option>
              <option v-for="product in products" :key="product.id" :value="product.id">
                {{ product.name }}
              </option>
            </select>
          </div>

          <div class="mb-3">
            <label for="units" class="form-label">Egységek száma</label>
            <input v-model.number="units" type="number" min="1" class="form-control" required />
          </div>

          <div class="mb-3">
            <label class="form-label">Típus</label><br />
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="import" v-model="transactionType" required />
              <label class="form-check-label">Import</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" value="export" v-model="transactionType" required />
              <label class="form-check-label">Export</label>
            </div>
          </div>

          <button type="submit" class="btn btn-info text-white">Tranzakció végrehajtása</button>
        </form>
      </div>
    </div>

    <div v-if="message" class="alert mt-4" :class="messageType">{{ message }}</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedProductId: '',
      units: 1,
      transactionType: '',
      message: '',
      messageType: '',
      products: []
    };
  },
  methods: {
    handleTransaction() {
      const product = this.products.find(p => p.id === this.selectedProductId);
      if (!product) return;

      let futureStock = this.transactionType === 'import'
        ? product.stock + this.units
        : product.stock - this.units;

      if (futureStock < 0) {
        this.message = 'HIBA: A készlet nem lehet negatív!';
        this.messageType = 'alert-danger';
        return;
      }

      fetch(`http://localhost:8000/api/products/${product.id}`, {
        method: 'PUT',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({ stock: futureStock })
      })
      .then(response => {
        if (!response.ok) throw new Error('Nem sikerült frissíteni a készletet');
        return response.json();
      })
      .then(() => {
        product.stock = futureStock;
        this.message = `Sikeres tranzakció. Új készlet: ${product.stock}`;
        this.messageType = 'alert-success';
      })
      .catch(err => {
        this.message = 'Hiba történt a mentés során!';
        this.messageType = 'alert-danger';
        console.error(err);
      });
    },
    getProducts() {
      fetch('http://localhost:8000/api/products')
        .then(response => response.json())
        .then(data => this.products = data.products);
    },
  },
  mounted(){
    this.getProducts()
  }
};
</script>
