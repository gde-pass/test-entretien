<template>
  <div class="flex h-screen items-center justify-center" v-if="loading">
    Chargement
  </div>
  <div class="container mx-auto mt-10 min-h-screen" v-else>
    <router-view></router-view>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  name: "App",
  data() {
    return {
      loading: true,
    };
  },
  methods: {
    ...mapActions({
      chargerDepots: "demande_clinique/chargerDepots",
    }),
  },
  async mounted() {
    await this.chargerDepots();
    this.loading = false;
  },
};
</script>
