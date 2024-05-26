<template>
  <div v-if="depot">
    <div class="mb-2">
      <h1 class="text-4xl font-bold">{{ depot.titre }}</h1>
      <p class="text-xl">{{ depot.description }}</p>
    </div>
    <div class="mt-4 rounded-xl bg-white px-4 py-2">
      <h2 class="text-md font-semibold">Création d'une nouvelle réponse</h2>
      <form class="flex flex-col gap-2" @submit.prevent="creer">
        <input
          type="text"
          v-model="titre"
          placeholder="Titre"
          class="rounded-lg border border-gray-300 p-2"
        />
        <textarea
          v-model="description"
          placeholder="Description"
          class="rounded-lg border border-gray-300 p-2"
        />
        <select
          v-model="type"
          class="rounded-lg border border-gray-300 p-2"
          placeholder="Priorité"
        >
          <option selected disabled value="0">Type de réponse</option>
          <option
            v-for="typeLabel in getTypes()"
            :value="typeLabel"
            :key="typeLabel"
          >
            {{ getTypeLabel(typeLabel) }}
          </option>
        </select>
        <MyButton
          variant="blue"
          :disabled="loading"
          :text="loading ? 'En cours' : 'Creer'"
          @buttonClick="creer"
        />
      </form>
    </div>
  </div>
  <div v-else>
    <p>Le dépot n'existe pas</p>
  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import api from "@/api";
import { getAll, getLabel } from "@/enum/demande_clinique/reponse/type";
import MyButton from "../../components/atoms/MyButton.vue";

export default {
  name: "Depot",
  components: {
    MyButton,
  },
  data() {
    return {
      titre: "",
      description: "",
      loading: false,
      type: 0,
    };
  },
  computed: {
    ...mapGetters({
      depots: "demande_clinique/depots",
    }),
    id() {
      return parseInt(this.$route.params.id);
    },
    depot() {
      return this.depots.find((depot) => depot.id === this.id);
    },
  },
  methods: {
    ...mapActions({
      chargerDepots: "demande_clinique/chargerDepots",
    }),
    getTypes: getAll,
    getTypeLabel: getLabel,
    async creer() {
      if (!(this.titre && this.description)) {
        window.alert("Veuillez remplir tous les champs");
        return;
      }

      try {
        this.loading = true;
        await api.demande_clinique.depots.ajouterReponse(
          this.depot.id,
          this.titre,
          this.description,
          this.type,
        );
        await this.chargerDepots();
        this.$router.push("/");
      } catch (e) {
        console.error(e);
        window.alert("Une erreur est survenue");
        this.loading = false;
      }
    },
  },
};
</script>
