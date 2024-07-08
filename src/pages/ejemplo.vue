<template>
  <Navigation />
  <p>menu = {{ opcion }}</p>
  <BottomNavigation
    v-model="opcion"
    :opciones="['Listar', 'Crear', 'Eliminar']"
  />
</template>  
 <script setup>
const opcion = ref(0);

//
</script>