<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'

const { product } = defineProps({
  product: Object
})

const selectedSize = ref('')
const selectedColor = ref('')
const quantity = ref(1)

function addToCart() {
  if (!selectedSize.value || !selectedColor.value) {
    alert('Please select size and color.');
    return;
  }

  Inertia.post('/cart', {
    product_id: product.id,
    size: selectedSize.value,
    color: selectedColor.value,
    quantity: quantity.value,
  }, {
    onSuccess: () => Inertia.visit('/cart')
  });
}
</script>

<template>
  <div class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-4 sm:p-6 transition-all duration-300 hover:shadow-xl">
      <div class="grid md:grid-cols-2 gap-8 items-start">

        <!-- Images -->
        <div class="group relative">
          <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
            <img
              v-for="img in product.images"
              :key="img.id"
              :src="img.image_path"
              alt="Product Image"
              class="h-20 w-20 object-cover rounded-lg border-2 border-gray-200 transition-all duration-200 hover:border-blue-500 hover:scale-105 cursor-pointer"
            />
          </div>

          <div class="relative overflow-hidden rounded-xl shadow-md">
            <img
              :src="product.images[0]?.image_path || 'https://via.placeholder.com/600x600?text=No+Image'"
              alt="Main Product"
              class="w-full h-auto md:h-[400px] object-cover transition-transform duration-500 group-hover:scale-105"
            />
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
          </div>
        </div>

        <!-- Product Info -->
        <div class="px-2 sm:px-4">
          <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3 leading-tight">{{ product.name }}</h1>
          <p class="text-gray-600 mb-4 leading-relaxed text-sm sm:text-base">{{ product.description }}</p>

          <div class="flex items-center mb-6">
            <p class="text-2xl font-semibold text-blue-600">${{ product.price }}</p>
            <span class="ml-3 text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded-full">In Stock: {{ product.stock }}</span>
          </div>

          <!-- Size -->
          <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-700">Size</label>
            <select
              v-model="selectedSize"
              class="border border-gray-300 text-gray-700 rounded-lg px-4 py-2.5 w-full max-w-xs focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
            >
              <option disabled value="">Select Size</option>
              <option v-for="size in product.sizes" :key="size" :value="size">{{ size }}</option>
            </select>
          </div>

          <!-- Color -->
          <div class="mb-4">
            <label class="block mb-2 text-sm font-medium text-gray-700">Color</label>
            <select
              v-model="selectedColor"
              class="border border-gray-300 text-gray-700 rounded-lg px-4 py-2.5 w-full max-w-xs focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
            >
              <option disabled value="">Select Color</option>
              <option v-for="color in product.colors" :key="color" :value="color">{{ color }}</option>
            </select>
          </div>

          <!-- Quantity -->
          <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-700">Quantity</label>
            <input
              type="number"
              v-model.number="quantity"
              min="1"
              :max="product.stock"
              class="border border-gray-300 text-gray-700 rounded-lg px-4 py-2.5 w-24 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
            />
          </div>

          <!-- Add to Cart -->
          <button
            @click="addToCart"
            class="w-full sm:w-auto bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg font-medium text-sm sm:text-base"
          >
            Add to Cart
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

