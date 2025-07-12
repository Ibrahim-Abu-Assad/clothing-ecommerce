<!-- <template>
  <nav>
    <Link href="/">Home</Link>

    <template v-if="!auth.user">
      <Link href="/login">Login</Link>
      <Link href="/register">Register</Link>
    </template>

    <template v-else>
      <Link href="/cart">Cart</Link>
      <Link href="/orders">My Orders</Link>
      <Link href="/profile">Profile</Link>
      <Link href="/logout" method="post">Logout</Link>

      <template v-if="auth.user.is_admin">
        <Link href="/admin/products">Admin Panel</Link>
      </template>
    </template>
  </nav>
</template>

<script setup>
defineProps({ auth: Object })
</script> -->

<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Include your Nav component here (corrected name) -->
    <Nav />

    <!-- Page Heading -->
    <header class="bg-white shadow" v-if="$slots.header">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <slot name="header" />
      </div>
    </header>

    <!-- Page Content -->
    <main>
      <slot />
    </main>
  </div>
</template>

<script setup>
// Corrected import: import Nav from '@/Components/Nav.vue';
import Nav from '@/Components/Nav.vue'; // Import your Nav component (corrected name)
// You might also need to import other components like Dropdown, DropdownLink if you use them
// from Breeze's default layout, but for this example, Nav is the main addition.
</script>

