<script setup>
import { ref, computed } from "vue";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import SidebarNavLink from "@/Components/SidebarNavLink.vue";
import { Link, usePage } from "@inertiajs/vue3";

const showingNavigationDropdown = ref(false);
const isSidebarOpen = ref(false);
const sidebarNavIcon = computed(() =>
  isSidebarOpen.value
    ? "block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 bg-gray-100 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
    : "block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 transition duration-150 ease-in-out"
);

// Toggle sidebar for mobile view
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
};

// Get the current route name for active link highlighting
const { component } = usePage().props;
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar -->
    <div
      class="fixed inset-y-0 left-0 bg-white dark:bg-gray-800 w-96 md:w-72 shadow-md transform transition-transform duration-300 ease-in-out z-50 lg:translate-x-0 overflow-y-auto lg:w-72"
      :class="[isSidebarOpen ? 'translate-x-0' : '-translate-x-full', 'lg:translate-x-0']"
    >
      <div class="flex flex-col">
        <!-- Logo -->
        <div class="shrink-0 flex justify-center items-center py-5">
          <Link :href="route('admin.dashboard.index')">
            <ApplicationLogo class="block h-10 w-auto fill-current text-gray-800" />
          </Link>
        </div>
        <!-- Navigation Links -->
        <nav class="flex flex-col p-5 space-y-5 sm:space-y-6 lg:space-y-8">
          <div>
            <div>
              <SidebarNavLink
                :href="route('admin.dashboard.index')"
                :active="route().current('admin.dashboard.index')"
                class="flex items-center space-x-3 py-2 text-sm sm:text-base"
              >
                <span class="material-symbols-outlined">dashboard</span>
                <span>Overview</span>
              </SidebarNavLink>
            </div>

            <div>
              <SidebarNavLink
                :href="route('admin.sale.index')"
                :active="route().current('admin.sale.index')"
                class="flex items-center space-x-3 py-2 text-sm sm:text-base"
              >
                <span class="material-symbols-outlined">payments</span>
                <span>Sales</span>
              </SidebarNavLink>
            </div>

            <div>
              <SidebarNavLink
                :href="route('admin.user.index')"
                :active="route().current('admin.user.index')"
                class="flex items-center space-x-3 py-2 text-sm sm:text-base"
              >
                <span class="material-symbols-outlined">person</span>
                <span>Manage Users</span>
              </SidebarNavLink>
            </div>
          </div>

          <!-- Setup -->
          <div>
            <p
              class="text-gray-600 dark:text-gray-200 uppercase font-semibold text-xs tracking-wide pb-2 sm:pb-3"
            >
              Setup
            </p>

            <SidebarNavLink
              :href="route('admin.setup.product_category.index')"
              :active="route().current('admin.setup.product_category.index')"
              class="flex items-center space-x-3 py-2 text-sm sm:text-base"
            >
              <span class="material-symbols-outlined">category</span>
              <span>Product Categories</span>
            </SidebarNavLink>

            <SidebarNavLink
              :href="route('admin.setup.measuring_unit.index')"
              :active="route().current('admin.setup.measuring_unit.index')"
              class="flex items-center space-x-3 py-2 text-sm sm:text-base"
            >
              <span class="material-symbols-outlined">straighten</span>
              <span>Measuring Units</span>
            </SidebarNavLink>
          </div>

          <!-- Inventory -->
          <div>
            <p
              class="text-gray-600 uppercase font-semibold text-xs tracking-wide pb-2 sm:pb-3"
            >
              Inventory
            </p>

            <SidebarNavLink
              :href="route('admin.inventory.product.index')"
              :active="route().current('admin.inventory.product.index')"
              class="flex items-center space-x-3 py-2 text-sm sm:text-base"
            >
              <span class="material-symbols-outlined">medication</span>
              <span>Products</span>
            </SidebarNavLink>

            <SidebarNavLink
              :href="route('admin.inventory.pricing.index')"
              :active="route().current('admin.inventory.pricing.index')"
              class="flex items-center space-x-3 py-2 text-sm sm:text-base"
            >
              <span class="material-symbols-outlined">money</span>
              <span>Pricing List</span>
            </SidebarNavLink>

            <SidebarNavLink
              :href="route('admin.inventory.stock.index')"
              :active="route().current('admin.inventory.stock.index')"
              class="flex items-center space-x-3 py-2 text-sm sm:text-base"
            >
              <span class="material-symbols-outlined">bar_chart</span>
              <span>Stock Levels</span>
            </SidebarNavLink>

            <SidebarNavLink
              :href="route('admin.inventory.expired.index')"
              :active="route().current('admin.inventory.expired.index')"
              class="flex items-center space-x-3 py-2 text-sm sm:text-base"
            >
              <span class="material-symbols-outlined">event_busy</span>
              <span>Expired Products</span>
            </SidebarNavLink>
          </div>
          <div>
            <SidebarNavLink
              :href="route('admin.activity.index')"
              :active="route().current('admin.activity.index')"
              class="flex items-center space-x-3 py-2 text-sm sm:text-base"
            >
              <span class="material-symbols-outlined">history</span>
              <span>Activity log</span>
            </SidebarNavLink>
          </div>
        </nav>
      </div>
    </div>

    <div
      v-if="isSidebarOpen"
      class="fixed inset-0 bg-black opacity-50 z-100 lg:hidden"
      @click="toggleSidebar"
    ></div>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col lg:ml-72">
      <!-- Header -->
      <header class="flex items-center justify-between bg-white border-b p-4">
        <div class="flex items-center space-x-4">
          <button
            class="text-gray-500 focus:outline-none lg:hidden"
            @click="toggleSidebar"
            aria-label="Toggle Sidebar"
            aria-expanded="isSidebarOpen"
          >
            <svg
              class="h-6 w-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              ></path>
            </svg>
          </button>
          <div>
            <p class="font-semibold text-lg text-gray-800 leading-tight">Administrator</p>
          </div>
        </div>

        <div class="flex space-x-3 items-center">
          <!-- <div>
            <span class="text-gray-500 text-sm cpaitalize">
            switch to
            <Link :href="route('dispensary.dashboard.index')" class="text-gray-800 font-bold text-md">Dispensary</Link>
            </span>
          </div> -->
          <!-- Settings Dropdown -->
          <div class="relative">
            <Dropdown align="right" width="48">
              <template #trigger>
                <span class="inline-flex rounded-md">
                  <button
                    type="button"
                    class="inline-flex items-center p-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-transparent hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <span class="material-symbols-outlined"> account_circle </span>

                    <svg
                      class="-me-0.5 h-4 w-4"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                    >
                      <path
                        fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd"
                      />
                    </svg>
                  </button>
                </span>
              </template>

              <template #content>
                <DropdownLink
                  :href="route('admin.profile.edit')"
                  class="inline-flex items-center"
                >
                  <span class="material-symbols-outlined me-1"> person </span> Profile
                </DropdownLink>
                <DropdownLink
                  :href="route('logout')"
                  method="post"
                  as="button"
                  class="inline-flex items-center"
                >
                  <span class="material-symbols-outlined me-1"> logout </span>
                  Log Out
                </DropdownLink>
              </template>
            </Dropdown>
          </div>
        </div>
      </header>

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
  </div>
</template>
