<template>
  <v-app>
    <Navigation v-if="(sessionStore.session.status == 1) && sessionStore.session.company_id != 0" />
 

      <v-main class="quitar-top">
        <router-view />
      </v-main>
  </v-app>
</template>

<script setup>
  import { useSessionStore } from "@/stores/session";
  const sessionStore = useSessionStore();
</script>
<style scoped>
.quitar-top {
  --v-layout-top: 0px!important; /* Cambia el valor a 0 o lo que necesites */
}
</style>
