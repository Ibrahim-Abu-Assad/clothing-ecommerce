<template>

    <Nav />

    <div class="p-4 sm:p-6 max-w-7xl mx-auto">
        <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-gray-800">All Products</h1>

        <!-- Filters Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <!-- Brand Filter -->
            <div class="relative">
                <select v-model="brand"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white pr-8">
                    <option value="">All Brands</option>
                    <option v-for="b in uniqueBrands" :key="b" :value="b">{{ b }}</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <!-- Color Filter -->
            <div class="relative">
                <select v-model="color"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white pr-8">
                    <option value="">All Colors</option>
                    <option v-for="c in uniqueColors" :key="c" :value="c">{{ c }}</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <!-- Size Filter -->
            <div class="relative">
                <select v-model="size"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white pr-8">
                    <option value="">All Sizes</option>
                    <option v-for="s in uniqueSizes" :key="s" :value="s">{{ s }}</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <!-- Category Filter -->
            <div class="relative">
                <select v-model="category"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white pr-8">
                    <option value="">All Categories</option>
                    <option v-for="cat in uniqueCategories" :key="cat" :value="cat">{{ cat }}</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <!-- Price Range Filters -->
            <input v-model.number="minPrice" type="number" placeholder="Min Price"
                class="border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />

            <input v-model.number="maxPrice" type="number" placeholder="Max Price"
                class="border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />

            <!-- Sort Filter -->
            <div class="relative">
                <select v-model="sort"
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 appearance-none bg-white pr-8">
                    <option value="">Sort By</option>
                    <option value="az">A → Z</option>
                    <option value="za">Z → A</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>

            <!-- Letter Filter -->
            <input v-model="letter" type="text" maxlength="1" placeholder="Starts With"
                class="border border-gray-300 rounded-lg px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />

            <!-- Search Input -->
            <div class="relative col-span-full">
                <input v-model="search" type="search" placeholder="Search products..."
                    class="w-full border border-gray-300 rounded-lg px-4 py-2.5 pl-10 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div v-for="product in products.data" :key="product.id"
                class="border border-gray-200 rounded-xl p-4 transition-all duration-300 hover:shadow-lg hover:border-blue-100 hover:transform hover:-translate-y-1 group cursor-pointer"
                @click="viewProduct(product.id)">
                <div class="relative overflow-hidden rounded-lg mb-4 h-48 bg-gray-100">
                    <img :src="product.first_image?.image_path || 'https://via.placeholder.com/300x300?text=No+Image'"
                        alt="product.name"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" />
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                    </div>
                </div>
                <h2 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition-colors">{{ product.name
                    }}</h2>
                <p class="text-gray-600 text-sm">{{ product.brand }}</p>
                <p class="text-blue-600 font-bold mt-2">${{ product.price }}</p>
            </div>
        </div>

        <!-- Pagination -->
        <div v-if="pages.length > 1" class="flex justify-center mt-8 space-x-2">
            <button v-for="page in pages" :key="page" @click="goToPage(page)"
                :class="['px-4 py-2 border rounded-lg transition-colors duration-200',
                    page === products.current_page ? 'bg-blue-600 text-white border-blue-600' : 'border-gray-300 hover:bg-blue-50 text-gray-700']">
                {{ page }}
            </button>
        </div>
    </div>
</template>

<script setup>
import Nav from '@/Components/Nav.vue'
import { ref, watch, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import debounce from 'lodash/debounce'

const props = defineProps({
    products: Object,
    filters: Object
})

// Refs for filters
const brand = ref(props.filters.brand || '')
const color = ref(props.filters.color || '')
const size = ref(props.filters.size || '')
const category = ref(props.filters.category || '')
const minPrice = ref(props.filters.min_price || '')
const maxPrice = ref(props.filters.max_price || '')
const letter = ref(props.filters.letter || '')
const search = ref(props.filters.search || '')
const sort = ref(props.filters.sort || '')

// Computed properties for unique filter options
const uniqueBrands = computed(() => [...new Set(props.products.data.map(p => p.brand))])
const uniqueColors = computed(() => [...new Set(props.products.data.map(p => p.color))])
const uniqueSizes = computed(() => [...new Set(props.products.data.map(p => p.size))])
const uniqueCategories = computed(() => [...new Set(props.products.data.map(p => p.category))])

// Watch for filter changes
watch([brand, color, size, category, minPrice, maxPrice, letter, sort], updateFilters)
watch(search, debounce(updateFilters, 400))

// Navigation to product detail page
function viewProduct(productId) {
    Inertia.get(`/products/${productId}`)
}

// Update filters and refresh results
function updateFilters() {
    const query = {
        brand: brand.value,
        color: color.value,
        size: size.value,
        category: category.value,
        min_price: minPrice.value,
        max_price: maxPrice.value,
        letter: letter.value,
        search: search.value,
        sort: sort.value,
        page: 1
    }

    // Remove empty filters
    Object.keys(query).forEach(k => {
        if (!query[k]) delete query[k]
    })

    Inertia.get('/', query, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}

// Generate pagination pages
const pages = computed(() => {
    const total = props.products.last_page
    return Array.from({ length: total }, (_, i) => i + 1)
})

// Go to specific page
function goToPage(page) {
    Inertia.get('/', {
        ...props.filters,
        page
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}
</script>
