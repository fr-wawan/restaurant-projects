<template>
  <div class="container mx-auto">
    <div class="flex gap-5">
      <div>
        <label for="username">Username</label>
        <input
          type="text"
          name="username"
          id="username"
          class="block border border-black rounded p-1 w-full"
        />
      </div>
      <div>
        <label for="username">Username</label>
        <input
          type="text"
          name="username"
          id="username"
          class="block border border-black rounded-sm p-1 w-full"
        />
      </div>
    </div>
  </div>
</template>

<script>
import { computed, ref, onMounted } from "vue";
import { useToast } from "vue-toastification";
import { useStore } from "vuex";
import { useRouter } from "vue-router";
export default {
  name: "TransactionIndexComponent",

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

    return {
      carts,
    };
  },
};
</script>
