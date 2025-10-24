<!-- resources/js/Pages/Printouts/Index.vue -->
<template>
  <Head title="Printouts" />
  <Banner />

  <div class="flex flex-col items-center justify-start min-h-screen py-8 space-y-8 bg-gray-100 px-6 md:px-36">
    <!-- Header -->
    <Header />

    <div class="w-full md:w-5/6 py-12 space-y-10">
      <!-- Title row -->
      <div class="flex w-full items-center justify-between">
        <div class="flex items-center w-full h-16 space-x-4 rounded-2xl">
          <Link href="/">
            <img src="/images/back-arrow.png" class="w-12 h-12" alt="Back" />
          </Link>
          <p class="text-4xl font-bold tracking-wide text-black uppercase">Printouts</p>
        </div>
      </div>

      <!-- Table -->
      <template v-if="printouts && printouts.length">
        <div class="overflow-x-auto">
          <table
            id="PrintoutTable"
            class="w-full text-gray-700 bg-white border border-gray-300 rounded-lg shadow-md table-auto"
          >
            <thead>
              <tr
                class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 text-[16px] text-white border-b border-blue-700 text-left"
              >
                <th class="p-4 font-semibold tracking-wide uppercase">Name</th>
                <th class="p-4 font-semibold tracking-wide uppercase">Price</th>
                <th class="p-4 font-semibold tracking-wide uppercase">Quantity</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(printout, index) in printouts" :key="printout.id" class="hover:bg-gray-100">
                <td class="border px-4 py-2">{{ printout.name }}</td>
                <td class="border px-4 py-2">{{ formatAmount(printout.price) }}</td>
                <td class="border px-4 py-2">{{ printout.quantity }}</td>
              </tr>
            </tbody>
          </table>
        </div>
      </template>

      <template v-else>
        <div class="col-span-4 text-center">
          <p class="text-center text-red-500 text-[17px]">No Printouts Available</p>
        </div>
      </template>
    </div>
  </div>

  <Footer />
</template>

<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import Header from '@/Components/custom/Header.vue';
import Footer from '@/Components/custom/Footer.vue';
import Banner from '@/Components/Banner.vue';
import { HasRole } from '@/Utils/Permissions';

const props = defineProps({
  printouts: { type: Array, default: () => [] },
});

/** Roles */
const isAdmin = computed(() => HasRole(['Admin']));
const canEdit = computed(() => HasRole(['Admin']));               // Edit: Admin only
const canDelete = computed(() => HasRole(['Admin', 'Manager']));  // Delete: Admin or Manager

/** Modals/state */
const isCreateModalOpen = ref(false);
const isEditModalOpen = ref(false);
const isDeleteModalOpen = ref(false);
const selectedPrintout = ref(null);

/** Handlers */
const openCreate = () => {
  if (isAdmin.value) isCreateModalOpen.value = true;
};

const openEditModal = (printout) => {
  selectedPrintout.value = printout;
  isEditModalOpen.value = true;
};

const openDeleteModal = (printout) => {
  selectedPrintout.value = printout;
  isDeleteModalOpen.value = true;
};

// Guarded click handlers (prevents bypass even if someone removes disabled in DOM)
const onEdit = (printout) => {
  if (!canEdit.value) return;
  openEditModal(printout);
};

const onDelete = (printout) => {
  if (!canDelete.value) return;
  openDeleteModal(printout);
};

/** Formatters */
const formatAmount = (a) => {
  if (a === null || a === undefined || a === '') return '0.00';
  const n = Number(a);
  if (isNaN(n)) return a;
  return n.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
};

/** DataTables */
let dt = null;
onMounted(() => {
  if (typeof window !== 'undefined' && window.$ && typeof window.$.fn?.dataTable !== 'undefined') {
    dt = window.$('#PrintoutTable').DataTable({
      dom: 'Bfrtip',
      pageLength: 10,
      buttons: [],
      columnDefs: [
        { targets: [4], searchable: false },
        { targets: [5], orderable: false },
      ],
      initComplete: function () {
        const searchInput = window.$('div.dataTables_filter input');
        searchInput.attr('placeholder', 'Search ...');
      },
      language: { search: '' },
    });
  }
});

onBeforeUnmount(() => {
  if (dt) {
    dt.destroy(true);
    dt = null;
  }
});
</script>

<style>
/* General DataTables Pagination Container Style */
.dataTables_wrapper .dataTables_paginate {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-top: 20px;
}

/* Style the filter container */
#PrintoutTable_filter {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  margin-bottom: 16px;
  float: left; /* mirrors your previous layout */
}

/* Style the label and input field inside the filter */
#PrintoutTable_filter label {
  font-size: 17px;
  display: flex;
  align-items: center;
}

/* Style the input field */
#PrintoutTable_filter input[type="search"] {
  font-weight: 400;
  padding: 9px 15px;
  font-size: 14px;
  border: 1px solid rgb(209 213 219);
  border-radius: 5px;
  background: #fff;
  outline: none;
  transition: all 0.2s ease;
}

#PrintoutTable_filter input[type="search"]:focus {
  outline: none;
  border: 1px solid #4b5563;
  box-shadow: none;
}

.dataTables_wrapper {
  margin-bottom: 10px;
}
</style>
