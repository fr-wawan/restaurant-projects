<template>
  <div class="mt-20 container mx-auto">
    <h1 class="text-3xl uppercase font-bold">
      My <span class="text-red-500">Orders</span>
    </h1>
    <div>
      <div v-if="orders.length > 0">
        <div class="bg-white p-4 mt-5 rounded-md" v-for="order in orders">
          <table class="w-full text-center">
            <tr>
              <th class="text-left">Tracking No</th>
              <th>Price</th>
              <th>Order Placed At</th>
              <th>Status</th>
              <th
                v-if="
                  order.payment_method == 'midtrans' &&
                  order.status == 'pending'
                "
              >
                Bayar
              </th>
              <th>Actions</th>
            </tr>
            <tr class="h-3"></tr>
            <tr>
              <td class="text-left">{{ order.invoice }}</td>
              <td>Rp. {{ formatPrice(order.amount) }}</td>
              <td>{{ order.order_placed_at }}</td>
              <td v-if="order.status == 'pending'" class="flex justify-center">
                <p class="p-1 px-3 text-sm text-white rounded-md bg-yellow-500">
                  In Progress
                </p>
              </td>
              <td v-if="order.status == 'success'" class="flex justify-center">
                <p class="p-1 px-3 text-sm text-white rounded-md bg-green-500">
                  Completed
                </p>
              </td>
              <td
                v-if="
                  order.payment_method == 'midtrans' &&
                  order.status == 'pending'
                "
              >
                <button
                  class="bg-green-500 p-2 px-5 text-sm text-white rounded-md"
                  @click="payment(order.snap_token)"
                >
                  Bayar
                </button>
              </td>
              <td>
                <router-link
                  :to="{
                    name: 'orders.show',
                    params: { invoice: order.invoice },
                  }"
                  class="bg-blue-500 p-2 px-5 text-white rounded-md"
                  >Details</router-link
                >
              </td>
            </tr>
          </table>
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

    function payment(snap_token) {
      window.snap.pay(snap_token, {
        onSuccess: function () {
          router.push({ name: "orders" });
        },
        onPending: function () {
          router.push({ name: "orders" });
        },
        onError: function () {
          router.push({ name: "orders" });
        },
      });
    }

    return {
      orders,
      nextExists,
      nextPage,
      payment,
      loadMore,
    };
  },
};
</script>
