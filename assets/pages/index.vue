<template>
  <div>
    <div class="mb-2">
      <h1 class="text-4xl font-bold">Bienvenue sur ma belle application</h1>
      <p class="text-xl">Listing des demandes cliniques</p>
    </div>
    <div class="flex w-full flex-col gap-2">
      <div
        v-for="depot in depots"
        :key="depot.id"
        class="rounded-xl bg-white p-4 shadow-sm"
      >
        <p class="text-base font-semibold">
          Titre:
          <span class="text-base font-light text-gray-700">
            {{ depot.titre }}
          </span>
        </p>
        <p class="text-base font-semibold">
          Description:
          <span class="text-base font-light text-gray-700">
            {{ depot.description }}
          </span>
        </p>
        <p class="text-base font-semibold">
          Date de création:
          <span class="text-base font-light text-gray-700">
            {{ depot.date_creation }}
          </span>
        </p>
        <div
          class="border-gray my-4 flex flex-col gap-2 rounded-xl border bg-gray-100 p-2"
          v-if="depot.reponses.length"
        >
          <div
            v-for="reponse in depot.reponses"
            :class="[
              'flex',
              'items-center',
              'justify-between',
              'border-2',
              'border-dashed',
              'px-4',
              'py-2',
              reponse.date_validation ? 'bg-green-100' : 'bg-white',
            ]"
            :key="reponse.id"
          >
            <div>
              <p class="text-base font-semibold text-red-500">
                Type:
                <span class="text-base font-light text-gray-700">
                  {{ getTypeLabel(reponse.type) }}
                </span>
              </p>
              <p class="text-base font-semibold">
                Titre:
                <span class="text-base font-light text-gray-700">
                  {{ reponse.titre }}
                </span>
              </p>
              <p class="text-base font-semibold">
                Description:
                <span class="text-base font-light text-gray-700">
                  {{ reponse.description }}
                </span>
              </p>
              <p class="text-base font-semibold">
                Date de création:
                <span class="text-base font-light text-gray-700">
                  {{ reponse.date_creation }}
                </span>
              </p>
            </div>
            <input
              :id="reponse.id"
              v-if="!reponse.date_validation"
              type="checkbox"
              class="h-6 w-6"
              :checked="reponseCheckboxes?.[depot.id]?.[reponse.id]"
              @change="toggleCheckbox(depot.id, reponse.id)"
            />
          </div>
        </div>
        <div class="flex items-center justify-center" v-else>
          <p class="text-base font-semibold">Aucune réponse</p>
        </div>
        <div class="flex justify-between">
          <MyButton
            class="mt-2"
            variant="blue"
            text="Répondre à la demande"
            @buttonClick="$router.push(`/depots/${depot.id}`)"
          />
          <MyButton
            v-if="depot.reponses.length"
            class="mt-2"
            variant="green"
            text="Valider"
            :disabled="!isAnyCheckboxChecked(depot.id)"
            @buttonClick="openModal(depot.id)"
          />
        </div>
      </div>
    </div>
    <!-- Modal -->
    <div
      class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-5"
      v-if="showModal"
    >
      <div class="relative rounded-lg bg-white p-8">
        <span
          class="absolute right-3 top-1.5 cursor-pointer text-xl text-gray-500 hover:text-gray-700"
          @click.prevent="closeModal()"
        >
          &times;
        </span>
        <h2 class="mb-4 text-xl font-semibold">
          Veuillez saisir la raison de cette validation
        </h2>
        <input
          type="text"
          v-model.trim="messageValidation"
          class="mb-4 w-full rounded-md border border-gray-300 px-3 py-2"
        />
        <div class="flex justify-center">
          <MyButton
            variant="green"
            text="Envoyer"
            @buttonClick="handleSubmit()"
          />
        </div>
      </div>
    </div>
    <!-- End Modal -->
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import { getLabel } from "@/enum/demande_clinique/reponse/type";
// import api from "@/api";

import MyButton from "../components/atoms/MyButton.vue";

export default {
  name: "Index",
  components: {
    MyButton,
  },
  data() {
    return {
      reponseCheckboxes: {},
      showModal: false,
      modalData: {},
      messageValidation: "",
    };
  },
  computed: {
    ...mapGetters({
      depots: "demande_clinique/depots",
    }),
    isAnyCheckboxChecked() {
      return (depotId) => {
        const depotCheckboxes = this.reponseCheckboxes[depotId];
        if (!depotCheckboxes) return false;
        return Object.values(depotCheckboxes).some((checked) => checked);
      };
    },
  },
  methods: {
    ...mapActions({
      chargerDepots: "demande_clinique/chargerDepots",
    }),
    getTypeLabel: getLabel,
    openModal(depotId) {
      this.showModal = true;
      this.modalData.depotId = depotId;
      this.modalData.reponseIdToModify = Object.keys(
        this.reponseCheckboxes[depotId],
      ).filter((key) => this.reponseCheckboxes[depotId][key]);
    },
    closeModal() {
      this.showModal = false;
      this.modalData = {};
      this.messageValidation = "";
    },
    async handleSubmit() {
      // try {
      //   await api.demande_clinique.depots.modifierReponse(
      //     this.modalData.depotId,
      //     this.modalData.reponseIdToModify,
      //     this.messageValidation,
      //   );
      // } catch (error) {
      //   console.error(error);
      //   window.alert("Une erreur est survenue");
      // }

      await this.chargerDepots();
      this.closeModal();
    },
    toggleCheckbox(depotId, reponseId) {
      const depotCheckboxes = this.reponseCheckboxes[depotId];
      if (depotCheckboxes && reponseId in depotCheckboxes) {
        this.$set(depotCheckboxes, reponseId, !depotCheckboxes[reponseId]);
      }
    },
    initializeReponseCheckboxes() {
      this.reponseCheckboxes = {};
      this.depots.forEach((depot) => {
        const depotCheckboxes = {};
        depot.reponses.forEach((reponse) => {
          this.$set(depotCheckboxes, reponse.id, false);
        });
        this.$set(this.reponseCheckboxes, depot.id, depotCheckboxes);
      });
    },
  },
  mounted() {
    this.initializeReponseCheckboxes();
  },
};
</script>
