<!-- <template>
    <AppLayout>
  <div class="p-6 max-w-5xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Your Orders</h1>

    <div v-if="orders.length === 0" class="text-gray-600">
      You have no past orders.
    </div>

    <table v-else class="w-full border">
      <thead class="bg-gray-200 text-left">
        <tr>
          <th class="p-2">#</th>
          <th class="p-2">Date</th>
          <th class="p-2">Status</th>
          <th class="p-2">Items</th>
          <th class="p-2">Total</th>
          <th class="p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="order in orders" :key="order.id" class="border-t">
          <td class="p-2">#{{ order.id }}</td>
          <td class="p-2">{{ formatDate(order.created_at) }}</td>
          <td class="p-2">{{ order.status }}</td>
          <td class="p-2">{{ order.order_items_count }}</td>
          <td class="p-2">${{ order.total_price }}</td>
          <td class="p-2">
            <a
              :href="`/orders/${order.id}`"
              class="text-blue-600 hover:underline"
            >
              View
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { defineProps } from 'vue'

const props = defineProps({
  orders: Array
})

function formatDate(dateStr) {
  const date = new Date(dateStr)
  return date.toLocaleDateString() + ' ' + date.toLocaleTimeString()
}
</script> -->

<template>
  <AppLayout>
    <div class="p-6 max-w-5xl mx-auto">
      <h1 class="text-2xl font-bold mb-6">Your Orders</h1>

      <div v-if="orders.length === 0" class="text-gray-600 italic">
        You have no past orders.
      </div>

      <table v-else class="w-full border border-gray-300 rounded-lg overflow-hidden shadow-sm">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="p-3 border-b border-gray-300">#</th>
            <th class="p-3 border-b border-gray-300">Date</th>
            <th class="p-3 border-b border-gray-300">Status</th>
            <th class="p-3 border-b border-gray-300">Items</th>
            <th class="p-3 border-b border-gray-300">Total</th>
            <th class="p-3 border-b border-gray-300">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="order in orders"
            :key="order.id"
            class="border-b border-gray-200 hover:bg-gray-50 transition-colors duration-150 cursor-pointer"
          >
            <td class="p-3">#{{ order.id }}</td>
            <td class="p-3">{{ formatDate(order.created_at) }}</td>
            <td class="p-3 capitalize">{{ order.status }}</td>
            <td class="p-3">{{ order.order_items_count }}</td>
            <td class="p-3">${{ order.total_price }}</td>
            <td class="p-3">
              <a
                :href="`/orders/${order.id}`"
                class="text-indigo-600 hover:underline font-medium"
                @click.stop
              >
                View
              </a>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { defineProps } from 'vue'

const props = defineProps({
  orders: Array
})

function formatDate(dateStr) {
  const date = new Date(dateStr)
  return date.toLocaleDateString() + ' ' + date.toLocaleTimeString()
}
</script>

