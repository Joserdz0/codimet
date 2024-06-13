/**
 * router/index.ts
 *
 * Automatic routes for `./src/pages/*.vue`
 */

// Composables
import { createRouter, createWebHistory } from "vue-router/auto";
import { setupLayouts } from "virtual:generated-layouts";
//importamos sessionStore
import { useSessionStore } from "../stores/session";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  extendRoutes: setupLayouts,
});


router.beforeEach(async(to, from) => {
  const sessionStore = useSessionStore();
  await sessionStore.setSession();
  if ( to.name !== "/login" && sessionStore.session.status == 0) {
    return { name: "/login" };
  } else if(to.name !== "/login" && sessionStore.session.status == 1){
    if (to.name !== "/selectbussines" && sessionStore.session.company_id == 0) {
      return { name: "/selectbussines" }; 
    } else if(to.name !== "/selectbussines" && sessionStore.session.company_id != 0){
    }else if (to.name === "/selectbussines" && sessionStore.session.company_id == 0) {
      
    }else if (to.name === "/selectbussines" && sessionStore.session.company_id != 0) {
      return { name: "/" };
    }
  }else if(to.name === "/login" && sessionStore.session.status == 0){
  }else if(to.name === "/login" && sessionStore.session.status == 1){
    return { name: "/" };
  }
});
export default router;
