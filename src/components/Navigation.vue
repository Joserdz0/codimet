<template>
  <v-app-bar :elevation="2">
    <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

    <v-app-bar-title>Codimet</v-app-bar-title>
  </v-app-bar>
  <v-navigation-drawer v-model="drawer" absolute temporary>
    <v-list-item link title="INICIO" to="/"></v-list-item>
    <v-list-item link title="PRODUCTOS" to="/products"></v-list-item>
    <v-list-item link title="VENTAS" to="/sales"></v-list-item>
  </v-navigation-drawer>
</template>
<script setup>
const drawer = ref(false);
</script>