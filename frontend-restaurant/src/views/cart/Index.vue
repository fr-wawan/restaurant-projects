<template>
  <div class="container mx-auto mt-20">
    <h1 class="text-3xl mb-10 font-bold uppercase">
      Cart <span class="text-red-500">Lists</span>
    </h1>
    <div class="" v-if="carts?.length > 0">
      <div class="bg-white rounded-lg shadow-lg">
        <div v-for="cart in carts" class="flex justify-between text-lg p-2">
          <img
            :src="`//localhost:8000${cart.food.image}`"
            class="rounded-md mb-2 p-4 w-36"
          />
          <h1>{{ cart.food.title }}</h1>
          <h1>Rp. {{ formatPrice(cart.food.price) }}</h1>

          <div class="flex items-center border border-gray-200 rounded h-10">
            <button
              type="button"
              @click="cart.quantity--"
              class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
              :disabled="cart.quantity == 1"
            >
              &minus;
            </button>

            <input
              type="number"
              id="Quantity"
              class="h-10 w-16 border border-gray-200 text-center [-moz-appearance:_textfield] sm:text-sm [&::-webkit-outer-spin-button]:m-0 [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:m-0 [&::-webkit-inner-spin-button]:appearance-none"
              v-model="cart.quantity"
            />

            <button
              type="button"
              class="w-10 h-10 leading-10 text-gray-600 transition hover:opacity-75"
              @click="cart.quantity++"
            >
              &plus;
            </button>
          </div>
          <button
            class="bg-red-500 text-white p-3 px-5 rounded-md hover:bg-red-400 flex items-center text-base gap-2"
            @click.prevent="deleteCart(cart.id)"
          >
            <svg
              xmlns="http://www.w3.org/2000/svg"
              class="icon icon-tabler icon-tabler-trash"
              width="24"
              height="24"
              viewBox="0 0 24 24"
              stroke-width="2"
              stroke="currentColor"
              fill="none"
              stroke-linecap="round"
              stroke-linejoin="round"
            >
              <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
              <path d="M4 7l16 0"></path>
              <path d="M10 11l0 6"></path>
              <path d="M14 11l0 6"></path>
              <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path>
              <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path>
            </svg>
            Remove
          </button>
        </div>
      </div>
    </div>
    <div v-else class="bg-gray-200 rounded-md p-10 shadow-md mt-5">
      <h1
        class="font-bold text-xl bg-red-500 rounded-md p-10 text-white text-center uppercase"
      >
        Your carts is empty
      </h1>
    </div>
  </div>
</template>

<script>
import { computed, ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import { useStore } from "vuex";
import { useRouter } from "vue-router";

export default {
  name: "CartIndexComponent",

  setup() {
    const store = useStore();
    const toast = useToast();
    const router = useRouter();

    onMounted(() => {
      store.dispatch("cart/getCart");
    });

    const carts = computed(() => {
      return store.state.cart.cart;
    });

    function deleteCart(cart) {
      store
        .dispatch("cart/deleteCart", cart)
        .then(() => {
          store.dispatch("cart/getCart");
          toast.success("Cart Deleted Successfully");
        })
        .catch((error) => {
          console.log(error);
        });
    }

    return {
      carts,
      deleteCart,
    };
  },
};
</script>
