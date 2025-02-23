import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Dashboard from '../views/Dashboard.vue';
import Home from '../views/Home.vue';  // We'll create this

const routes = [
  { path: '/', component: Home },  // Public home page
  { path: '/login', component: Login },
  { 
    path: '/dashboard', 
    component: Dashboard,
    meta: { requiresAuth: true }  // Add authentication requirement
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

// Navigation guard
router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !localStorage.getItem('token')) {
    next('/login');
  } else {
    next();
  }
});

export default router;