<template>
  <v-container class="fill-height">
    <v-row>
      <v-col cols="12">
        <v-responsive class="align-centerfill-height mx-auto">
          <div class="text-center">
            <h1 class="text-h2 font-weight-bold">Bienvenid@</h1>
            <div class="text-body-5 font-weight-bold mb-n1">
              {{ sessionStore.session.name }}
            </div>
          </div>

          <div class="py-4" />
        </v-responsive>
      </v-col>
      <v-col cols="12 text-center">
        <div class="text-body-2 font-weight-light mb-n1">
          Selecciona la empresa:
        </div>
        <div class="text-body-5 font-weight-bold mb-n1" style="color: #cf6679">
          {{ error }}
        </div>
      </v-col>
      <v-col class="d-flex justify-content-around mt-5" cols="12">
        <v-img
          class="mb-4 imagenesEmpresas"
          :key="index"
          v-for="(value, index, key) in formImages"
          :src="value.company_image"
          @click="
            seleccionaEmpresa(
              value.company_id,
              value.company_name,
              value.company_image,
              value.role_id,
              value.role_name
            )
          "
        />
      </v-col>
    </v-row>
  </v-container>
</template>
  
  
<script setup>
import { useSessionStore } from "@/stores/session";
const sessionStore = useSessionStore();
const formImages = ref([]);
const error = ref("");
const seleccionaEmpresa = async (
  company_id,
  company_name,
  company_image,
  role_id,
  role_name
) => {
  //lamamos a la funcion de sessionStore setCompany
  let envioCompany = await sessionStore.setSessionCompany(
    company_id,
    company_name,
    company_image
  );
  let envioRole = await sessionStore.setSessionRole(role_id, role_name);
  if (envioCompany.status == 1 && envioRole.status == 1) {
    window.location.href = "/";
  } else {
    error.value = "Error al seleccionar la empresa";
    setTimeout(() => {
      //redireccionamos a la pagina de inicio
      window.location.href = "/";
    }, 2000);
  }
  //redirigimos a la pagina de inicio
};
//hacemos un onmounted para que se ejecute cuando se monte el componente
onMounted(async () => {
  const myHeaders = new Headers();

  const requestOptions = {
    method: "GET",
    headers: myHeaders,
    redirect: "follow",
    credentials: "include", //solo en local
  };

  const response = await fetch(
    `${
      window.location.hostname != window.location.host
        ? "http://localhost/codimet/public/"
        : window.location.origin
    }/listcompanies.php`,
    requestOptions
  );
  const data = await response.json();
  data.data.forEach(async (element) => {

    let datos = {
      company_name: element.company_name,
      company_id: element.company_id,
      company_image: window.location.origin+ "/images/companies/"+element.company_image,
      role_id: element.role_id,
      role_name: element.role_name,
    };
    formImages.value.push(datos);
  });
});
</script>
<style scoped>
.justify-content-around {
  justify-content: space-around;
}
.imagenesEmpresas {
  max-width: 150px;
  opacity: 0.3;
  transition: max-width 0.3s ease, opacity 0.3s ease;
}

.imagenesEmpresas:hover {
  max-width: 185px;
  opacity: 1;
}
</style>