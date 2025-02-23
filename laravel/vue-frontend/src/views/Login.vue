<template>
  <LoginTemplate
    :email="email"
    :password="password"
    :errorMessage="errorMessage"
    :isLoading="isLoading"
    @update:email="email = $event"
    @update:password="password = $event"
    @login="login"
  />
</template>

<script>
import LoginTemplate from "../components/Login/LoginTemplate.vue";
import LoginLogic from "../components/Login/LoginLogic.js";
import "../components/Login/LoginStyle.css";

export default {
  components: {
    LoginTemplate,
  },
  ...LoginLogic,
};
</script>
