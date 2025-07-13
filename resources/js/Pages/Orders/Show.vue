<!-- <template>
    <AppLayout>
  <div class="p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Order #{{ order.id }}</h1>

    <div class="mb-4 text-gray-600">Status: {{ order.status }}</div>

    <table class="w-full border">
      <thead>
        <tr class="bg-gray-200 text-left">
          <th class="p-2">Product</th>
          <th class="p-2">Quantity</th>
          <th class="p-2">Price</th>
          <th class="p-2">Subtotal</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in order.order_items" :key="item.id" class="border-t">
          <td class="p-2">{{ item.product.name }}</td>
          <td class="p-2">{{ item.quantity }}</td>
          <td class="p-2">${{ item.price }}</td>
          <td class="p-2">${{ item.quantity * item.price }}</td>
        </tr>
      </tbody>
    </table>

    <div class="text-right font-bold text-xl mt-4">
      Total: ${{ order.total_price }}
    </div>
  </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  order: Object,
})
</script> -->

<template>
  <AppLayout>
    <div class="p-6 max-w-4xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">Order #{{ order.id }}</h1>

      <div class="mb-6 text-gray-600 font-semibold">
        Status: <span class="capitalize">{{ order.status }}</span>
      </div>

      <table class="w-full border border-gray-300 rounded-lg overflow-hidden shadow-sm">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="p-3 border-b border-gray-300">Product</th>
            <th class="p-3 border-b border-gray-300">Quantity</th>
            <th class="p-3 border-b border-gray-300">Price</th>
            <th class="p-3 border-b border-gray-300">Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="item in order.order_items"
            :key="item.id"
            class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150"
          >
            <td class="p-3">{{ item.product.name }}</td>
            <td class="p-3">{{ item.quantity }}</td>
            <td class="p-3">${{ item.price }}</td>
            <td class="p-3">${{ item.quantity * item.price }}</td>
          </tr>
        </tbody>
      </table>

      <div class="text-right font-bold text-xl mt-6 border-t border-gray-300 pt-4">
        Total: ${{ order.total_price }}
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
  order: Object,
})
</script>
