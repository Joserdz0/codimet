// Utilities
import { defineStore } from "pinia";

export const useSessionStore = defineStore("session", {
  state: () => ({
    //creamos la variable isAuthenticated
    session: {
      status: 0,
    },
  }),
  //creamos un action para cambiar el estado de session
  actions: {
    async setSession() {
      const myHeaders = new Headers();

      const requestOptions = {
        method: "POST",
        headers: myHeaders,
        redirect: "follow",
        credentials: "include", //solo en local
      };

      const response = await fetch(
        `${
          window.location.hostname !=
          window.location.host
            ? 'http://localhost/codimet/public/' 
            : window.location.origin 
        }/checksession.php`,
        requestOptions
      );
      const data = await response.json();
      if (data.status == 1) {
        this.session = data.data;
      } else {
        this.session = {
          status: 0,
        };
      }
    },

    async setSessionCompany(company_id, company_name, company_image) {
      this.session.company_id = company_id;
      this.session.company_name = company_name;
      this.session.company_image = company_image;
      const myHeaders = new Headers();
      const formdata = new FormData();
      formdata.append("data", JSON.stringify(this.session));
      const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
        credentials: "include", //solo en local
      };
      const response = await fetch(
        `${
          window.location.hostname !=
          window.location.host
            ? 'http://localhost/codimet/public/' 
            : window.location.origin 
        }/updatedatasession.php`,
        requestOptions
      );
      const data = await response.json();
      return data;
    },
    async setSessionRole(role_id, role_name) {
      this.session.role_id = role_id;
      this.session.role_name = role_name;
      const myHeaders = new Headers();
      const formdata = new FormData();
      formdata.append("data", JSON.stringify(this.session));
      const requestOptions = {
        method: "POST",
        headers: myHeaders,
        body: formdata,
        redirect: "follow",
        credentials: "include", //solo en local
      };
      const response = await fetch(
        `${
          window.location.hostname !=
          window.location.host
            ? 'http://localhost/codimet/public/' 
            : window.location.origin 
        }/updatedatasession.php`,
        requestOptions
      );
      const data = await response.json();
      return data;
    },
  },
});
