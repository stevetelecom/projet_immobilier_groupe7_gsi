<template>
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Galerie photos</h3>
            <span class="text-sm text-gray-600">{{ photos.length }} photo{{ photos.length > 1 ? 's' : '' }}</span>
        </div>

        <!-- Zone de upload -->
        <div class="mb-6">
            <label
                class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:border-indigo-500 hover:bg-gray-50 transition-colors duration-200"
                :class="{ 'border-indigo-500 bg-indigo-50': isDragging }"
                @dragover.prevent="isDragging = true"
                @dragleave.prevent="isDragging = false"
                @drop.prevent="handleDrop"
            >
                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                    <svg class="w-12 h-12 mb-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <p class="mb-2 text-sm text-gray-600">
                        <span class="font-semibold">Cliquez pour télécharger</span> ou glissez-déposez
                    </p>
                    <p class="text-xs text-gray-500">PNG, JPG ou JPEG (MAX. 5MB par fichier)</p>
                </div>
                <input
                    ref="fileInput"
                    type="file"
                    multiple
                    accept="image/png,image/jpeg,image/jpg"
                    class="hidden"
                    @change="handleFileSelect"
                />
            </label>
        </div>

        <!-- Galerie de photos -->
        <div v-if="photos.length > 0" class="space-y-4">
            <!-- Message info -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-3 text-sm text-blue-800">
                <div class="flex items-start">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <span>Cliquez sur une photo pour la définir comme photo principale</span>
                </div>
            </div>

            <!-- Grille de photos -->
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div
                    v-for="(photo, index) in photos"
                    :key="photo.id || index"
                    class="relative group aspect-square rounded-lg overflow-hidden border-2 transition-all duration-200 cursor-pointer"
                    :class="photo.is_primary ? 'border-indigo-600 ring-2 ring-indigo-600' : 'border-gray-200 hover:border-indigo-400'"
                    @click="setPrimaryPhoto(photo)"
                >
                    <!-- Image -->
                    <img
                        :src="getPhotoUrl(photo)"
                        :alt="`Photo ${index + 1}`"
                        class="w-full h-full object-cover"
                    />

                    <!-- Badge photo principale -->
                    <div
                        v-if="photo.is_primary"
                        class="absolute top-2 left-2 bg-indigo-600 text-white text-xs font-semibold px-2 py-1 rounded-full flex items-center"
                    >
                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                        </svg>
                        Principale
                    </div>

                    <!-- Overlay avec actions -->
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-40 transition-all duration-200 flex items-center justify-center opacity-0 group-hover:opacity-100">
                        <button
                            @click.stop="deletePhoto(photo, index)"
                            class="bg-red-600 hover:bg-red-700 text-white p-2 rounded-full transition-colors duration-200"
                            title="Supprimer"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Indicateur de chargement -->
                    <div
                        v-if="photo.uploading"
                        class="absolute inset-0 bg-white bg-opacity-90 flex items-center justify-center"
                    >
                        <div class="text-center">
                            <svg class="animate-spin h-8 w-8 text-indigo-600 mx-auto mb-2" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span class="text-xs text-gray-600">Upload...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- État vide -->
        <div v-else class="text-center py-12">
            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="mt-4 text-sm text-gray-600">Aucune photo pour le moment</p>
            <p class="mt-1 text-xs text-gray-500">Ajoutez des photos pour présenter votre bien</p>
        </div>

        <!-- Messages d'erreur -->
        <div v-if="uploadErrors.length > 0" class="mt-4 space-y-2">
            <div
                v-for="(error, index) in uploadErrors"
                :key="index"
                class="bg-red-50 border border-red-200 rounded-lg p-3 text-sm text-red-800 flex items-start"
            >
                <svg class="w-5 h-5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                </svg>
                <span>{{ error }}</span>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    propertyId: {
        type: [Number, String],
        required: true
    },
    photos: {
        type: Array,
        default: () => []
    }
});

const emit = defineEmits(['photos-updated']);

const fileInput = ref(null);
const isDragging = ref(false);
const uploadErrors = ref([]);

const handleFileSelect = (event) => {
    const files = Array.from(event.target.files);
    uploadPhotos(files);
    event.target.value = ''; // Reset input
};

const handleDrop = (event) => {
    isDragging.value = false;
    const files = Array.from(event.dataTransfer.files).filter(file => 
        file.type.startsWith('image/')
    );
    uploadPhotos(files);
};

const uploadPhotos = async (files) => {
    uploadErrors.value = [];

    // Validation
    const validFiles = [];
    files.forEach(file => {
        if (!file.type.match('image/(png|jpeg|jpg)')) {
            uploadErrors.value.push(`${file.name} : Format non supporté (utilisez PNG ou JPEG)`);
            return;
        }
        if (file.size > 5 * 1024 * 1024) {
            uploadErrors.value.push(`${file.name} : Fichier trop volumineux (max 5MB)`);
            return;
        }
        validFiles.push(file);
    });

    if (validFiles.length === 0) return;

    // Upload via Inertia
    const formData = new FormData();
    validFiles.forEach(file => {
        formData.append('photos[]', file);
    });

    router.post(
        route('properties.photos.upload', props.propertyId),
        formData,
        {
            preserveScroll: true,
            onSuccess: () => {
                emit('photos-updated');
            },
            onError: (errors) => {
                if (errors.photos) {
                    uploadErrors.value.push(errors.photos);
                }
            }
        }
    );
};

const setPrimaryPhoto = (photo) => {
    if (photo.is_primary) return;

    router.patch(
        route('properties.photos.primary', { 
            property: props.propertyId, 
            photo: photo.id 
        }),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                emit('photos-updated');
            }
        }
    );
};

const deletePhoto = (photo, index) => {
    if (!confirm('Êtes-vous sûr de vouloir supprimer cette photo ?')) {
        return;
    }

    // Si c'est une photo déjà enregistrée
    if (photo.id) {
        router.delete(
            route('properties.photos.delete', { 
                property: props.propertyId, 
                photo: photo.id 
            }),
            {
                preserveScroll: true,
                onSuccess: () => {
                    emit('photos-updated');
                }
            }
        );
    }
};

const getPhotoUrl = (photo) => {
    // Si c'est une URL complète
    if (photo.url && photo.url.startsWith('http')) {
        return photo.url;
    }
    // Si c'est un path
    if (photo.path) {
        return `/storage/${photo.path}`;
    }
    // Si c'est juste l'URL
    return photo.url || photo;
};
</script>
