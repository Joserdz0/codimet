<template>
  <v-container>
    <v-row>
      <v-col cols="12" v-if="opcion == 0">
        <v-data-iterator
          :items="ventas"
          :page="page"
          items-per-page="12"
          :search="search"
        >
          <template v-slot:default="props">
            <v-table>
              <thead style="background-color: #3B4094;">
                <tr>
                  <th class="text-left">
                    ID
                  </th>
                  <th class="text-left">
                    TOTAL
                  </th>
                  <th class="text-left">
                    FECHA
                  </th>
                  <th class="text-left">
                    ACCIONES
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr
                v-for="(item, index) in props.items"
                :key="index"
                >
                  <td> V - {{ item.raw.sale_id }}</td>
                  <td>$ {{ item.raw.sale_total }}</td>
                  <td>{{ formatoFecha(item.raw.sale_updated) }} {{ formatoHora(item.raw.sale_updated) }}</td>
                  <td>      
                    <v-tooltip text="VER TICKET">
                      <template v-slot:activator="{ props }">
                  
                          <v-btn :href="url + item.raw.sale_id" v-bind="props" target="_blank" density="compact" icon="mdi-list-box-outline"></v-btn>

                    </template>

                    </v-tooltip>
                  </td>
                </tr>
              </tbody>
            </v-table>

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
      <v-col cols="12" v-if="opcion == 1">
        <v-card class="mx-auto px-6 py-8" max-width="344">
          <v-form @submit.prevent="onSubmit">
            <v-row>
              <v-col
                cols="12"
                class="d-flex"
                v-for="(value, index) in canasta"
                :key="value['identificador']"
                style="border-bottom: 1px solid white"
              >
                <v-row>
                  <v-col cols="7" class="d-flex" style="align-items: center">
                    <v-autocomplete
                      v-model="value['id']"
                      label="ARTICULO"
                      :items="getItemNames()"
                      required
                    ></v-autocomplete>
                  </v-col>
                  <v-col cols="4">
                    <v-row>
                      <v-col cols="12">
                        PRECIO:
                        <br />
                        {{
                          value["id"] != 0 && value["id"] != undefined
                            ? items[value["id"]].item_price
                            : ""
                        }}
                      </v-col>
                      <v-col cols="12">
                        CANTIDAD:
                        <v-text-field
                          v-model="value['cantidad']"
                          style="width: 50px"
                          variant="underlined"
                          required
                          :rules="[
                            (valor) => {
                              if (!isNaN(valor)) return true;
                              return 'DEBE SER UN NUMERO';
                            },
                            (valor) => {
                              if (parseFloat(valor) >= 1) return true;
                              return `DEBE SER MAYOR A 0`;
                            },
                            (valor) => {
                              if (value['id'] != 0 && value['id'] != undefined)
                                return true;
                              return `DEBES ESCOGER UN ARTICULO`;
                            },

                            (valor) => {
                              if (
                                parseFloat(valor) <=
                                items[value['id']].item_quantity
                              )
                                return true;
                              return `DEBE SER MENOR O IGUAL QUE ${
                                items[value['id']].item_quantity
                              }`;
                            },
                          ]"
                        ></v-text-field>
                      </v-col>
                      <v-col cols="12">
                        TOTAL:
                        <br />
                        {{
                          value["id"] != 0 && value["id"] != undefined
                            ? items[value["id"]].item_price * value["cantidad"]
                            : ""
                        }}
                      </v-col>
                    </v-row>
                  </v-col>
                  <v-col cols="1" class="d-flex" style="align-items: center">
                    <v-icon
                      icon="mdi-delete"
                      @click="elimElement(index)"
                    ></v-icon>
                  </v-col>
                </v-row>
              </v-col>
              <v-col cols="12" class="d-flex" style="justify-content: center">
                TOTAL: {{ sumarTodo }}
              </v-col>
              <v-col cols="12" class="d-flex" style="justify-content: center">
                <v-icon icon="mdi-plus-circle" @click="anadirElemento"></v-icon>
              </v-col>
            </v-row>
            <br />

            <v-btn
              color="success"
              size="large"
              type="submit"
              variant="elevated"
              block
            >
              Crear Venta
            </v-btn>
          </v-form>
        </v-card>
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
const url = `${
  window.location.hostname != window.location.host
    ? "http://localhost/codimet/public/"
    : window.location.origin
}/api/sales/search.php?sale=`;
const opcion = ref(0);
const items = reactive({});
const canasta = ref([]);
const sumaTotal = ref(0);
const ventas = ref([]);
const page = ref(1);
const search = ref("");
const formatoFecha = (fecha) => {
  let dia = fecha.substring(8, 10);
  let mes =fecha.substring(5, 7);
  let ano = fecha.substring(0, 4);
  return (dia +'-'+ mes + '-'+ ano)
}
const formatoHora = (fecha) => {
  let hora = fecha.substring(11, 19);
  return hora
}
const onSubmit = () => {
  const myHeaders = new Headers();

  const formdata = new FormData();
  formdata.append("canasta", JSON.stringify(canasta.value));
  formdata.append("sumaTotal", sumaTotal.value);
  //console.log(canasta.value);

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
        ? "http://localhost/codimet/public/"
        : window.location.origin
    }/api/sales/create.php`,
    requestOptions
  )
    .then((response) => response.json())
    .then((result) => {
      //console.log(result);

      if (result.status == 1) {
        //actualizarItems();
        //search.value = nombre.value.toUpperCase();
        actualizarItems();
        actualizarSales();
        canasta.value = [];
        opcion.value = 0;
      }
    })
    .catch((error) => console.error(error));
};

const sumarTodo = computed(() => {
  let total = 0;
  let cantidad = 0;
  canasta.value.forEach((element) => {
    if (element.id != 0 && element.id != undefined) {
      //total +=  (  *  parseFloat(element.cantidad));

      if (element.cantidad == "") {
        cantidad = 0;
      } else {
        cantidad = parseFloat(element.cantidad);
      }
      total += parseFloat(items[element.id].item_price) * cantidad;
    }
  });
  sumaTotal.value = total;
  return total;
});
const elimElement = (id) => {
  canasta.value.splice(id, 1);
};
const getItemNames = () => {
  let regreso = [];
  console.log(items);
  for (let clave in items) {
    if (!isNaN(clave)) {
      // Verifica si la propiedad es propia del itemseto y no heredada

      regreso.push({
        title: items[clave].item_name,
        value: items[clave].item_id,
      });
    }
  }
  return regreso;

  /*   return items.map((item) => {
    return {
      title: item.item_name,
      value: item.item_id,
    };
  }); */
};

const anadirElemento = () => {
  if (Array.isArray(canasta.value) && canasta.value.length === 0) {
    canasta.value.push({
      identificador: 1,
      id: "",
      precio: 0,
      cantidad: "",
      total: 0,
    });
  } else {
    let ultimoIdentificador = canasta.value[canasta.value.length - 1];
    ultimoIdentificador = ultimoIdentificador.identificador + 1;
    canasta.value.push({
      identificador: ultimoIdentificador,
      id: "",
      precio: 0,
      cantidad: "",
      total: 0,
    });
  }
};
const actualizarSales = () => {
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
        ? "http://localhost/codimet/public/"
        : window.location.origin
    }/api/sales/list.php`,
    requestOptions
  )
    .then((response) => response.json())
    .then((result) => {
      ventas.value = result.data;
      //console.log(sales.value);
    })
    .catch((error) => console.error(error));
};
const actualizarItems = () => {
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
        ? "http://localhost/codimet/public/"
        : window.location.origin
    }/api/items/listforsales.php`,
    requestOptions
  )
    .then((response) => response.json())
    .then((result) => {
      result.data.forEach((element) => {
        items[element.item_id] = {
          item_id: element.item_id,
          item_name: element.item_name,
          item_price: element.item_price,
          item_quantity: element.item_quantity,
          item_status: element.item_status,
        };
      });
    })
    .catch((error) => console.error(error));
};
onMounted(() => {
  actualizarItems();
  actualizarSales();
});
//
</script>
