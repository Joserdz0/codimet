<template>

  <v-navigation-drawer v-model="drawer" style="position:fixed; height: 100vh;">
    <v-list-item link title="INICIO" to="/"></v-list-item>
    <v-list-item link title="PRODUCTOS" to="/products"></v-list-item>
    <v-list-item link title="VENTAS" to="/sales"></v-list-item>
  </v-navigation-drawer>

  <v-app-bar style="position: sticky;">
    <v-app-bar-nav-icon @click.stop="drawer = !drawer"></v-app-bar-nav-icon>

    <v-app-bar-title>Codimet</v-app-bar-title>
  </v-app-bar>
</template>
<script setup>
const drawer = ref(false);
const onClickOutside = () => {
  drawer.value = !drawer.value;
};
</script>