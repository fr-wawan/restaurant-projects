<template>
  <div class="">
    <HeroIndex />

    <div class="mt-10 container mx-auto">
      <h1 class="text-3xl font-bold uppercase">
        Menu <span class="text-red-500">Lists</span>
      </h1>
      <div>
        <CategoryCard :categories="categories" />
      </div>
      <div class="">
        <h1 class="mt-10 text-3xl font-bold uppercase">
          Food <span class="text-red-500">Lists</span>
        </h1>
        <FoodCard :foods="foods" />
      </div>
    </div>
  </div>
</template>

<script>
import { ref, computed, onMounted } from "vue";
import { useStore } from "vuex";
import CategoryCard from "../../components/CategoryCard.vue";
import HeroIndex from "../../components/HeroIndex.vue";
import FoodCard from "../../components/FoodCard.vue";

export default {
  name: "HomeComponent",

  components: {
    CategoryCard,
    HeroIndex,
    FoodCard,
  },

  setup() {
    const store = useStore();

    onMounted(() => {
      store.dispatch("food/getFood");
      store.dispatch("category/getCategoryHome");
    });

    const foods = computed(() => {
      return store.state.food.foods;
    });

    const categories = computed(() => {
      return store.state.category.categories;
    });

    return { categories, foods };
  },
};
</script>
