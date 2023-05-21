<template>
  <div class="mt-20 container mx-auto">
    <h1 class="text-3xl uppercase font-bold">
      My <span class="text-red-500">Orders</span>
    </h1>
    <div>
      <div v-if="orders.length > 0">
        <div class="bg-white p-3 mt-5 rounded-md">
          <div class="flex justify-between">
            <h1>Tracking No</h1>
            <h1>Price</h1>
            <h1>Order Placed At</h1>
            <h1>Status</h1>
            <h1>Action</h1>
          </div>
          <div class="flex justify-between">
            <p>tes</p>
            <p>tes</p>
            <p>tes</p>
            <p>tes</p>
            <p>tes</p>
          </div>
        </div>
        <div class="bg-white p-3 rounded-md mt-3">
          <div class="flex justify-between">
            <h1>Tracking No</h1>
            <h1>Price</h1>
            <h1>Order Placed At</h1>
            <h1>Status</h1>
            <h1>Action</h1>
          </div>
          <div class="flex justify-between">
            <p>tes</p>
            <p>tes</p>
            <p>tes</p>
            <p>tes</p>
            <p>tes</p>
          </div>
        </div>
      </div>
      <div v-else class="bg-gray-200 rounded-md p-10 shadow-md mt-5">
        <h1
          class="font-bold text-xl bg-red-500 rounded-md p-10 text-white text-center"
        >
          Anda Belum Memiliki Transaksi Saat Ini
        </h1>
      </div>
    </div>
  </div>
</template>

<script>
import { useStore } from "vuex";
import { computed, onMounted } from "vue";

export default {
  name: "OrderComponent",

  setup() {
    const store = useStore();

    onMounted(() => {
      store.dispatch("order/getOrder");
    });

    const orders = computed(() => {
      return store.state.order.orders;
    });

    const nextExists = computed(() => {
      return store.state.order.nextExists;
    });

    const nextPage = computed(() => {
      return store.state.order.nextPage;
    });

    function loadMore() {
      store.dispatch("order/getLoadMore", nextPage.value);
    }

    return {
      orders,
      nextExists,
      nextPage,
      loadMore,
    };
  },
};
</script>
