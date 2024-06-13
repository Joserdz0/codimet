<template>
  <v-bottom-navigation mandatory>
    <v-btn v-for="opcion in opciones" :key="opcion">
      <v-icon>{{iconos[opcion]}}</v-icon>

      <span>{{ titulos[opcion] }}</span>
    </v-btn>
  </v-bottom-navigation>
</template>
<script setup>
const props = defineProps({
  opciones: {
    type: Array,
    default: () => [],
  },
});
const opciones = ref(props.opciones);
const titulos = reactive({
  Listar: "Lista",
  Crear: "Crear",
  Editar: "Editar",
  Eliminar: "Eliminados",
});
const iconos = reactive({
  Listar: "mdi-format-list-text",
  Crear: "mdi-plus",
  Editar: "mdi-pencil",
  Eliminar: "mdi-delete",
});
</script>