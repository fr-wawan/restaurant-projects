<template>
  <div class="mt-10 container mx-auto">
    <h1 class="text-3xl mb-10 font-bold uppercase">
      Food List <span class="text-red-500">IN {{ category.name }}</span>
    </h1>
    <FoodCard :foods="foodCategory" />
  </div>
</template>

<script>
import { onMounted, computed } from "vue";
import { useRoute } from "vue-router";
import { useStore } from "vuex";
import { useToast } from "vue-toastification";
import FoodCard from "../../components/FoodCard.vue";

export default {
  name: "CategoryShowComponent",

  components: {
    FoodCard,
  },

  setup() {
    const route = useRoute();
    const store = useStore();
    const toast = useToast();

    onMounted(() => {
      store.dispatch("category/getDetailCategory", route.params.slug);
    });

    const category = computed(() => {
      return store.state.category.category;
    });
    const foodCategory = computed(() => {
      return store.state.category.foodCategory;
    });

    return {
      category,
      foodCategory,
    };
  },
};
</script>
