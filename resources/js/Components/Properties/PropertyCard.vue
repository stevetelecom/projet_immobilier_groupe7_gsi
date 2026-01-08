<template>
  <Link 
    :href="route('properties.public.show', property.id)"
    class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow"
  >
    <!-- Image -->
    <div class="aspect-video bg-gray-200 relative">
      <img 
        v-if="property.primary_image"
        :src="`/storage/${property.primary_image.image_path}`"
        :alt="property.title"
        class="w-full h-full object-cover"
      />
      <div v-else class="w-full h-full flex items-center justify-center">
        <svg class="h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
        </svg>
      </div>
      
      <!-- Badge type -->
      <div class="absolute top-2 right-2 bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-medium">
        {{ typeLabel }}
      </div>
    </div>

    <!-- Contenu -->
    <div class="p-4">
      <h3 class="font-semibold text-lg text-gray-900 mb-2 line-clamp-2">
        {{ property.title }}
      </h3>

      <div class="flex items-center text-gray-500 text-sm mb-3">
        <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        {{ property.city }}
      </div>

      <!-- Caractéristiques -->
      <div class="flex items-center gap-4 text-sm text-gray-600 mb-4">
        <span class="flex items-center">
          <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1H5a1 1 0 01-1-1v-3zM14 16a1 1 0 011-1h4a1 1 0 011 1v3a1 1 0 01-1 1h-4a1 1 0 01-1-1v-3z" />
          </svg>
          {{ property.rooms }} pièces
        </span>
        <span class="flex items-center">
          {{ property.surface_area }} m²
        </span>
      </div>

      <!-- Prix -->
      <div class="flex items-end justify-between">
        <div>
          <div class="text-2xl font-bold text-blue-600">
            {{ formatCurrency(property.price_per_month) }}
          </div>
          <div class="text-sm text-gray-500">FCFA/mois</div>
        </div>
        <span class="text-blue-600 font-medium">Voir détails →</span>
      </div>
    </div>
  </Link>
</template>

<script setup>
import { computed } from 'vue'
import { Link } from '@inertiajs/vue3'

const props = defineProps({
  property: Object
})

const typeLabel = computed(() => {
  const types = {
    apartment: 'Appartement',
    house: 'Maison',
    studio: 'Studio',
    villa: 'Villa',
    office: 'Bureau',
    commercial: 'Commercial'
  }
  return types[props.property.type] || props.property.type
})

const formatCurrency = (value) => {
  return new Intl.NumberFormat('fr-FR').format(value)
}
</script>