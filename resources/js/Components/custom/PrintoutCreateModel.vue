<template>
  <div v-if="open" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
    <div class="w-full max-w-2xl p-6 bg-white rounded-lg shadow-xl">
      <h2 class="mb-4 text-2xl font-bold">Create Printout</h2>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
          <input
            v-model="form.title"
            type="text"
            id="title"
            required
            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          />
          <span v-if="form.errors.title" class="text-sm text-red-500">{{ form.errors.title }}</span>
        </div>

        <div>
          <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
          <textarea
            v-model="form.description"
            id="description"
            rows="3"
            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          ></textarea>
          <span v-if="form.errors.description" class="text-sm text-red-500">{{ form.errors.description }}</span>
        </div>

        <div class="grid grid-cols-2 gap-4">
          <div>
            <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
            <input
              v-model="form.price"
              type="number"
              step="0.01"
              id="price"
              required
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            />
            <span v-if="form.errors.price" class="text-sm text-red-500">{{ form.errors.price }}</span>
          </div>

          <div>
            <label for="stock_quantity" class="block text-sm font-medium text-gray-700">Stock Quantity</label>
            <input
              v-model="form.stock_quantity"
              type="number"
              id="stock_quantity"
              required
              class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
            />
            <span v-if="form.errors.stock_quantity" class="text-sm text-red-500">{{ form.errors.stock_quantity }}</span>
          </div>
        </div>

        <div>
          <label for="default_quantity" class="block text-sm font-medium text-gray-700">Default Quantity</label>
          <input
            v-model="form.default_quantity"
            type="number"
            id="default_quantity"
            required
            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
          />
          <span v-if="form.errors.default_quantity" class="text-sm text-red-500">{{ form.errors.default_quantity }}</span>
        </div>

        <div class="flex justify-end space-x-3">
          <button
            type="button"
            @click="closeModal"
            class="px-4 py-2 text-gray-700 bg-gray-300 rounded hover:bg-gray-400"
          >
            Cancel
          </button>
          <button
            type="submit"
            :disabled="form.processing"
            class="px-4 py-2 text-white bg-blue-500 rounded hover:bg-blue-600 disabled:opacity-50"
          >
            Save
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const props = defineProps({
  open: Boolean,
});

const emit = defineEmits(['update:open']);

const form = useForm({
  title: '',
  description: '',
  price: 0.00,
  stock_quantity: 0,
  default_quantity: 1,
});

const submit = () => {
  form.post(route('printouts.store'), {
    preserveScroll: true,
    onSuccess: () => {
      closeModal();
      form.reset();
    },
  });
};

const closeModal = () => {
  emit('update:open', false);
};
</script>