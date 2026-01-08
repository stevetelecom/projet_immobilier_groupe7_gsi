<template>
  <GuestLayout title="Biens disponibles">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold mb-4">Trouvez votre bien idéal</h1>
        <p class="text-xl text-blue-100">{{ properties.total }} biens disponibles</p>
      </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <!-- Filtres -->
      <div class="bg-white rounded-lg shadow-sm p-6 mb-8">
        <form @submit.prevent="applyFilters" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <!-- Type de bien -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Type de bien</label>
            <select v-model="filterForm.type" class="w-full rounded-md border-gray-300">
              <option value="">Tous les types</option>
              <option v-for="(label, value) in propertyTypes" :key="value" :value="value">
                {{ label }}
              </option>
            </select>
          </div>

          <!-- Ville -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Ville</label>
            <input 
              v-model="filterForm.city" 
              type="text" 
              placeholder="Ex: Yaoundé"
              class="w-full rounded-md border-gray-300"
            />
          </div>

          <!-- Prix minimum -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Prix min (FCFA)</label>
            <input 
              v-model.number="filterForm.min_price" 
              type="number" 
              placeholder="0"
              class="w-full rounded-md border-gray-300"
            />
          </div>

          <!-- Prix maximum -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Prix max (FCFA)</label>
            <input 
              v-model.number="filterForm.max_price" 
              type="number" 
              placeholder="1000000"
              class="w-full rounded-md border-gray-300"
            />
          </div>

          <!-- Nombre de pièces -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Pièces min</label>
            <select v-model.number="filterForm.rooms" class="w-full rounded-md border-gray-300">
              <option value="">Indifférent</option>
              <option :value="1">1+</option>
              <option :value="2">2+</option>
              <option :value="3">3+</option>
              <option :value="4">4+</option>
            </select>
          </div>

          <!-- Tri -->
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Trier par</label>
            <select v-model="filterForm.sort" class="w-full rounded-md border-gray-300">
              <option value="created_at">Plus récents</option>
              <option value="price_per_month">Prix</option>
              <option value="rooms">Nombre de pièces</option>
            </select>
          </div>

          <!-- Boutons -->
          <div class="flex items-end gap-2 lg:col-span-2">
            <button 
              type="submit"
              class="flex-1 bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700"
            >
              Rechercher
            </button>
            <button 
              type="button"
              @click="resetFilters"
              class="px-4 py-2 border border-gray-300 rounded-md hover:bg-gray-50"
            >
              Réinitialiser
            </button>
          </div>
        </form>
      </div>

      <!-- Liste des biens -->
      <div v-if="properties.data.length > 0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <PropertyCard 
          v-for="property in properties.data" 
          :key="property.id"
          :property="property"
        />
      </div>

      <!-- Aucun résultat -->
      <div v-else class="text-center py-12">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Aucun bien trouvé</h3>
        <p class="mt-1 text-sm text-gray-500">Essayez de modifier vos critères de recherche.</p>
      </div>

      <!-- Pagination -->
      <div v-if="properties.data.length > 0" class="mt-8">
        <Pagination :links="properties.links" />
      </div>
    </div>
  </GuestLayout>
</template>

<script setup>
import { ref, reactive } from 'vue'
import { router } from '@inertiajs/vue3'
import GuestLayout from '@/Components/Layout/GuestLayout.vue'
import PropertyCard from '@/Components/Properties/PropertyCard.vue'
import Pagination from '@/Components/Common/Pagination.vue'

const props = defineProps({
  properties: Object,
  propertyTypes: Object,
  filters: Object
})

const filterForm = reactive({
  type: props.filters.type || '',
  city: props.filters.city || '',
  min_price: props.filters.min_price || '',
  max_price: props.filters.max_price || '',
  rooms: props.filters.rooms || '',
  sort: props.filters.sort || 'created_at',
  order: props.filters.order || 'desc'
})

const applyFilters = () => {
  router.get(route('properties.public.index'), filterForm, {
    preserveState: true,
    preserveScroll: true
  })
}

const resetFilters = () => {
  router.get(route('properties.public.index'))
}
</script>