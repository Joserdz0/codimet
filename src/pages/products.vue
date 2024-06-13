<template>
    <Navigation/>
    <v-container>
      <v-row>
        <v-col cols="12">
          
        </v-col>
      </v-row>
    </v-container>
    <BottomNavigation v-model="opcion" :opciones="['Listar','Crear','Eliminar']" />
  </template>
  
  <script setup>
    const opcion = ref(0);

    //
  </script>