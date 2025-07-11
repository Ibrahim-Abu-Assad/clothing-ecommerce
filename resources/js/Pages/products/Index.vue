<template>
    <div class="p-6 max-w-7xl mx-auto">

        <h1 class="text-3xl font-bold mb-6">Products</h1>

        <!-- Filters (Brands, Colors, Sizes, Categories, Price range (Min and Max), The first letter) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <select v-model="brand" class="border rounded px-3 py-2">
                <option value="">All Brands</option>
                <option v-for="b in uniqueBrands" :key="b">{{ b }}</option>
            </select>

            <select v-model="color" class="border rounded px-3 py-2">
                <option value="">All Colors</option>
                <option v-for="c in uniqueColors" :key="c">{{ c }}</option>
            </select>

            <select v-model="size" class="border rounded px-3 py-2">
                <option value="">All Sizes</option>
                <option v-for="s in uniqueSizes" :key="s">{{ s }}</option>
            </select>

            <select v-model="category" class="border rounded px-3 py-2">
                <option value="">All Categories</option>
                <option v-for="cat in uniqueCategories" :key="cat">{{ cat }}</option>
            </select>

            <input v-model.number="minPrice" type="number" placeholder="Min Price" class="border px-3 py-2 rounded" />
            <input v-model.number="maxPrice" type="number" placeholder="Max Price" class="border px-3 py-2 rounded" />

            <select v-model="sort" class="border rounded px-3 py-2">
                <option value="">Sort</option>
                <option value="az">A → Z</option>
                <option value="za">Z → A</option>
            </select>

            <input v-model="letter" type="text" maxlength="1" placeholder="Starts With"
                class="border px-3 py-2 rounded" />
            <input v-model="search" type="search" placeholder="Search..."
                class="border px-3 py-2 rounded col-span-full" />
        </div>

        <!-- Show products -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <div v-for="product in products.data" :key="product.id" class="border rounded p-4">
                <img :src="product.first_image?.image_path || 'https://via.placeholder.com/300x300?text=No+Image'"
                    alt="product.name" class="h-48 w-full object-cover rounded mb-3" />
                <h2 class="text-lg font-bold">{{ product.name }}</h2>
                <p class="text-gray-600">{{ product.brand }}</p>
                <p class="text-blue-600 font-bold">${{ product.price }}</p>
            </div>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6 space-x-2">
            <button v-for="page in pages" :key="page" @click="goToPage(page)"
                :class="['px-3 py-1 border rounded', page === products.current_page ? 'bg-blue-600 text-white' : '']">
                {{ page }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import debounce from 'lodash/debounce'

// Props
const props = defineProps({
    products: Object,
    filters: Object
})

// Filters reactive state
const brand = ref(props.filters.brand || '')
const color = ref(props.filters.color || '')
const size = ref(props.filters.size || '')
const category = ref(props.filters.category || '')
const minPrice = ref(props.filters.min_price || '')
const maxPrice = ref(props.filters.max_price || '')
const letter = ref(props.filters.letter || '')
const search = ref(props.filters.search || '')
const sort = ref(props.filters.sort || '')

// Extract unique options from current products
const uniqueBrands = computed(() => [...new Set(props.products.data.map(p => p.brand))])
const uniqueColors = computed(() => [...new Set(props.products.data.map(p => p.color))])
const uniqueSizes = computed(() => [...new Set(props.products.data.map(p => p.size))])
const uniqueCategories = computed(() => [...new Set(props.products.data.map(p => p.category))])

// Watch for filters
watch([brand, color, size, category, minPrice, maxPrice, letter, sort], updateFilters)
watch(search, debounce(updateFilters, 400))

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

    // Remove empty keys
    Object.keys(query).forEach(k => {
        if (!query[k]) delete query[k]
    })

    Inertia.get('/products', query, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}

const pages = computed(() => {
    const total = props.products.last_page
    return Array.from({ length: total }, (_, i) => i + 1)
})

function goToPage(page) {
    Inertia.get('/products', {
        ...props.filters,
        page
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    })
}
</script>
