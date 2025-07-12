<script setup>
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import AppLayout from '@/Layouts/AppLayout.vue'

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

    if (quantity.value > product.stock) {
        alert('Requested quantity exceeds available stock.');
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
    <AppLayout>
    <div class="bg-gray-50 min-h-screen py-8 px-4 sm:px-6 lg:px-8">
        <div
            class="max-w-6xl mx-auto bg-white rounded-xl shadow-lg overflow-hidden p-4 sm:p-6 transition-all duration-300 hover:shadow-xl">
            <div class="grid md:grid-cols-2 gap-8 items-start">

                <!-- Images -->
                <div class="group relative">
                    <!-- <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
            <img
              v-for="img in product.images"
              :key="img.id"
              :src="img.image_path"
              alt="Product Image"
              class="h-20 w-20 object-cover rounded-lg border-2 border-gray-200 transition-all duration-200 hover:border-blue-500 hover:scale-105 cursor-pointer"
            />
          </div> -->

                    <div class="flex gap-2 mb-4 overflow-x-auto pb-2">
                        <img v-for="img in product.images" :key="img.id"
                            :src="img.image_path || 'data:image/jpeg;base64,/9j/4AAQSkZJRgABAQAAAQABAAD/2wCEAAkGBwgHBgkIBwgKCgkLDRYPDQwMDRsUFRAWIB0iIiAdHx8kKDQsJCYxJx8fLT0tMTU3Ojo6Iys/RD84QzQ5OjcBCgoKDQwNGg8PGjclHyU3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3Nzc3N//AABEIAJQAnAMBIgACEQEDEQH/xAAbAAEAAwEBAQEAAAAAAAAAAAAAAwQFAgYBB//EADgQAAEEAQMCAgYJAgcAAAAAAAEAAgMEEQUSIRMxUXEUIkGBkcEGFSMyM0JhcqFSYiQ0g5Kx0eH/xAAUAQEAAAAAAAAAAAAAAAAAAAAA/8QAFBEBAAAAAAAAAAAAAAAAAAAAAP/aAAwDAQACEQMRAD8A/XUREBERAREQEREBERAREQEREBERAREQEREBERAREQEREBEX0IPiL7LNFVrGeRu45wB7SqTdYhcftKzh+rHILiKJl+k/gSOYT/WFOzpy/hTRv8nIOUUhiePy58lwQR7D7wg+IiICIiAiIgIiICIiAi+qGSxHFw45PgEEq5kkZHy9wA8+VRluSP4YNg8R3ULAZJWNJLi4gclBY12UdGCIfuPwUmj6bBYqdWwwuLiQOcYAVDXJM3Q0dmMA+a9FpcfSoV2eDAfjygpy6DXdnpySM/lVJNBnb+FMx3mML0SIPLmrq1b7jZcD+l+4fBcjV7kTi2Qh2O4e1eqXktfka7U5QB90NHmcINutOy3TEwZtOSCM9iFyuNPZ0tKiHtf63xXaAiIgIiICIiAiIgjsgmCTb3wsoLZWVYj6Uzm+9BGrOnt3Wmn2NBKrK7pxEbJ5j2Y3PzQZFt3pOpva3ndLtHxwvatAa0AdgMLxGkYfqcTn9mEyO9wyrmoa/Ys5ZWHSjP8AuPv8iD1oRYej6rF6ARbnDXxcEuPLh7FFc+kjRltOPd/e/j4BB6AkDuV4W7IbF2ZzfzyHHx4VuncsWbb57ErnCGJ0oaTwCBgce9UtMZ19Qrx99z8/DlB617RHHFGPytAUaknOZCo0BERAREQEREBERAVW/HlgePy91aXxwDmlruxHKDHVid3R0Od44L+B7zj/ALUL2Fjy13cK1LXF/SvR43hr24Iz4hBgafbbUsdSSMSRuaWObnuCtDfoNjsbFY/qMj5qhLpF+PP+Gc4eMZ3KpJHJEcSxvYf7mkINr6ogm/yWoQSE/lccEqKbRr8XJgLh4sIcsfIKmht2IPwJ5GftcQg0o2PraXdkkaWPeWxN3DB5OT/wu/oxHv1LeRxGwnyJ4+azLN+1ba0WZ3SBvYH2Lc+j7MQW5vEtaPcCfmg13nLyVyiICIiAiIgIiICIiAiIgqXK7nuD425JGCFxDSd3kdt/QDlXkQI8xDDSfecqQylww8NcPAtUaIIpaVCf8WnHnxaMH+FUl0DT5Pwnyw+RyP5WgiDDk+jL8/Y243fvaQtqlTZp9EQNeHuJy52MZK2iDxEQEREBERAREQEREA9lS0zU4dRZIWAsdG7DmEjOPHyV1ecp1pmaZDeqMPpMJeHMPHUZuOQfkg0m6vEaEFkRvLrBIihbgucV3BqRfYbXtVpa0rx6m/BD/Ij2rIoh9anpVx0b3xRMeyQNbktBJ9bCuzWo9VuU2Utz2Qy9WSXaQGjHA59qDQu221OjuYXdWVsQwexPtUNfVIp9RsUhG5kkJIyTw7HfCj1sEihwSRcjJwPNZs7Jo5tQvV2Ez1rhc0f1NLQCg1q2pxWNRmpRsdmIEmQ9jjgj+Uj1WJ+puohjg5uQJM+qXAAkefKzK0f1TcLnguMdAueQM7nl2SPioDDqMGnRTGo3dDJ6QZer6xJ5PHkcINuxqHTsOr1q0tmZoBeGYAYD4kriTVWx0JLT60zXRvDHRP4OSfYe2OVSFhlSa513vgiuESw2WsLsZHbtwQqtmSxPpV10ktiWDqxdF8jMEjIyQEG5VtWJpdstCWBuCd73tIz4cK2snTJarrZbBeuzv2H1J23HjyAtZAREQEREBERAREQFWi1CrNXlnil3xwn1yAeFBrtl1bTpOnnqy/ZMwOcu/8Wfp0kVbU4oI4Zo4bEIicJYy3L2j5hBuekRGt6SH/AGOzfv8A7e6hm1CrDVjsyzbYZcbCQec/osQF/Q+ogTv9I2f6P3s/JTahJDNqYgfDNJXrQlm2KMuw9wx/AQbU1mKBjHSv2h7gxvGck9l9jsRzSSxxu3OhdteMYwV54WXT6Tp7JciWG7HE8O75B4/haOmyxs1DVd8jW5sDG44z6oQXrl2ClG2S1KGMLsAnnJXy1cgqQCWd+2MkAOwTyeyyNRmis6r0pYZZoIIiCI4y713ePkFWfZfNodVhdtngtMjcZB2xnBI8sIN2rqNS3IY4JcvAztLSOPepq1iOxE2WF25juAceHHyWOhjpPrw/SngsPMTxGYONniSOVY+jksf1XXYZGbi52BuGfvFBIdaoBzmmZ3qkg4jccEd1oA5AI7ELz2lm2I5xBcqxM9Jky2VmXZzyO69CO3KAiIgIiICIiAiIg4khikcx0kbXOjOWEj7p4hksUc23qsa/Ydzdw7HxC7RBGYITP1zEwzY29QtG7HhlfY4o43PdGxrHPducWjG4+JXaIIXVa7nl7oIy4vDyS0cuHY+ajl02jLI6SWpA97jlznMBJVpEHEUMUJcYo2sLzl20Yyf1UclKrLv6taJ/UIc/cwHcR2JU6IIK9KrWcXV60MRcMEsYBkLhmm0WSCRlOAPByHBgyD4q0iCo7S9Pe4udSrlxOSTGOSrY4AA7BEQEREBERB9wmERAwmERAwmERAwmERAwmERAwmERAwmERAwmERAwmERAwmERB//Z'"
                            alt="Product Image"
                            class="h-20 w-20 object-cover rounded-lg border-2 border-gray-200 transition-all duration-200 hover:border-blue-500 hover:scale-105 cursor-pointer" />
                    </div>

                    <div class="relative overflow-hidden rounded-xl shadow-md">
                        <img :src="product.images[0]?.image_path || 'https://via.placeholder.com/600x600?text=No+Image'"
                            alt="Main Product"
                            class="w-full h-auto md:h-[400px] object-cover transition-transform duration-500 group-hover:scale-105" />
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>
                </div>

                <!-- Product Info -->
                <div class="px-2 sm:px-4">
                    <h1 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-3 leading-tight">{{ product.name }}</h1>
                    <p class="text-gray-600 mb-4 leading-relaxed text-sm sm:text-base">{{ product.description }}</p>

                    <div class="flex items-center mb-6">
                        <p class="text-2xl font-semibold text-blue-600">${{ product.price }}</p>
                        <span class="ml-3 text-sm bg-blue-100 text-blue-800 px-2 py-1 rounded-full">In Stock: {{
                            product.stock }}</span>
                    </div>

                    <!-- Size -->
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Size</label>
                        <select v-model="selectedSize"
                            class="border border-gray-300 text-gray-700 rounded-lg px-4 py-2.5 w-full max-w-xs focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option disabled value="">Select Size</option>
                            <option v-for="size in product.sizes" :key="size" :value="size">{{ size }}</option>
                        </select>
                    </div>

                    <!-- Color -->
                    <div class="mb-4">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Color</label>
                        <select v-model="selectedColor"
                            class="border border-gray-300 text-gray-700 rounded-lg px-4 py-2.5 w-full max-w-xs focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">
                            <option disabled value="">Select Color</option>
                            <option v-for="color in product.colors" :key="color" :value="color">{{ color }}</option>
                        </select>
                    </div>

                    <!-- Quantity -->
                    <div class="mb-6">
                        <label class="block mb-2 text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" v-model.number="quantity" min="1" :max="product.stock"
                            class="border border-gray-300 text-gray-700 rounded-lg px-4 py-2.5 w-24 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" />
                    </div>

                    <!-- Add to Cart -->
                    <button @click="addToCart"
                        class="w-full sm:w-auto bg-blue-600 text-white px-8 py-3 rounded-lg hover:bg-blue-700 transition-all duration-300 transform hover:-translate-y-1 hover:shadow-lg font-medium text-sm sm:text-base">
                        Add to Cart
                    </button>
                </div>
            </div>
        </div>
    </div>
    </AppLayout>
</template>
