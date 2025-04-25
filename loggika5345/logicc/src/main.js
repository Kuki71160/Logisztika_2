import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';
import App from './App.vue';

import Login from './components/Login.vue';
import Logout from './components/Logout.vue';
import Dashboard from './components/Dashboard.vue';
import Users from './components/Users.vue';
import Products from './components/Products.vue';
import Categories from './components/Categories.vue';
import Suppliers from './components/Suppliers.vue';
import Stock from './components/Stock.vue';
import Transactions from './components/Transactions.vue';

const routes = [
    { path: '/logout', component: Logout },
    { path: '/', component: Login },
    { path: '/dashboard', component: Dashboard },
    { path: '/users', component: Users },
    { path: '/products', component: Products },
    { path: '/categories', component: Categories },
    { path: '/suppliers', component: Suppliers },
    { path: '/stock', component: Stock },
    { path: '/transactions', component: Transactions }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

const app = createApp(App);
app.use(router);
app.mount('#app');
