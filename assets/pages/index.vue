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
        <LabelText title="Titre:" :text="depot.titre" variant="black" />
        <LabelText
          title="Description:"
          :text="depot.description"
          variant="black"
        />
        <LabelText
          title="Date de création:"
          :text="depot.date_creation"
          variant="black"
        />

        <div
          class="border-gray my-4 flex flex-col gap-2 rounded-xl border bg-gray-100 p-2"
          v-if="depot.reponses.length"
        >
          <ReponseCard
            v-for="reponse in depot.reponses"
            :key="reponse.id"
            :reponse="reponse"
            :isChecked="reponseCheckboxes?.[depot.id]?.[reponse.id]"
            @checkboxChange="toggleCheckbox(depot.id, reponse.id)"
          />
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
    <ValidationModal
      v-if="showModal"
      :message-validation="messageValidation"
      @change:message-validation="messageValidation = $event"
      @closeModal="closeModal()"
      @submit="handleSubmit()"
    />
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";
// import api from "@/api";

import MyButton from "../components/atoms/MyButton.vue";
import ReponseCard from "../components/molecules/ReponseCard.vue";
import LabelText from "../components/atoms/LabelText.vue";
import ValidationModal from "../components/organisms/ValidationModal.vue";

export default {
  name: "Index",
  components: {
    MyButton,
    ReponseCard,
    LabelText,
    ValidationModal,
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
