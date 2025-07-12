<template>
    <AppLayout>
  <div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Checkout</h1>

    <div v-if="cartItems.length === 0" class="text-gray-600">
      Your cart is empty.
    </div>

    <div v-else>
      <table class="w-full border mb-6">
        <thead>
          <tr class="bg-gray-200 text-left">
            <th class="p-2">Product</th>
            <th class="p-2">Size</th>
            <th class="p-2">Color</th>
            <th class="p-2">Quantity</th>
            <th class="p-2">Price</th>
            <th class="p-2">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(item, key) in cartItems" :key="key" class="border-t">
            <td class="p-2">{{ item.name }}</td>
            <td class="p-2">{{ item.size }}</td>
            <td class="p-2">{{ item.color }}</td>
            <td class="p-2">{{ item.quantity }}</td>
            <td class="p-2">${{ item.price }}</td>
            <td class="p-2">${{ item.quantity * item.price }}</td>
          </tr>
        </tbody>
      </table>

      <div class="text-right font-bold text-xl mb-4">
        Total: ${{ total.toFixed(2) }}
      </div>

      <form @submit.prevent="placeOrder">
        <button
          type="submit"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
        >
          Place Order
        </button>
      </form>
    </div>
  </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3'
import { defineProps } from 'vue'

const props = defineProps({
  cartItems: Array,
  total: Number,
})

function placeOrder() {
  router.post('/orders', {}, {
    onSuccess: () => {
      // redirect handled in controller (to order details page)
    },
    onError: (errors) => {
      alert('Failed to place order.');
    },
  })
}
</script>
