<template>
  <div>
    <div class="bg-white mt-10 rounded-md container mx-auto">
      <div class="bg-gray-200 p-5 rounded-t-md text-xl font-bold uppercase">
        User Delivery <span class="text-red-500">Details</span>
      </div>
      <div class="pb-20">
        <div class="">
          <div class="flex gap-5 mt-5 justify-center">
            <div>
              <label for="name">Name : </label>
              <input
                type="text"
                name="name"
                id="name"
                class="block border border-gray-500 placeholder:text-sm text-gray-500 rounded p-2 mt-3"
                placeholder="Name..."
                style="width: 30rem"
                v-model="order.name"
              />
            </div>
            <div>
              <label for="phone">Phone : </label>
              <input
                type="text"
                name="phone"
                id="phone"
                class="block border border-gray-500 placeholder:text-sm text-gray-500 rounded mt-3 p-2 w-96"
                placeholder="Phone Number..."
                style="width: 30rem"
                v-model="order.phone"
              />
            </div>
            <div>
              <label for="phone">Pin Code : </label>
              <input
                type="text"
                class="block border border-gray-500 placeholder:text-sm rounded text-gray-500 mt-3 p-2 w-96"
                placeholder="Pin Code..."
                style="width: 30rem"
                v-model="order.pin_code"
                disabled
              />
            </div>
          </div>
          <div class="mt-5">
            <label for="address" class="mx-7">Address : </label>
            <input
              name="message"
              id="message"
              cols="91"
              rows="8"
              class="border border-gray-500 block mt-3 rounded-md p-5 w-full text-gray-500 mx-auto"
              style="width: 97%"
              placeholder=""
              :value="order.address"
              disabled
            />
          </div>
          <div class="mt-5">
            <label for="message" class="mx-7">User Message : </label>
            <input
              name="message"
              id="message"
              cols="91"
              rows="8"
              class="border border-gray-500 block mt-3 rounded-md p-5 w-full text-gray-500 mx-auto"
              style="width: 97%"
              placeholder=""
              :value="
                order.description == null
                  ? 'You dont have any Message'
                  : order.description
              "
              disabled
            />
          </div>
        </div>
      </div>
    </div>
    <div class="bg-white mt-10 rounded-md container mx-auto">
      <div class="bg-gray-200 p-5 rounded-t-md text-xl font-bold uppercase">
        My Order <span class="text-red-500">Details</span>
      </div>
      <div class="pb-20 mx-5 mt-5">
        <div class="flex gap-52">
          <p>Tracking Number : {{ order.invoice }}</p>
          <p v-if="order.status == 'pending'" class="">
            Order Status :
            <span class="p-1 px-3 text-sm text-white rounded-md bg-yellow-500">
              In Progress
            </span>
          </p>
        </div>
        <div class="flex gap-80 mt-5">
          <p>
            Payment Mode :
            <span class="uppercase">{{ order.payment_method }}</span>
          </p>
          <p class="ml-3">Order Placed At : {{ order.order_placed_at }}</p>
        </div>
        <p class="border border-b-gray-300 my-5"></p>
        <table class="w-full mt-5">
          <tr>
            <th>Products Image</th>
            <th>Product Title</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
          </tr>

          <tr v-for="food in order.food">
            <td>
              <img
                :src="`//localhost:8000${food.image} `"
                class="w-28"
                alt=""
              />
            </td>
            <td>{{ food.title }}</td>
            <td>Rp. {{ formatPrice(food.price) }}</td>
            <td>{{ formatPrice(food.pivot.quantity) }}</td>
            <td>Rp. {{ formatPrice(food.pivot.quantity * food.price) }}</td>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>
<script>
import { useStore } from "vuex";
import { computed, onMounted } from "vue";
import { useRoute } from "vue-router";
export default {
  name: "OrderShowComponent",

  setup() {
    const store = useStore();
    const route = useRoute();

    onMounted(() => {
      store.dispatch("order/detailOrders", route.params.invoice);
    });

    const order = computed(() => {
      return store.state.order.order;
    });

    return {
      order,
    };
  },
};
</script>

<style>
table {
  border-collapse: collapse;
  width: 95%;
}

.table-section h1 {
  margin-top: 3rem;
}

table td,
table th {
  padding: 1rem;
}

table td {
  border-bottom: lightgray solid 1px;
}

table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  border-bottom: darkslategray solid 1px;
}
</style>
