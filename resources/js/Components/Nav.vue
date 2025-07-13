<template>
    <nav class="bg-blue-500 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo on the left -->
                <div class="flex-shrink-0">
                    <span class="text-2xl sm:text-3xl font-bold text-white">YourShop</span>
                </div>

                <!-- Links on the right (desktop) -->
                <div class="hidden sm:flex items-center space-x-8">
                    <NavLink :href="route('products.index')" :active="route().current('products.index')"
                        class="text-white no-underline hover:no-underline active:no-underline focus:no-underline hover:text-white active:text-white focus:text-white transition-transform duration-300 hover:scale-110">
                        Products
                    </NavLink>

                    <template v-if="user">
                        <NavLink :href="route('cart.index')" :active="route().current('cart.index')"
                            class="text-white no-underline hover:no-underline active:no-underline focus:no-underline hover:text-white active:text-white focus:text-white transition-transform duration-300 hover:scale-110">
                            Cart
                        </NavLink>

                        <NavLink :href="route('orders.index')" :active="route().current('orders.index')"
                            class="text-white no-underline hover:no-underline active:no-underline focus:no-underline hover:text-white active:text-white focus:text-white transition-transform duration-300 hover:scale-110">
                            My Orders
                        </NavLink>

                        <NavLink :href="route('profile.edit')"
                            class="text-white no-underline hover:no-underline active:no-underline focus:no-underline hover:text-white active:text-white focus:text-white transition-transform duration-300 hover:scale-110">
                            Profile
                        </NavLink>

                        <NavLink :href="route('logout')" method="post" as="button"
                            class="bg-red-500 text-white font-semibold px-4 py-1 rounded hover:bg-red-600 transition duration-300 hover:scale-105">
                            Log Out
                        </NavLink>
                    </template>

                    <template v-else>
                        <NavLink :href="route('login')" :active="route().current('login')"
                            class="bg-white text-black font-semibold px-4 py-1 rounded hover:bg-gray-100 transition duration-300 hover:scale-105">
                            Log In
                        </NavLink>
                        <NavLink :href="route('register')" :active="route().current('register')"
                            class="bg-white text-black font-semibold px-4 py-1 rounded hover:bg-gray-100 transition duration-300 hover:scale-105">
                            Register
                        </NavLink>
                    </template>
                </div>

                <!-- Mobile hamburger button -->
                <div class="flex items-center sm:hidden">
                    <button @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="inline-flex items-center justify-center p-2 rounded-md text-blue-200 hover:bg-blue-400 focus:outline-none focus:bg-blue-400 transition-transform duration-300 hover:scale-110">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{ 'hidden': showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path
                                :class="{ 'hidden': !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div :class="{ 'block': showingNavigationDropdown, 'hidden': !showingNavigationDropdown }"
            class="sm:hidden bg-blue-400">
            <div class="pt-2 pb-3 space-y-1">
                <ResponsiveNavLink :href="route('products.index')" :active="route().current('products.index')"
                    class="text-white no-underline hover:no-underline active:no-underline focus:no-underline hover:text-white active:text-white focus:text-white hover:bg-blue-300 transition-transform duration-300 hover:scale-105">
                    Products
                </ResponsiveNavLink>

                <template v-if="user">
                    <ResponsiveNavLink :href="route('cart.index')" :active="route().current('cart.index')"
                        class="text-white no-underline hover:no-underline active:no-underline focus:no-underline hover:text-white active:text-white focus:text-white hover:bg-blue-300 transition-transform duration-300 hover:scale-105">
                        Cart
                    </ResponsiveNavLink>

                    <ResponsiveNavLink :href="route('orders.index')" :active="route().current('orders.index')"
                        class="text-white no-underline hover:no-underline active:no-underline focus:no-underline hover:text-white active:text-white focus:text-white hover:bg-blue-300 transition-transform duration-300 hover:scale-105">
                        My Orders
                    </ResponsiveNavLink>

                    <ResponsiveNavLink :href="route('profile.edit')"
                        class="text-white no-underline hover:no-underline active:no-underline focus:no-underline hover:text-white active:text-white focus:text-white hover:bg-blue-300 transition-transform duration-300 hover:scale-105">
                        Profile
                    </ResponsiveNavLink>

                    <ResponsiveNavLink :href="route('logout')" method="post" as="button"
                        class="text-white no-underline hover:no-underline active:no-underline focus:no-underline hover:text-white active:text-white focus:text-white hover:bg-blue-300 transition-transform duration-300 hover:scale-105">
                        Log Out
                    </ResponsiveNavLink>
                </template>

                <template v-else>
                    <ResponsiveNavLink :href="route('login')" :active="route().current('login')"
                        class="text-white no-underline hover:no-underline active:no-underline focus:no-underline hover:text-white active:text-white focus:text-white hover:bg-blue-300 transition-transform duration-300 hover:scale-105">
                        Log In
                    </ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('register')" :active="route().current('register')"
                        class="text-white no-underline hover:no-underline active:no-underline focus:no-underline hover:text-white active:text-white focus:text-white hover:bg-blue-300 transition-transform duration-300 hover:scale-105">
                        Register
                    </ResponsiveNavLink>
                </template>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import AppLayout from '@/Layouts/AppLayout.vue';

const page = usePage();
const user = computed(() => page.props.auth.user);

const showingNavigationDropdown = ref(false);
</script>

<style scoped>
/* No extra styles needed */
</style>


