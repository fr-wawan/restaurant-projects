<template>
  <div class="w-5/12 mx-auto gap-20 rounded-md p-5 flex bg-white mt-10">
    <div class="box box1 w-6/12">
      <img :src="`//localhost:8000${food.image}`" class="rounded-lg mb-2" />
    </div>
    <div>
      <h1 class="text-3xl uppercase font-bold">{{ food.title }}</h1>
      <p class="mt-5 text-gray-500 text-sm">
        Rp. {{ formatPrice(food.price) }}
      </p>
      <p class="my-5">{{ removeTags(food.description) }}</p>
      <div class="flex items-center border border-gray-200 rounded">
        <button
          type="button"
          :disabled="quantity == 1"
          @click.prevent="quantity--"
          class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
        >
          &minus;
        </button>

        <input
          type="number"
          id="Quantity"
          class="h-10 w-10 mx-auto border-transparent text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
          @click.prevent=""
          v-model="quantity"
          min="1"
        />

        <button
          type="button"
          class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
          @click.prevent="quantity++"
        >
          &plus;
        </button>
      </div>
      <button
        class="bg-white transition-all hover:text-white hover:bg-red-500 border border-red-500 p-3 text-md uppercase font-semibold text-red-500 rounded-lg px-10 mx-3 my-3 mt-10"
        @click="addToCart(food)"
      >
        Order
      </button>
    </div>
  </div>
</template>

<script>
import { useStore } from "vuex";
import { useRoute } from "vue-router";
import { useToast } from "vue-toastification";
import { ref, onMounted, computed } from "vue";
export default {
  name: "FoodIndexComponent",

  setup() {
    const store = useStore();
    const route = useRoute();
    const toast = useToast();

    const quantity = ref(1);

    onMounted(() => {
      store.dispatch("food/detailsFood", route.params.slug);
    });

    function addToCart(food) {
      let formData = new FormData();

      formData.append("id", food.id);
      formData.append("quantity", quantity.value);

      store
        .dispatch("cart/storeCart", formData)
        .then(() => {
          toast.success("Added to Cart Successfully");
        })
        .catch((error) => {
          console.log(error);
        });
    }

    const food = computed(() => {
      return store.state.food.food;
    });

    return {
      food,
      quantity,
      addToCart,
    };
  },
};
</script>

<style scoped>
.box img {
  width: 100%;
  height: 100%;
}

.box1 img {
  object-fit: cover;
}
</style>
