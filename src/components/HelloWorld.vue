<template>
  <v-container class="fill-height">
    <v-row>
      <v-col cols="12">
        <v-responsive class="align-centerfill-height mx-auto">
          <v-img class="mb-4" height="150" :src="sessionStore.session.company_image" />

          <div class="text-center">
            <div class="text-body-2 font-weight-light mb-n1">Bienvenido a</div>

            <h1 class="text-h2 font-weight-bold">{{ sessionStore.session.company_name }}</h1>
          </div>

          <div class="py-4" />
        </v-responsive>
      </v-col>
      <v-col class="d-none" cols="12">
        <v-card
          class="py-4"
          color="surface-variant"
          image="https://cdn.vuetifyjs.com/docs/images/one/create/feature.png"
          prepend-icon="mdi-rocket-launch-outline"
          rounded="lg"
          variant="outlined"
        >
          <template #image>
            <v-img position="top right" />
          </template>

          <template #title>
            <h2 class="text-h5 font-weight-bold">Get started</h2>
          </template>

          <template #subtitle>
            <div class="text-subtitle-1">
              Replace this page by removing
              <v-kbd>{{ `<HelloWorld />` }}</v-kbd> in
              <v-kbd>pages/index.vue</v-kbd>.
            </div>
          </template>

          <v-overlay
            opacity=".12"
            scrim="primary"
            contained
            model-value
            persistent
          />
        </v-card>
      </v-col>

      <v-col cols="12" md="6">
        <v-card
          append-icon="mdi-open-in-new"
          class="py-4"
          color="surface-variant"
          to="/products"
          prepend-icon="mdi-format-list-bulleted-type"
          rel="noopener noreferrer"
          rounded="lg"
          subtitle="Aqui podemmos registrar un nuevo producto, eliminar, editarlo."
          title="Productos"
          variant="text"
        >
          <v-overlay
            opacity=".06"
            scrim="primary"
            contained
            model-value
            persistent
          />
        </v-card>
      </v-col>
      <v-col cols="12" md="6">
        <v-card
          append-icon="mdi-open-in-new"
          class="py-4"
          color="surface-variant"
          to="/sales"
          prepend-icon="mdi-store-outline"
          rel="noopener noreferrer"
          rounded="lg"
          subtitle="Aqui se puede realizar una nueva venta, ver las ventas hechas."
          title="Ventas"
          variant="text"
        >
          <v-overlay
            opacity=".06"
            scrim="primary"
            contained
            model-value
            persistent
          />
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { useSessionStore } from "@/stores/session";
const sessionStore = useSessionStore();
//
</script>
