<template>
  <div class="p-4 sm:p-6 max-w-4xl mx-auto">
    <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800">Your Shopping Cart</h1>

    <!-- Flash Message -->
    <div v-if="$page.props.flash?.success"
         class="mb-6 p-4 rounded-lg bg-green-100 text-green-800 border border-green-200 flex items-center">
      <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
      </svg>
      {{ $page.props.flash.success }}
    </div>

    <!-- Empty Cart -->
    <div v-if="Object.keys(cartItems).length === 0" class="text-center py-12">
      <div class="mx-auto w-24 h-24 text-gray-400 mb-4">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
        </svg>
      </div>
      <p class="text-gray-600 text-lg mb-4">Your cart is empty</p>
      <a :href="route('products.index')" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
        Continue Shopping
      </a>
    </div>

    <!-- Cart Items -->
    <div v-else class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <!-- Table Header -->
      <div class="hidden md:grid grid-cols-12 bg-gray-50 p-4 border-b border-gray-200">
        <div class="col-span-4 font-medium text-gray-700">Product</div>
        <div class="col-span-1 font-medium text-gray-700 text-center">Size</div>
        <div class="col-span-1 font-medium text-gray-700 text-center">Color</div>
        <div class="col-span-2 font-medium text-gray-700 text-center">Quantity</div>
        <div class="col-span-1 font-medium text-gray-700 text-center">Price</div>
        <div class="col-span-2 font-medium text-gray-700 text-center">Subtotal</div>
        <div class="col-span-1"></div>
      </div>

      <!-- Cart Items -->
      <div v-for="(item, key) in cartItems" :key="key" class="p-4 border-b border-gray-200 hover:bg-gray-50 transition-colors">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
          <!-- Product Info -->
          <div class="col-span-4 flex items-center space-x-4">
            <img :src="item.image || 'https://via.placeholder.com/100x100?text=Product'"
                 alt="Product image"
                 class="w-16 h-16 object-cover rounded-lg border border-gray-200">
            <div>
              <h3 class="font-medium text-gray-800">{{ item.name || 'Product #' + item.product_id }}</h3>
              <p class="text-sm text-gray-500">{{ item.brand || '' }}</p>
            </div>
          </div>

          <!-- Size -->
          <div class="col-span-1 text-center text-gray-700">
            <span class="md:hidden text-sm text-gray-500">Size: </span>
            {{ item.size || '-' }}
          </div>

          <!-- Color -->
          <div class="col-span-1 text-center text-gray-700">
            <span class="md:hidden text-sm text-gray-500">Color: </span>
            {{ item.color || '-' }}
          </div>

          <!-- Quantity -->
          <div class="col-span-2">
            <form :action="route('cart.update', key)" method="POST" class="flex items-center justify-center space-x-2">
              <input type="hidden" name="_method" value="PATCH" />
              <input type="hidden" name="_token" :value="csrf" />
              <input type="number" name="quantity" :value="item.quantity" min="1" :max="item.stock"
                     class="w-16 border border-gray-300 rounded-lg px-3 py-2 text-center focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
              <button type="submit"
                      class="px-3 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                Update
              </button>
            </form>
          </div>

          <!-- Price -->
          <div class="col-span-1 text-center text-gray-700">
            <span class="md:hidden text-sm text-gray-500">Price: </span>
            ${{ item.price ?? 0 }}
          </div>

          <!-- Subtotal -->
          <div class="col-span-2 text-center font-medium text-gray-800">
            <span class="md:hidden text-sm text-gray-500">Subtotal: </span>
            ${{ (item.price ?? 0) * item.quantity }}
          </div>

          <!-- Remove -->
          <div class="col-span-1 text-center">
            <form :action="route('cart.destroy', key)" method="POST">
              <input type="hidden" name="_method" value="DELETE" />
              <input type="hidden" name="_token" :value="csrf" />
              <button type="submit"
                      class="text-red-600 hover:text-red-800 transition-colors p-1 rounded-full hover:bg-red-50">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
              </button>
            </form>
          </div>
        </div>
      </div>

      <!-- Cart Footer -->
      <div class="p-4 bg-gray-50 border-t border-gray-200">
        <div class="flex justify-between items-center">
            <a :href="route('products.index')" class="text-blue-600 hover:text-blue-800 hover:underline flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Continue Shopping
          </a>
          <div class="flex items-center space-x-6">
            <div class="text-lg font-bold text-gray-800">Total: ${{ total }}</div>
            <a href="/checkout" class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
              Proceed to Checkout
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { defineProps } from 'vue';
import { usePage } from '@inertiajs/vue3';

const props = defineProps({
  cartItems: Object,
  total: Number,
});

const csrf = usePage().props.csrf_token;
</script>
