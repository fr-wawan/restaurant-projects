<template>
  <div class="container mx-auto mt-10">
    <h1 class="text-3xl mb-10 font-bold uppercase">
      Menu <span class="text-red-500">List</span>
    </h1>
    <CategoryCard :categories="categories" />
  </div>
</template>

<script>
import { ref, onMounted, computed } from "vue";
import { useStore } from "vuex";
import { useToast } from "vue-toastification";
import { useRoute } from "vue-router";
import CategoryCard from "../../components/CategoryCard.vue";
export default {
  name: "CategoryIndexComponent",

  components: {
    CategoryCard,
  },
  setup() {
    const store = useStore();
    const route = useRoute();
    const toast = useToast();

    onMounted(() => {
      store.dispatch("category/getCategory");
    });

    const categories = computed(() => {
      return store.state.category.categories;
    });

    return {
      categories,
    };
  },
};
</script>
