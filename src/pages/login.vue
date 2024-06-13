<template>
  <v-container class="fill-height">
    <v-row>
      <v-col cols="12">
        <v-responsive class="align-centerfill-height mx-auto">
          <div class="text-center">
            <h1 class="text-h2 font-weight-bold">Bienvenid@</h1>
          </div>

          <div class="py-4" />
        </v-responsive>
      </v-col>
      <v-col cols="12">
        <v-card class="mx-auto px-6 py-8" max-width="344">
          <v-form v-model="form" @submit.prevent="onSubmit">
            <v-text-field
              v-model="email"
              :readonly="loading"
              :rules="emailRules"
              class="mb-2"
              label="CORREO"
              clearable
            ></v-text-field>

            <v-text-field
              v-model="password"
              :readonly="loading"
              :rules="required"
              label="CONTRASEÑA"
              type="password"
              placeholder="INGRESA TU CONTRASEÑA"
              clearable
            ></v-text-field>

            <br />

            <v-btn
              :disabled="!form"
              :loading="loading"
              color="success"
              size="large"
              type="submit"
              variant="elevated"
              block
            >
              Iniciar sesión
            </v-btn>
            <div class="text-center">
              <div
                class="text-body-2 font-weight-light mb-n1 mt-5"
                style="color: #cf6679"
              >
                {{ error }}
              </div>
            </div>
          </v-form>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup>
import { useSessionStore } from "@/stores/session";
const sessionStore = useSessionStore();
const form = ref(false);
const email = ref(null);
const password = ref(null);
const loading = ref(false);
const error = ref("");
const emailRules = [
  (value) => {
    if (value) return true;
    return "DATO REQUERIDO";
  },
  (value) => {
    if (/.+@.+\..+/.test(value)) return true;
    return "DEBE SER UN CORREO VÁLIDO";
  },
];

const onSubmit = () => {
  if (!form.value) return;

  loading.value = true;

  const myHeaders = new Headers();

  const formdata = new FormData();
  formdata.append("email", email.value);
  formdata.append("password", password.value);

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
    }/initsession.php`,
    requestOptions
  )
    .then((response) => response.json())
    .then((result) => {
      if (result.status == 0) {
        error.value = result.message;
      }
      //      sessionStore.setSession();
      setTimeout(() => {
        loading.value = false;
        //redireccionamos a la pagina de inicio
        window.location.href = "/";
      }, 2000);
    })
    .catch((error) => console.error(error));
};

const required = [
  (v) => {
    return !!v || "DATO REQUERIDO";
  },
];
</script>
