<template>
  <p>menu = {{ opcion }}</p>
  <BottomNavigation v-model="opcion" :opciones="['Listar','Crear']" />
</template>

<script setup>
  const opcion = ref(0);

  //
</script>