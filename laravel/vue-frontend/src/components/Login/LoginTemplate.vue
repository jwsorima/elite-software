<template>
  <div class="login-wrapper">
    <div class="login-container">
      <h2>Admin Login</h2>
      <form @submit.prevent="$emit('login')">
        <input type="email" :value="email" @input="$emit('update:email', $event.target.value)" placeholder="Email" required />
        <input type="password" :value="password" @input="$emit('update:password', $event.target.value)" placeholder="Password" required />
        <button type="submit" :disabled="isLoading">
          {{ isLoading ? "Logging in..." : "Login" }}
        </button>
      </form>
      <p v-if="errorMessage" class="error">{{ errorMessage }}</p>
      <router-link to="/" class="back-link">← Back to Home</router-link>
    </div>
  </div>
</template>

<script>
export default {
  props: ["email", "password", "errorMessage", "isLoading"],
};
</script>
