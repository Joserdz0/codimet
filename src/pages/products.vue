<template>
  <v-container>
    <v-row>
      <v-col cols="12" v-if="opcion == 0">
        <v-data-iterator
          :items="items"
          :page="page"
          items-per-page="15"
          :search="search"
        >
          <template v-slot:header>
            <v-toolbar
              class="px-2"
              style="background-color: #212121 !important"
            >
              <v-text-field
                v-model="search"
                density="comfortable"
                placeholder="Search"
                prepend-inner-icon="mdi-magnify"
                style="max-width: 300px"
                bg-color="#424242"
                variant="solo"
                clearable
                hide-details
              ></v-text-field>
            </v-toolbar>
          </template>
          <template v-slot:default="{ items }">
            <v-row class="pt-5">
              <v-col
                cols="12"
                md="4"
                v-for="(item, index, key) in items"
                :key="key"
              >
                <v-card color="#3B4094">
                  <v-row>
                    <v-col
                      cols="4"
                      class="d-flex"
                      md="4"
                      style="align-items: center; justify-content: center"
                    >
                      <v-avatar rounded="0" size="100">
                        <vue-qr :text="item.raw.item_name"
                        :logoSrc="logo"
                        :size="100"></vue-qr>
                      </v-avatar>
                    </v-col>
                    <v-col cols="8" md="8">
                      <v-card-title class="truncate">
                        {{ listEdit[item.raw.item_id] == false ? item.raw.item_name : '' }}
                        <v-text-field
                        v-if="listEdit[item.raw.item_id] == true"
                        v-model="item.raw.item_name"
                         @input="cambiarDato('name',item.raw.item_name,item.raw.item_id)"
                        style="width: 300px;"
                          variant="underlined"
                        ></v-text-field>
                      </v-card-title>

                      <div class="d-flex">
                        <v-card-subtitle
                        class="d-flex" style="align-items: center;"
                        >CANTIDAD: {{ listEdit[item.raw.item_id] == false ? item.raw.item_quantity : '' }}
                        <v-text-field
                        v-if="listEdit[item.raw.item_id] == true"
                        v-model="item.raw.item_quantity"
                         @input="cambiarDato('quantity',item.raw.item_quantity,item.raw.item_id)"
                        style="width: 50px;"
                          variant="underlined"
                        ></v-text-field>
                      </v-card-subtitle>
                      <v-card-subtitle
                        class="d-flex" style="align-items: center;" 
                        
                        >PRECIO: {{ listEdit[item.raw.item_id] == false ? item.raw.item_price : '' }}
                        <v-text-field
                        v-if="listEdit[item.raw.item_id] == true"
                        @input="cambiarDato('price',item.raw.item_price,item.raw.item_id)"
                        v-model="item.raw.item_price"
                        style="width: 50px;"
                          variant="underlined"
                        ></v-text-field>
                      </v-card-subtitle>
                      </div>


                      <v-card-actions class="d-flex" style="justify-content: end ;">
                        <v-btn
                          class="ms-2"
                          :icon="listEdit[item.raw.item_id] == false ? 'mdi-pencil' : 'mdi-check'"
                          variant="text"
                          @click="listEdit[item.raw.item_id] = !listEdit[item.raw.item_id]"
                        ></v-btn>
                        <v-btn
                          v-if="false"
                          class="ms-2"
                          icon="mdi-download"
                          variant="text"
                        ></v-btn>
                        <v-btn
                          v-if="listEdit[item.raw.item_id] == true"
                          color="red-darken-4"
                          class="ms-2"
                          icon="mdi-delete"
                          variant="text"
                          @click="cambiarDato('status',0,item.raw.item_id); elimElementListEdit(item.raw.item_id)"
                        ></v-btn>

                      </v-card-actions>
                    </v-col>
                  </v-row>
                </v-card>
              </v-col>
            </v-row>
          </template>
          <template v-slot:footer="{ page, pageCount, prevPage, nextPage }">
            <div class="d-flex align-center justify-center pa-4">
              <v-btn
                :disabled="page === 1"
                density="comfortable"
                icon="mdi-arrow-left"
                variant="tonal"
                rounded
                @click="prevPage"
              ></v-btn>

              <div class="mx-2 text-caption">
                Page {{ page }} of {{ pageCount }}
              </div>

              <v-btn
                :disabled="page >= pageCount"
                density="comfortable"
                icon="mdi-arrow-right"
                variant="tonal"
                rounded
                @click="nextPage"
              ></v-btn>
            </div>
          </template>
        </v-data-iterator>
      </v-col>

    </v-row>
  </v-container>
  <BottomNavigation
    v-model="opcion"
    :opciones="['Listar', 'Crear']"
    style="position: fixed; bottom: 0; width: 100%"
  />
</template>
  
  <script setup>
import VueQr from "vue-qr";
import vueQr from "vue-qr/src/packages/vue-qr.vue";
import { useSessionStore } from "@/stores/session";
const sessionStore = useSessionStore();

const opcion = ref(0);
const items = ref([]);
const page = ref(1);
const search = ref("");
const listEdit = reactive({});
//const logo = window.location.origin + "/images/companies/codimet.png";
const logo = sessionStore.session.company_image;
const elimElementListEdit = (id) => {
  delete listEdit[id];
  console.log(listEdit);
};
const cambiarDato = (nombre,valor,id) => {
  if(valor == ""){
    valor = '0';
  }
  const myHeaders = new Headers();

  const formdata = new FormData();
  formdata.append("nombre", nombre);
  formdata.append("valor", valor);
  formdata.append("id", id);

  const requestOptions = {
    method: "POST",
    headers: myHeaders,
    body: formdata,
    redirect: "follow",
    credentials: "include", //solo en local
  };
  
  fetch(
    `${
      window.location.hostname != window.location.host
        ? "http://localhost:8000"
        : window.location.origin
    }/api/items/update.php`,
    requestOptions
  )
    .then((response) => response.json())
    .then((result) => {
      actualizarItems();

    })
    .catch((error) => console.error(error));

};

const actualizarItems = () =>{
  const myHeaders = new Headers();
  const requestOptions = {
    method: "GET",
    headers: myHeaders,
    redirect: "follow",
    credentials: "include", //solo en local
  };

  fetch(
    `${
      window.location.hostname != window.location.host
        ? "http://localhost:8000"
        : window.location.origin
    }/api/items/list.php`,
    requestOptions
  )
    .then((response) => response.json())
    .then((result) => {
      items.value = result.data;


      //por cada result.data le añadimos un campo a listEdit
      result.data.forEach((element) => {
        //si no existe el campo en listEdit lo añadimos
        if (listEdit[element.item_id] === undefined) {
          listEdit[element.item_id] = false;
        } 

      });

    })
    .catch((error) => console.error(error));

}
//ponemos onmounted para que se ejecute cuando se monte el componente
onMounted(() => {
  actualizarItems();
  console.log()
});
</script>
<style scoped>
.truncate {
  white-space: nowrap;
  overflow: hidden; /* Oculta el contenido que desborda el contenedor */
  text-overflow: ellipsis; /* Agrega los puntos suspensivos */
  /* min-width: 200px; */ /* Ancho fijo del contenedor */
}
</style>